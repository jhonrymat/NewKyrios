<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['nama', 'alamat', 'email', 'telepon'];

    protected $hidden = ['created_at', 'updated_at'];
}
