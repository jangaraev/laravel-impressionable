<?php

namespace Jangaraev\LaravelImpressionable\Traits;

use Jangaraev\EloquentModelAdvisoryLock\AppliesAdvisoryLock;
use Jangaraev\LaravelImpressionable\Models\Impression;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CountsImpressions
{
    use AppliesAdvisoryLock;

    public function morphImpressions(): MorphMany
    {
        return $this->morphMany(Impression::class, 'impressionable');
    }

    public function todaysImpressions(): MorphMany
    {
        return $this->morphImpressions()
            ->where('date', now()->toDateString())
            ->where('ip', ip2long(request()->ip()));
    }


    public function incrementImpressions(): bool
    {
        if (!userAgentIsBot() && $this->todaysImpressions->isEmpty()) {
            $result = (bool)$this->increment('impressions');

            static::advisoryLock(fn () => $this->morphImpressions()->firstOrCreate());

            return $result;
        }

        return false;
    }
}
