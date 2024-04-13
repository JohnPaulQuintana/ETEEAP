<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDocument extends Model
{
    use HasFactory;

    protected $fillable = ['document_id','document_name','path'];
}
