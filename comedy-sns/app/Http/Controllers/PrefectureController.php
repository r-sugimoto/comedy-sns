<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prefecture;

class PrefectureController extends Controller
{
    public function index(){
        $prefecture = Prefecture::select('id', 'name')->get();
        return $prefecture;
    }
    public function region_search(Request $request){
        $region = $request->region;
        $prefecture = Prefecture::select('id', 'name')->where('region_id', '=', $region)->get();
        return $prefecture;
    }
}
