<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashController extends Controller
{
    public function index()
    {
        echo "Admin Dash";
    }
}
