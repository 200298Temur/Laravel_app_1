<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return response('BU ro\'hat');
    }
    
    public function show($user){
        // return view(
        // 'users.show',
        // ['user'=>'Temur Usmonov','id'=>$user]
        // );
        return view('users.show')->with(
        ['user'=>'Temur Usmonov',
        'id'=>$user]
        );
    }
    public function create(){
        return view('users/create');
    }
    public function edit($user_id){
        return $user_id . ' ni o\'gartirish';
    }
    public function store(Request $request){
        dd($request);
    }
}
