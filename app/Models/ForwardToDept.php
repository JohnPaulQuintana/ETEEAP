<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForwardToDept extends Model
{
    use HasFactory;

    protected $fillable = ['receiver_id', 'document_id', 'isForwarded'];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // public function documents() :BelongsTo{
    //     return $this->belongsTo(Document::class);
    // }
}
