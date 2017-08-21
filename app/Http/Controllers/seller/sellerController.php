<?php

namespace App\Http\Controllers\seller;

use App\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;

class sellerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();

        return $this -> showAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Busca al user que tenga products(condicion de seller) y que tenga el id $id
        $seller = Seller::has('products')->findOrFail($id);

        return $this -> showOne($seller);
    }
}
