<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarkAsEndorsed extends Model
{
    use HasFactory;
    protected $fillable = ['document_id', 'receiver_id'];

    public function document() :BelongsTo{
        return $this->belongsTo(Document::class);
    }
}
