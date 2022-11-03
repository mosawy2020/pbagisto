<?php

namespace Webkul\Notification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Customer\Models\Customer;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = ["token" , "device" , "customer_id"] ;
    public function customer (){
        return $this->belongsTo(Customer::class) ;
    }
}
