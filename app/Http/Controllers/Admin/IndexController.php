<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController 
{
   public function index()
   {	
	   	$username = session('username');
	   	return view('admin.index.index',['username' => $username]);
   }
}
