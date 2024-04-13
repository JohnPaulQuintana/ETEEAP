<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionRequired extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'action_required'];

    public function document() :BelongsTo{
        return $this->belongsTo(Document::class);
    }
}
