<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['quote', 'bible_verse', 'status', 'source_id'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
