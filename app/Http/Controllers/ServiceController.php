<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Serializer;

class ServiceController extends Controller
{
    public function create()
    {
        $fields = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type_service_id' => 'required|numeric|exists:type_services,id'
        ]);

        Service::create($fields);

        return response()->json([
            'res' => true,
            'message' => "El servicio {$fields['name']} ha sido creado correctamente"
        ]);
    }

    public function list()
    {
        $services = Service::with('typeService')->get();
        return response()->json([
            'res' => true,
            'data' => $services
        ]);
    }

    public function edit(Int $id)
    {
        $fields = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type_service_id' => 'required|numeric|exists:type_services,id'
        ]);

        $result = Service::where('id', $id)->first();
        $result->update($fields);

        return response()->json([
            'res' => true,
            'message' => "El servicio {$fields['name']} ha sido actualizado correctamente"
        ]);
    }

    public function delete(Int $id)
    {
        $service = Service::where('id', $id)->delete();

        return response()->json([
            'res' => true,
            'message' => "se eliminaron {$service} registros"
        ]);
    }
}
