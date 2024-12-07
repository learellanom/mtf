<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_request extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    //Relación uno a muchos
    public function group(){
        return $this->belongsTo(group::class, 'group_id');
    }

    //Relación uno a muchos
    public function type_coin(){
        return $this->belongsTo(Type_coin::class);
    }
    //Relación uno a muchos
    public function type_transaction_requests(){
        return $this->belongsTo(Type_transaction::class);
    }    
}
