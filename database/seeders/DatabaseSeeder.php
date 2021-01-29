<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Person;
use App\Models\RoleEmployee;
use App\Models\TypePerson;
use App\Models\TypeRoom;
use App\Models\TypeService;
use App\Models\TypeVoucher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Creando tipos de Personas
        TypePerson::create(["description" => "EMPLEADO"]);
        TypePerson::create(["description" => "CLIENTE EMPRESARIAL"]);
        TypePerson::create(["description" => "CLIENTE NORMAL"]);


        //Creando personas
        Person::create([
            "name" => "KATY",
            "sex" => "F",
            "cellphone" => "960267796",
            "dni" => "48566305",
            "first_lastname" => "FRANCIA",
            "second_lastname" => "PEREZ",
            "birthday" => "22/01/10",
            "email" => "CORREO@CORREO.COM",
            "address" => "CALLE 123",
            "type_people_id" => 1,
        ]);

        Person::create([
            "name" => "ALEX",
            "sex" => "M",
            "cellphone" => "960267797",
            "dni" => "48566304",
            "first_lastname" => "FRANCIA",
            "second_lastname" => "PEREZ",
            "birthday" => "01/01/10",
            "email" => "CORREO2@CORREO.COM",
            "address" => "CALLE 123",
            "type_people_id" => 1,
        ]);

        Person::create([
            "name" => "MELINA",
            "sex" => "F",
            "cellphone" => "960267798",
            "dni" => "48566307",
            "first_lastname" => "FRANCIA",
            "second_lastname" => "PEREZ",
            "birthday" => "01/01/10",
            "email" => "CORREO3@CORREO.COM",
            "address" => "CALLE 123",
            "type_people_id" => 2,
        ]);

        Person::create([
            "name" => "JOSE",
            "sex" => "M",
            "cellphone" => "960267799",
            "dni" => "48566308",
            "first_lastname" => "FRANCIA",
            "second_lastname" => "PEREZ",
            "birthday" => "01/01/10",
            "email" => "CORREO4@CORREO.COM",
            "ruc" => "1234678912",
            "business_name" => "EMPRESA SAC",
            "address" => "CALLE 123",
            "type_people_id" => 3,
        ]);

        //CREANDO USUARIOS
        User::create([
            "password" => Hash::make('password'),
            "user_name" => "CORREO@CORREO.COM",
            "people_id" => 1,
        ]);

        User::create([
            "password" => Hash::make('password'),
            "user_name" => "CORREO2@CORREO.COM",
            "people_id" => 2,
        ]);

        User::create([
            "password" => Hash::make('password'),
            "user_name" => "CORREO3@CORREO.COM",
            "people_id" => 3,
        ]);

        User::create([
            "password" => Hash::make('password'),
            "user_name" => "CORREO4@CORREO.COM",
            "people_id" => 4,
        ]);

        //CREANDO ROL DE EMPLEADOS
        RoleEmployee::create(["description" => "ADMINISTRADOR"]);
        RoleEmployee::create(["description" => "RECEPCIONISTA"]);

        // CREANDO EMPLEADOS
        Employee::create(["people_id" => 1, "role_id" =>1]);
        Employee::create(["people_id" => 2, "role_id" =>2]);


        //CREANDO CLIENTES
        Client::create(["people_id" => 3]);
        Client::create(["people_id" => 4]);

        //TIPOS DE SERVICIO
        TypeService::create(["description" => "REGISTRO DE HUESPEDES"]);
        TypeService::create(["description" => "LAVANDERÍA"]);
        TypeService::create(["description" => "RESTAURANT"]);
        TypeService::create(["description" => "GUIA TURISTICA"]);

        //CREANDO TIPO DE HABITACIONES
        TypeRoom::create(["name" => "SIMPLE"]);
        TypeRoom::create(["name" => "DOBLE"]);
        TypeRoom::create(["name" => "FAMILIAR"]);
        TypeRoom::create(["name" => "MATRIMONIAL"]);

        //CREANDO TIPO DE COMPROBANTES
        TypeVoucher::create(["name" => "FACTURA"]);
        TypeVoucher::create(["name" => "BOLETA"]);

    }
}
