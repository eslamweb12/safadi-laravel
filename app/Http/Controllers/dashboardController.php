<?php

namespace App\Http\Controllers;


use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class dashboardController extends Controller
{   
    public function __construct(){
        
    // $this->middleware(['auth'])->except(['index']);


        }

    public function index(){
        $title ="store";
        $user=Auth::user();
        return view('dashboard.index',[
            'user'=> 'ESLAM ELSAYED',
            'title'=>$title,

        ]);
    }
}
