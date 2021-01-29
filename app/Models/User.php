<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class,'people_id','id');
    }

    public function hasRole(String $rol){
        return $this->person->typePeople->description === $rol;
    }

    public function hasEmployeeRole(String $rol){
        $employee = Employee::where('people_id', $this->person->id)->first();
        if(!is_null($employee)) return $employee->role->description === $rol;
        return false;
    }

}
