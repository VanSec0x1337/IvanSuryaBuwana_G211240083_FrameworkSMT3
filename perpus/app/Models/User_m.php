<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User_m extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password'];
    public $timestamps = false;
}
