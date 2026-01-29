<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::check() && Auth::user()->type != 'Merchant')
        {
            return view('admin.index');
        }
        else if(Auth::check() && Auth::user()->type == 'Merchant')
        {
            return view('admin.merchant-dashborad');
        }
        else {
            return view('frontend.index');
        }
       
    }

    public function DemoForm()
    {
        return view('frontend.demo');
    }
    public function error()
    {
        return view('frontend.error');
    }

    public function success(){
        return view('frontend.success');
    }
}
