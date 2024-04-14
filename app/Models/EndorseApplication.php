<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndorseApplication extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'receiver_id'];
}
