<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceType extends Model
{
    protected $fillable = ['name'];

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function quotes()
    {
        return $this->hasManyThrough(Quote::class, Source::class);
    }
}
