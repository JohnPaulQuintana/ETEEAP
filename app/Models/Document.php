<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reciever_id','isForwarded' ,'loi', 'ce', 'cr', 'nce','hdt','f137_8','abcb','mc','nbc','ge','pc','rl','cgmc', 'cer'];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function status() :HasMany{
        return $this->hasMany(Status::class);
    }
    public function tvids() :HasMany{
        return $this->hasMany(TVID::class);
    }

    public function history() :HasMany{
        return $this->hasMany(History::class);
    }
    public function checked() :HasMany{
        return $this->hasMany(CheckingDocument::class);
    }

    // public function forwarded() :HasMany{
    //     return $this->hasMany(ForwardToDept::class);
    // }
}
