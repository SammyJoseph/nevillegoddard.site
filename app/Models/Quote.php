<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['quote', 'bible_verse', 'source', 'source_type_id'];

    public function sourceType()
    {
        return $this->belongsTo(SourceType::class);
    }
}
