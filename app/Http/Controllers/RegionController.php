<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;

class RegionController extends Controller
{
    public function index(){
        $region = Region::select('id', 'name')->get();
        return $region;
    }
}
