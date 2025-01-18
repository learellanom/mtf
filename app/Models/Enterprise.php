<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Enterprise extends Model  implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    use HasFactory, HasFactory, Notifiable, HasRoles;


    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relación uno a muchos
    public function enterprise_wallets(){
        return $this->hasMany(Enterprise_wallet::class,'enterprise_id');
    }


}
