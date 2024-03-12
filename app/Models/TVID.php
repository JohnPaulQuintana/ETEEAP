<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TVID extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'tvid'];

    public function document() :BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
