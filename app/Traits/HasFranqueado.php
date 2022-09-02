<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasFranqueado
{
    public static function bootHasFranqueado()
    {
        if (Auth::check() && Auth::user()->franqueado_id != null) {
            static::creating(function ($model) {
                $model->franqueado_id = auth()->user()->franqueado_id;
            });

            static::updating(function ($model) {
               logger(json_encode($model, JSON_PRETTY_PRINT));
            });

            static::addGlobalScope('has_franqueado', function ($builder) {
                $builder->where('franqueado_id', Auth::user()->franqueado_id);
            });
        }
    }
}
