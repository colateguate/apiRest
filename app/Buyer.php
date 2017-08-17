<?php

namespace App;

use App\Transaction;

class Buyer extends User
{
	//Nombre de la relacion entre comprador y transacciones
    public function transactions()
    {
    	return $this -> hasMany(Transaction::class);
    }
}
