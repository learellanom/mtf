<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  /*   public function generateTags(): array
    {
        return [
             // auth()->user()->name,
             //auth()->user()->email
        ];
    } */

     //Relación uno a muchos
     public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    //Relación uno a muchos
    public function transaction_master(){
        return $this->hasMany(Transaction_master::class);
    }

     //Relación uno a muchos
     public function wallet(){
        return $this->belongsToMany(Wallet::class);
    }

    //Relación uno a muchos
    public function group(){
        return $this->belongsToMany(Group::class);
    }


}


?>
