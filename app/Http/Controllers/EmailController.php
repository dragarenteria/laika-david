<?php

namespace App\Http\Controllers;

use App\Email;
use App\Jobs\EmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function index(){
        return view('email');
    }
    public function table(){
        return Email::where('user_id',Auth::user()->id)->get();
    }
    public function setEmail(Request $request){

        $succes = false;
        $error = '';
        DB::beginTransaction();
        try {
            $email = Email::create([
                'asunto' => $request->asunto,
                'destinatario' => $request->destinatario,
                'mensaje' => $request->mensaje,
                'user_id' => Auth::user()->id
            ]);

            dispatch(new EmailJob($email));
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
                'data' =>  Email::where('user_id',Auth::user()->id)->get(),
            ];
        }else {
            return [
                'status' => false,
                'error' => $error
            ];
        }
    }
}
