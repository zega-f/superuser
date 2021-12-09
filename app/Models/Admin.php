<?php
namespace App;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticable;
// use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
    use HasFactory,Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = ['password'];

    
}
