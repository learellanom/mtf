<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Client;

class Group extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos
    public function client(){
        return $this->hasMany(Client::class);
    }
}
