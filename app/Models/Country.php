<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * @var array<string>
     */
    public array $translatedAttributes = ['title', 'content'];

    protected $fillable = [
        'code',
    ];
}
