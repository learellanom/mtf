<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Wallet extends Model  implements Auditable
{
        use \OwenIt\Auditing\Auditable;
        use HasApiTokens, HasFactory, Notifiable, HasRoles;

        protected $table = 'wallets';

        protected $guarded = ['id', 'created_at', 'updated_at'];


              //Relación muchos a muchos
          /*   public function user(){
                return $this->belongsToMany(User::class);
            } */
            //Relación muchos a muchos
            public function user(){
                return $this->belongsToMany(User::class);
            }

            //Relación uno a muchos
            public function transaction(){
                return $this->hasMany(Transaction::class);
            }

            //Relación uno a muchos
            public function transaction_master(){
                return $this->hasMany(Transaction_master::class);
            }

            public function supplier(){
                return $this->belongsToMany(supplier::class);
            }



}
