<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastSender extends Model
{
    use HasFactory;

    protected $fillable = ['last_sender', 'document_id'];
}
