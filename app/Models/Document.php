<?php

namespace App\Models;

use App\Models\ActionRequired;
use App\Models\MarkAsEndorsed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reciever_id','course_id','educational_attainment','isForwarded' ,'loi', 'ce', 'cr', 'nce','hdt','f137_8','abcb','mc','nbc','ge','pc','rl','cgmc', 'cer'];

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

    public function internal() :HasMany{
        return $this->hasMany(InternalMessage::class);
    }

    public function action() :HasOne{
        return $this->hasOne(ActionRequired::class);
    }
    public function forwardedTo() :HasMany{
        return $this->hasMany(MarkAsEndorsed::class);
    }
}
