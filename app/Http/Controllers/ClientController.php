<?php

namespace App\Http\Controllers;
use App\Models\Person;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;


class ClientController extends Controller
{

    public function listAllMapped(){
        $clients = Client::where('state',true)->whereHas('person', function (Builder $query) {
            $query->whereIn('type_people_id',[2,3]);
        })
        ->with('person','person.typePeople','person.client')
        ->get();

        $mapped = array();

        foreach ($clients as $client) {
            $obj = (object)null;
            
            $obj->value = $client->id;
            $obj->label = "{$client->person->name} {$client->person->first_lastname} - DNI : {$client->person->dni}";

            array_push($mapped,$obj);
            
        }
        return response()->json($mapped);

    }

    public function listNormalClients(){
        $clients = Client::where('state',true)->whereHas('person', function (Builder $query) {
            $query->where('type_people_id',3);
        })
        ->with('person','person.typePeople','person.client')
        ->get();

        return response()->json([
            'res'   => true,
            'data'  => $clients
        ]);
    }

    public function listEnterpriseClients(){
        $clients = Client::where('state',true)->whereHas('person', function (Builder $query) {
            $query->where('type_people_id',2);
        })
        ->with('person','person.typePeople','person.client')
        ->get();

        return response()->json([
            'res'   => true,
            'data'  => $clients
        ]);
    }

    public function create(){

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'name'              => 'string|min:3|required',
            'sex'               => 'string|required|in:M,F',
            'cellphone'         => 'required|regex:/^9[0-9]{8}+$/',
            'dni'               => 'required|regex:/^[0-9]{8}+$/|unique:App\Models\Person,dni',
            'first_lastname'    => 'string|required',
            'second_lastname'   => 'string|required',
            'birthday'          => 'date|required',
            'email'             => 'email|required|unique:App\Models\Person,email',
            'address'           => 'required|string',
            'type_people_id'    => 'numeric|required|min:2|max:3',
            'ruc'               => 'required_if:type_people_id,2|regex:/^[0-9]{11}+$/|unique:App\Models\Person,ruc',
            'business_name'     => 'required_if:type_people_id,2|string'
        ]);



        //Creando persona
        $person = Person::create($fields);

        // CREANDO EMPLEADO
        Client::create(["people_id" => $person->id]);

        //CREANDO USUARIO
        User::create([
            "password" => Hash::make($fields['dni']),
            "user_name" => $person->email,
            "people_id" => $person->id,
        ]);

        return response()->json([
            'res' => true,
            'message' => "el cliente {$person->name} ha sido creado correctamente"
        ]);
    }

    public function edit(Int $id){

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'name'              => 'string|min:3|required',
            'sex'               => 'string|required|in:M,F',
            'cellphone'         => 'required|regex:/^9[0-9]{8}+$/',
            'first_lastname'    => 'string|required',
            'second_lastname'   => 'string|required',
            'birthday'          => 'date|required',
            'address'           => 'required|string',
            'type_people_id'    => 'numeric|required|min:2|max:3',
            'business_name'     => 'required_if:type_people_id,2|string'
        ]);

        //Actualizando persona
        $person = Person::where('id',$id)->first();
        $person->update($fields);


        return response()->json([
            'res' => true,
            'message' => "el cliente {$person->name} ha sido actualizado correctamente"
        ]);
    }

    public function delete(Int $id){
        $client = Client::where('id',$id)->first();
        $client->state = false;
        $client->save();

        return response()->json([
            'res' => true,
            'message' => "el cliente {$client->person->name} ha sido dado de baja correctamente"
        ]);
    }

}
