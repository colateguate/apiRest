<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;

class buyerController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();

        return $this -> showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);

        $this -> showOne($buyer);
    }
}
