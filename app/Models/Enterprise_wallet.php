<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise_wallet extends Model
{
    use HasFactory;

    public function enterprise(){
        return $this->belongsTo(Enterprise::class,'id','enterprise_id');
    }

    public function group(){
        return $this->belongsTo(Group::class,'id','group_id');
    }

}
