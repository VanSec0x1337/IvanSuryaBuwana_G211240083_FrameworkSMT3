<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class infoController extends Controller
{
    public function infoMhs($kd)
{
    return view('info', ['progdi' => $kd]);
}

}
