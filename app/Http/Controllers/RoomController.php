<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TypeRoom;

class RoomController extends Controller
{
    public function listRooms()
    {

        $rooms = Room::where('state',1)->with('typeRoom')->get();

        return response()->json([
            'res' => true,
            'data' => $rooms
        ]);
    }

    public function listTypes()
    {
        $types = TypeRoom::all();
        return response()->json([
            'res' => true,
            'data' => $types
        ]);
    }

    public function create()
    {

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'number'            => 'numeric|min:1|required|unique:App\Models\Room,number',
            'price'             => 'numeric|required|min:1',
            'description'       => 'string|required',
            'type_room_id'      => 'numeric|required|exists:type_rooms,id',
        ]);
        
        $image = request()->file('image');
        

        if ($image) {
            $path = $image->store('public');
            $fields['image'] = str_replace('public/','storage/',$path);
        }else{
            $fields['image'] = '/storage/prueba.jpg';
        }

        //Creando persona
        $room = Room::create($fields);

        return response()->json([
            'res' => true,
            'message' => "La habitación {$room->number} ha sido creada correctamente"
        ]);
    }

    public function edit(Int $id)
    {
        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'price'             => 'numeric|required|min:1',
            'description'       => 'string|required',
            'type_room_id'      => 'string|required|exists:type_rooms,id',
        ]);

        $image = request()->file('image');

        if ($image) {
            $path = $image->store('public');
            $fields['image'] = str_replace('public/','storage/',$path);
        }

        $room = Room::where('id', $id);
        $room->update($fields);

        return response()->json([
            'res' => true,
            'message' => "La habitación ha sido actualizada correctamente"
        ]);
    }

    public function delete(Int $id)
    {
        $room = Room::where('id', $id)->first();
        $room->state = false;
        $room->save();


        return response()->json([
            'res' => true,
            'message' => "La habitación ha sido eliminada correctamente"
        ]);
    }

    public function changeState(Int $id)
    {
        $fields = request()->validate([
            'disponibilidad'    => 'string|required|in:disponible,ocupado,check-in,check-out',
        ]);

        $room = Room::where('id', $id)->first();
        $room->update($fields); 

        return response()->json([
            'res' => true,
            'message' => "La habitación ha sido actualizada correctamente",
            'data' => $room
        ]);
    }
}
