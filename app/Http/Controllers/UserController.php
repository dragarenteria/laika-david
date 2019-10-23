<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Municipio;
use App\Pais;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
   public function index(){
       return view('user');
   }
   public function getPais(){
       return Pais::with('departamentos.municipios')->get();
   }
   public function getComplemento(){
        return [
            'depto' => Departamento::with('municipios')->get(),
            'municipio' => Municipio::all(),
        ];
    }
   public function table(){
        return [
            'data' => User::with(['municipio.departamento.pais','municipio.departamento.municipios','municipio.departamento.pais.departamentos'])->get()
        ] ;
   }

   public function delete($id){
    $succes = false;
    $error = '';
    DB::beginTransaction();
    try {
    User::where('id',$id)->delete();

    DB::commit();
    $succes = true;
    } catch (\Throwable $th) {
        $succes = false;
        $error = $th->getMessage();
        DB::rollback();
    }
    if ($succes) {
        return [
            'status' => true,
            'data' =>  User::with(['municipio.departamento.pais','municipio.departamento.municipios','municipio.departamento.pais.departamentos'])->get(),
        ];
    }else {
        return [
            'status' => false,
            'error' => $error
        ];
    }
   }
   public function setUser(Request $request){
        $succes = false;
        $error = '';
        $request->validate([
            'email' => 'required|unique:users',
        ]);
        DB::beginTransaction();
        try {
        User::create([
            'name' =>$request->nombre,
            'apellidos' => $request->apellido,
            'telefono' =>  $request->telefono,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'municipio_id' => $request->municipio['id'],
            'remember_token' => Str::random(10),
        ]);

        DB::commit();
        $succes = true;
        } catch (\Throwable $th) {
            $succes = false;
            $error = $th->getMessage();
            DB::rollback();
        }
        if ($succes) {
            return [
                'status' => true,
                'data' =>  User::with(['municipio.departamento.pais','municipio.departamento.municipios','municipio.departamento.pais.departamentos'])->get(),
            ];
        }else {
            return [
                'status' => false,
                'error' => $error
            ];
        }
    }


    public function putUser(Request $request){
        $succes = false;
        $error = '';
        $request->validate([
            'email' => 'required|unique:users,email,'.$request->id,
        ]);
        DB::beginTransaction();
        try {
        User::where('id',$request->id)->update([
            'name' =>$request->name,
            'apellidos' => $request->apellidos,
            'telefono' =>  $request->telefono,
            'email' => $request->email,
            'municipio_id' => $request->municipio['id'],
        ]);

        DB::commit();
        $succes = true;
        } catch (\Throwable $th) {
            $succes = false;
            $error = $th->getMessage();
            DB::rollback();
        }
        if ($succes) {
            return [
                'status' => true,
                'data' =>  User::with(['municipio.departamento.pais','municipio.departamento.municipios','municipio.departamento.pais.departamentos'])->get(),
            ];
        }else {
            return [
                'status' => false,
                'error' => $error
            ];
        }
    }
}
