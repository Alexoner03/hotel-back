<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    protected $guarded = [];


    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    public function client(){
        return $this->hasOne(Client::class,'id','client_id');
    }

    public function typePeople(){
        return $this->belongsTo(TypePerson::class,'type_people_id','id');
    }
}
