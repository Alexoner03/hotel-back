<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class,'people_id','id');
    }

    public function vouchers(){
        return $this->hasMany(Voucher::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
