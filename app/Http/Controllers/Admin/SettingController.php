<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\UpdateCreditCardSettingsRequest;
use App\Http\Requests\UpdatePaypalSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $setting = Setting::Orderby('id', 'desc')->first();
        return view('admin.settings.index', compact('setting'));
    }

    public function updatePaypal(UpdatePaypalSettingsRequest $request){
        $request->updatePaypalSettings();
        Session::flash('message', 'You have update PayPal settings successfully');
        return redirect()->back();
    }
    public function updateCredit(UpdateCreditCardSettingsRequest $request){
        $request->updateCreditSetiings();
        Session::flash('message', 'You have update Credit Card settings successfully');
        return redirect()->back();
    }
}
