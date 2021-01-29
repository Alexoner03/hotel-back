<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    public function typeVoucher(){
        return $this->belongsTo(Voucher::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function voucherDetails(){
        return $this->hasMany(VoucherDetail::class);
    }
}
