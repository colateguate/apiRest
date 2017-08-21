<?php

namespace App\Http\Controllers\user;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;

class userController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();

        return $this -> showAll($usuarios);
    }

    /**
     * Crea un usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglasValidacion = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        //Si pasa las reglas continua sino lanza una excepcion
        $this -> validate($request, $reglasValidacion);

        //Asignamos los valores de la peticion a campos
        $campos = $request -> all();

        //Valores por defecto de campos sensibles al crear un usuario
        $campos['password']           = bcrypt($request -> password);
        $campos['verified']           = User::USER_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin']              = User::USER_REGULAR;

        //Creamos al usuario con los campos que llegan de la peticion
        $usuario = User::create($campos);

        //status 201: Se ha almacenado OK
        return $this -> showOne($usuario, 201);
    }

    /**
     * retorna un usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return $this -> showOne($usuario);
    }

    /**
     * Actualiza un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //User que queremos actualizar
        $userParaActualizar = User::findOrFail($id);

        $reglasValidacion = [
            //reglas del mail para que el propio user pueda cambiar el mail. Mira que el campo mail de la tabla users sea unico sin contar el mail del userParaActualizar -> id
            'email' => 'email|unique:users,email,'.$userParaActualizar -> id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:'.User::USER_ADMIN.', '.User::USER_REGULAR,
        ];

        $this -> validate($request, $reglasValidacion);

        //Comprobamos si la peticion tiene un campo llamado name
        if($request->has('name'))
        {
            $userParaActualizar -> name = $request -> name;
        }

        //Si el usuario manda el campo email y pone un mail distinto al que tiene
        if(($request->has('email')) && ($userParaActualizar -> email != $request -> email))
        {
            $userParaActualizar -> verified = User::USER_NO_VERIFICADO;
            $userParaActualizar -> verification_token = User::generarVerificationToken();
            
            //Actualizamos el campo email
            $userParaActualizar -> email = $request -> email;
        }

        if($request->has('password'))
        {
            $userParaActualizar -> password = bcrypt($request -> password);
        }

        if($request->has('admin'))
        {
            if(!$userParaActualizar->esVerificado())
            {
                //codigo 409: conflicto con la peticion recibida
                return $this -> errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
            }

            $userParaActualizar -> admin = $request -> admin;
        }

        //El método isDirty comprueba si los valores del modelo desde que lo hemos cargado han cambiado. clean -> no ha cambiado ::: dirty -> ha cambiado
        if(!$userParaActualizar -> isDirty())
        {
            //codigo 422: Peticion mal formada
            return $this -> errorResponse('Se debe especificar almenos un valor distinto para actualizar', 422);
        }


        $userParaActualizar -> save();

        return $this -> showOne($userParaActualizar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userToDestroy = User::findOrFail($id);
        $userToDestroy -> delete();

        return $this -> showOne($userToDestroy);
    }
}
