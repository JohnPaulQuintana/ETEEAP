<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepartmentComment extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id','forward_to_depts_id', 'document_name', 'department_comment'];

    public function forwardToDept() :BelongsTo{
        return $this->belongsTo(ForwardToDept::class, 'forward_to_depts_id');
    }
}
