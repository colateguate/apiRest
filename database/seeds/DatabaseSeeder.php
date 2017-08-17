<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Desactivamos comprobación de claves foráneas
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    	//Truncamos las tablas
     	User::truncate();
     	Category::truncate();
     	Product::truncate();
     	Transaction::truncate();

     	//category_product la truncamos a través de DB puesto que no tiene modelo asociado
     	DB::table('category_product')->truncate();
 		

 		$cantidadUsuarios 		= 200;
 		$cantidadCategorias 	= 30;
 		$cantidadProductos 		= 1000;
 		$cantidadTransacciones  = 1000;

 		//Creamos los datos llamando a los factory
 		factory(User::class, $cantidadUsuarios)->create();
 		factory(Category::class, $cantidadCategorias)->create();

 		factory(Product::class, $cantidadProductos)->create()->each(function($producto){
 			//La funcion pluck especifica que atributos queremos que retorne
 			$categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
 			$producto ->categories()->attach($categorias);
 		});

 		factory(Transaction::class, $cantidadTransacciones)->create();
    }
}
