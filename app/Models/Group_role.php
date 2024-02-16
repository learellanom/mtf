<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class Group_role extends Model
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;
    use Notifiable, HasRoles;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //Relación uno a muchos 
    public function role(){
        return $this->belongsTo(role::class, 'role_id');
    }
    //Relación uno a muchos
    public function group(){
        return $this->belongsTo(group::class, 'group_id');
    }

}
