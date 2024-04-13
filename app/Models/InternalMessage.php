<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternalMessage extends Model
{
    use HasFactory;
    protected $fillable = ['document_id','user_id', 'sender_id','message', 'action_required', 'message_type'];

    public function document() :BelongsTo{
        return $this->belongsTo(Document::class);
    }
}
