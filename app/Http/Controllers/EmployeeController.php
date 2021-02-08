<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    public function listEmployees(){
        $employees = Employee::where('state',true)->with('role','person','person.employee')->get();

        return response()->json([
            'res'   => true,
            'data'  => $employees
        ]);
    }

    public function create(){

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'admin'             => 'boolean|required',
            'name'              => 'string|min:3|required',
            'sex'               => 'string|required|in:M,F',
            'cellphone'         => 'required|regex:/^9[0-9]{8}+$/',
            'dni'               => 'required|regex:/^[0-9]{8}+$/',
            'first_lastname'    => 'string|required',
            'second_lastname'   => 'string|required',
            'birthday'          => 'date|required',
            'email'             => 'email|required|unique:App\Models\Person,email',
            'address'           => 'required|string',
        ]);



        //Creando persona
        $person = Person::create([
            "name"              => $fields['name'],
            "sex"               => $fields['sex'],
            "cellphone"         => $fields['cellphone'],
            "dni"               => $fields['dni'],
            "first_lastname"    => $fields['first_lastname'],
            "second_lastname"   => $fields['second_lastname'],
            "birthday"          => $fields['birthday'],
            "email"             => $fields['email'],
            "address"           => $fields['address'],
            "type_people_id"    => 1,
        ]);

        // CREANDO EMPLEADO
        Employee::create([
            "people_id" => $person->id,
            "role_id" => $fields['admin'] ? 1 : 2 // 1 = admin | 2 = recepcionista
        ]);

        //CREANDO USUARIO
        User::create([
            "password" => Hash::make($fields['dni']),
            "user_name" => $person->email,
            "people_id" => $person->id,
        ]);

        return response()->json([
            'res' => true,
            'message' => "el usuario {$person->name} ha sido creado correctamente"
        ]);
    }

    public function edit(Int $id){

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'admin'             => 'boolean|required',
            'name'              => 'string|min:3|required',
            'sex'               => 'string|required|in:M,F',
            'cellphone'         => 'required|regex:/^9[0-9]{8}+$/',
            'first_lastname'    => 'string|required',
            'second_lastname'   => 'string|required',
            'birthday'          => 'date|required',
            'address'           => 'required|string',
        ]);


        //Actualizando Rol
        $employee = Employee::where('people_id',$id)->first();
        $employee->role_id = $fields['admin'] ? 1 : 2;
        $employee->save();


        unset($fields['admin']); //Quitando admin-value ya que no forma parte de persona

        //Actualizando persona
        $person = Person::where('id',$id)->first();
        $person->update($fields);


        return response()->json([
            'res' => true,
            'message' => "el usuario {$person->name} ha sido editado correctamente"
        ]);
    }

    public function delete(Int $id){
        $employee = Employee::where('id',$id)->first();
        $employee->state = false;
        $employee->save();

        return response()->json([
            'res' => true,
            'message' => "el empleado {$employee->person->name} ha sido dado de baja correctamente"
        ]);
    }
}
