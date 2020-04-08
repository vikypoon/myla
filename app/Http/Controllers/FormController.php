<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store(){
        //var_dump(Request::all());
        $input=Request::all();
        echo $input['a'].PHP_EOL;
        echo $input['b'].PHP_EOL;
        echo $input['c'].PHP_EOL;
    }
}
