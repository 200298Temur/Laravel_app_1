<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function main(){
        // session(['key'=>'value']);
        // dd(session( )->all());
        
        return view('main');
    }
    public function about(){
        return view('about');
    }
    public function service(){
        return view('service');
    }
    public function projects(){
        return view('projects');
    }
    public function contact(){
        return view('contact');
    }
}
