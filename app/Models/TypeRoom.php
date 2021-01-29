<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoom extends Model
{
    use HasFactory;

    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class);
    }
}

