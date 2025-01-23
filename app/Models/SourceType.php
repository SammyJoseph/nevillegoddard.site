<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceType extends Model
{
    protected $fillable = ['name'];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
