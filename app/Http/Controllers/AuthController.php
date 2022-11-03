<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Webkul\RestApi\Http\Controllers\V1\Admin\User;

class AuthController extends Webkul\RestApi\Http\Controllers\V1\Admin\User
{
    public function login(Request $request, AdminRepository $adminRepository)
    {
       dd('fff');
    }

}
