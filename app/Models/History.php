<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class History extends Model
{
    use HasFactory;
    protected $fillable = ['document_id', 'requirements', 'status', 'notes'];

    public function document() : BelongsTo{
        return $this->belongsTo(Document::class);
    }
}
