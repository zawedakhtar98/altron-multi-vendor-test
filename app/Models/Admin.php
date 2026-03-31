<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authentication;
use Laravel\Passport\HasApiTokens;

class Admin extends Authentication
{
    use HasApiTokens;
    protected $guarded = [];
    public $table= 'users';
}
