<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['name', 'source_type_id'];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function sourceType()
    {
        return $this->belongsTo(SourceType::class);
    }
}
