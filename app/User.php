<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER_VERIFICADO    = '1';
    const USER_NO_VERIFICADO = '0';

    const USER_ADMIN    = 'true';
    const USER_REGULAR  = 'false';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays in responses.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];




    public function esVerificado()
    {
        return $this -> verified == User::USER_VERIFICADO;
    }

    public function esAdmin()
    {
        return $this -> admin == User::USER_ADMIN;
    }

    public function generarVerificationToken()
    {
        return str_random(50);
    }
}
