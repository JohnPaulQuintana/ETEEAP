<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckingDocument extends Model
{
    use HasFactory;
    protected $fillable = ['document_id', 'sub_name', 'requirements', 'description', 'action'];

    public function document() :BelongsTo{
        return $this->belongsTo(Document::class);
    }
}
