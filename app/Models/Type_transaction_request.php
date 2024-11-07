<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Type_transaction_request extends Model
{
    // use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];


}
