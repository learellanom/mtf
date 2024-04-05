<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials_balance extends Model
{

    protected $table = "materials_balance";

    use HasFactory;

    public function type_transaction(){
        return $this->belongsTo(Type_transaction::class);
    }
    
    public function type_material(){
        return $this->belongsTo(Type_transaction::class);
    }
    
    
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

}
