<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    public function login(){
        $fields = request()->validate([
            'user_name' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('user_name',$fields["user_name"])->first();

        if
        (
            !is_null($user) && //usuario existe
            $user->person->type_people_id !== 1 && // y no es empleado
            Client::where('people_id',$user->person->id)->first()->state && //cliente debe estar activo
            Hash::check($fields['password'], $user->password) // contraseña coincice
        )
        {
            $user->api_token = Str::random(200); //Seteando Api TOKEN
            $user->save();

            return response()->json([
                'res' => true,
                'message' => 'Bienvenido al sistema',
                'token' => $user->api_token
            ]);

        }else{
            return response()->json([
                'res' => false,
                'message' => 'Credenciales Incorrectas'
            ],401);
        }
    }

    public function loginEmployees(){
        $fields = request()->validate([
            'user_name' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('user_name',$fields["user_name"])->first();

        if
        (
            !is_null($user) && //usuario existe
            $user->person->type_people_id === 1 && // y no es empleado
            Employee::where('people_id',$user->person->id)->first()->state && //empleado debe estar activo
            Hash::check($fields['password'], $user->password) // contraseña coincice
        )
        {
            $user->api_token = Str::random(200); //Seteando Api TOKEN
            $user->save();

            return response()->json([
                'res' => true,
                'message' => 'Bienvenido al sistema',
                'token' => $user->api_token
            ]);

        }else{
            return response()->json([
                'res' => false,
                'message' => 'Credenciales Incorrectas'
            ],401);
        }
    }

    public function getMyData(){
        $user = User::where('people_id',auth()->user()->id)->with('person')->first();
        $detail = null;
        if($user->person->type_people_id === 1){
            $detail = Employee::where('people_id',$user->person->id)->first();
        }else{
            $detail = Client::where('people_id',$user->person->id)->first();
        }


        return response()->json([
            'res' => true,
            'data' => $user,
            'detail' => $detail
        ]);
    }
}
