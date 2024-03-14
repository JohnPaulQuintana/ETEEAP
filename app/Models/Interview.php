<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'interviewer', 'date', 'time', 'location', 'what_to_bring', 'interviewed'];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }
}
