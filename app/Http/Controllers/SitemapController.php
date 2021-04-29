<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SitemapController extends Controller
{
    public static function sitemap()
    {

//        まずは固定ページを入れる
        $map = ['login','register','post','recruit','search'];

        return response()->view('sitemap',compact('map'))->header('Content-Type', 'text/xml');
    }



}
