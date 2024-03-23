<?php

namespace App\Models;

use App\Models\CheckingDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReuploadDocument extends Model
{
    use HasFactory;
    protected $fillable = ['checking_document_id', 'reupload_description', 'path'];

    public function reupload() :BelongsTo{
        return $this->belongsTo(CheckingDocument::class);
    }
}
