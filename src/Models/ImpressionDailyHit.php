<?php

namespace Jangaraev\LaravelImpressionable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpressionDailyHit extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;


    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->ip = ip2long(request()->ip());
            $model->date = now()->toDateString();
        });
    }

    public function impression(): BelongsTo
    {
        return $this->belongsTo(Impression::class);
    }
}
