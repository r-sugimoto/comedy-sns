<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generation;

class GenerationController extends Controller
{
    public function index(){
        $generation = Generation::select('id', 'name')->get();
        return $generation;
    }
}
