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

    protected $table = 'users';


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

    /*Clasicos getters y setters pero solo para los que necesitan tratamiento especieal. Por ejemplo, los usuariosy em mail  los guardaremos siempre en 
    minúsucula en la bbdd pero a la hora de mostrarlos cuando los recuperamos les 
    pondremos, solo al nombre, la primera en mayúscula*/
    public function setNameAttribute($name)
    {
        $this -> attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this -> attributes['email'] = strtolower($email);
    }

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

    public static function generarVerificationToken()
    {
        return str_random(50);
    }
}
