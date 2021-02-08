<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;

class ReservationController extends Controller
{
    public function listReservations()
    {
        $reservations = Reservation::with('room', 'client', 'client.person')->get();

        return response()->json([
            'res'   => true,
            'data'  => $reservations
        ]);
    }

    public function listReservationsByClient(Int $id)
    {
        $reservations = Reservation::where('client_id', $id)->get();

        return response()->json([
            'res'   => true,
            'data'  => $reservations
        ]);
    }

    public function getRanges()
    {
        $fields = request()->validate([
            'room_id' => 'numeric|required|exists:rooms,id',
            'client_id' => 'numeric|required|exists:clients,id',
            'edit' => 'boolean|required'
        ]);

        $reservations = null;
        if ($fields['edit']) {
            $reservations = Reservation::where('room_id', $fields['room_id'])
                ->where('client_id', '<>', $fields['client_id'])
                ->where('state', 1)
                ->get();
        } else {
            $reservations = Reservation::where('room_id', $fields['room_id'])
                ->where('state', 1)
                ->get();
        }

        $ranges = [];

        foreach ($reservations as $reservation) {
            array_push($ranges, [$reservation->from, $reservation->to]);
        }

        return response()->json([
            'res' => true,
            'data' => $ranges
        ]);
    }

    public function create()
    {

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'from' => 'date|required',
            'to' => 'date|required',
            'room_id' => 'numeric|required|exists:rooms,id',
            'client_id' => 'numeric|required|exists:clients,id'
        ]);

        $reservation = Reservation::create($fields);

        return response()->json([
            'res' => true,
            'message' => "La reserva {$reservation->id} ha sido creada correctamente"
        ]);
    }

    public function edit(Int $id)
    {

        //VALINDANDO INPUTS QUE VIENEN DEL FRONTEND
        $fields = request()->validate([
            'from' => 'date|required',
            'to' => 'date|required',
            'room_id' => 'numeric|required|exists:rooms,id',
        ]);

        $reservation = Reservation::where('id', $id);
        $reservation->update($fields);

        return response()->json([
            'res' => true,
            'message' => "La reserva {$id} ha sido actualizada correctamente"
        ]);
    }

    public function delete(Int $id)
    {
        $reservation = Reservation::where('id', $id)->first();
        $reservation->state = false;
        $reservation->save();

        return response()->json([
            'res' => true,
            'message' => "La reserva {$id} ha sido dado de baja correctamente"
        ]);
    }
}
