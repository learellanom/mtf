<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commissions_usdt extends Model
{

    protected $table = "commissions_usdt";
    
    use HasFactory;



    //Relación uno a muchos
    public function type_transaction(){
        return $this->belongsTo(Type_transaction::class);
    }
    //Relación uno a muchos
    public function user(){
        return $this->belongsTo(user::class);
    }
    //Relación uno a muchos
    public function group(){
        return $this->belongsTo(group::class, 'group_id');
    }

    public function wallet() {
        return $this->belongsTo(group::class, 'wallet_id');
    }

    //Relación uno a muchos
    public function type_coin_balance(){
        return $this->belongsTo(Type_coin::class,'type_coin_balance_id');
    }

}
