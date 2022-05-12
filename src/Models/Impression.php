<?php

namespace Jangaraev\LaravelImpressionable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Impression extends Model
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

    public function impressionable(): MorphTo
    {
        return $this->morphTo();
    }
}
