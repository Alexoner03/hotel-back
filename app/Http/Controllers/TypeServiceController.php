<?php

namespace App\Http\Controllers;

use App\Models\TypeService;
use Illuminate\Http\Request;
use Mockery\Matcher\Type;

class TypeServiceController extends Controller
{
    public function create(){
        $fields = request()->validate([
            'description' => 'required|string'
        ]);

        TypeService::create($fields);
        
        return response()->json([
            'res' => true,
            'message' => 'El servicio ha sido creado correctamente'
        ]);

    }

    public function list(){
        $types = TypeService::all();
        return response()->json([
            'res' => true,
            'data' => $types
        ]);
    }

    public function edit(Int $id){
        $fields = request()->validate([
            'description' => 'required|string'
        ]);

        $result = TypeService::where('id',$id)->first();
        $result->update($fields);
        
        return response()->json([
            'res' => true,
            'message' => 'El servicio ha sido actualizado correctamente'
        ]);
    }
}
