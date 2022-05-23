<?php

namespace Jangaraev\LaravelImpressionable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Impression extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;


    public function impressionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function dailyHits(): HasMany
    {
        return $this->hasMany(ImpressionDailyHit::class);
    }


    public function getImpressionsAttribute(): int
    {
        return $this->value ?? 0;
    }
}
