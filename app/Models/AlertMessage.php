<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertMessage extends Model
{
    use HasFactory;

    protected $fillable = ['reciever_id', 'sender_id', 'notification'];
}
