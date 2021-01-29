<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function person(){
        return $this->belongsTo(Person::class,'people_id','id');
    }

    public function role(){
        return $this->belongsTo(RoleEmployee::class);
    }

    public function vouchers(){
        return $this->hasMany(Voucher::class);
    }
}
