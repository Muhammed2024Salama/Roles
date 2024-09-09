<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootUuid()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Indicates if the model's primary key is auto-incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the data type of the primary key.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
