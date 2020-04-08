<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index(){
    	return view('admin/role/role-list');
    }

    public function add(){
    	return view('admin/role/add');
    }
}
