<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

class Client extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    //Relación uno a muchos
    public function transaction_master(){
        return $this->hasMany(Transaction_master::class);
    }

    /*  //Relación uno a muchos
     public function group(){
        return $this->hasMany(Group::class);
    } */


}
