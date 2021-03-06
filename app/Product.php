<?php

namespace App;

use App\Seller;
use App\Transaction;
use App\Category;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	const PRODUCTO_DISPONIBLE 	 = 'disponible';
	const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $fillalbe = [
    	'name',
    	'description',
    	'quantity',
    	'stauts',
    	'image',
    	'seller_id',
    ];

    public function estaDisponible()
    {
    	return $this -> status == Product::PRODUCTO_DISPONIBLE;
    }

    public function seller()
    {
        return $this -> belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this -> hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this -> belongsToMany(Category::class);
    }
}
