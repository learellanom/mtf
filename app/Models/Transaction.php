<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class Transaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function type_coin(){
        return $this->belongsTo(Type_coin::class);
    }
       //Relación uno a muchos
    public function type_transaction(){
        return $this->belongsTo(Type_transaction::class);
    }
       //Relación uno a muchos
    public function wallet(){
        return $this->belongsTo(wallet::class);
    }
        //Relación uno a muchos
    public function user(){
        return $this->belongsTo(user::class);
    }
        //Relación uno a muchos
    public function client(){
        return $this->belongsTo(client::class);
    }

         //Relación uno a muchos
    public function group(){
        return $this->belongsTo(group::class);
    }

    //Relación uno a muchos Polimorfica
    public function image(){
        return $this->morphMany(image::class,'imageable');
    }


}
