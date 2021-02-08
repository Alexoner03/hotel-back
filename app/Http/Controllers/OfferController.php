<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function listEnables()
    {
        $offers = Offer::whereRaw("CURDATE() between offers.from and offers.to or offers.from >= curdate()")
        ->with('typeRoom')
        ->get();

        $_filter = array();

        foreach ($offers as $offer) {
            if($offer->state){
                array_push($_filter,$offer);
            }
        }
        

        return response()->json([
            'res' => true,
            'data' => $_filter
        ]);
    }

    public function create()
    {

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'price'         => 'required|numeric',
            'type_room_id'  => 'required|numeric|exists:type_rooms,id',
            'image'         => 'image',
        ]);

        $image = request()->file('image');


        if ($image) {
            $path = $image->store('public');
            $fields['image'] = str_replace('public/', 'storage/', $path);
        } else {
            $fields['image'] = '/storage/prueba.jpg';
        }

        //Creando persona
        $offer = Offer::create($fields);

        return response()->json([
            'res' => true,
            'message' => "La oferta {$offer->number} ha sido creada correctamente"
        ]);
    }

    public function edit(Int $id)
    {
        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'price'         => 'required|numeric',
            'type_room_id'  => 'required|numeric|exists:type_rooms,id',
            'image'         => 'image',
        ]);



        $image = request()->file('image');

        if ($image) {
            $path = $image->store('public');
            $fields['image'] = str_replace('public/', 'storage/', $path);
        }

        $offer = Offer::where('id', $id);
        $offer->update($fields);

        return response()->json([
            'res' => true,
            'message' => "La habitación ha sido actualizada correctamente"
        ]);
    }

    public function delete(Int $id)
    {
        $offer = Offer::where('id', $id)->first();
        $offer->state = false;
        $offer->save();


        return response()->json([
            'res' => true,
            'message' => "La habitación ha sido eliminada correctamente"
        ]);
    }
}
