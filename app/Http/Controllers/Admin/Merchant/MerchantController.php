<?php

namespace App\Http\Controllers\Admin\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.merchants.index');
    }

    public function create()
    {
        return view('admin.merchants.create');
    }

    public function add(AddMerchantRequest $request)
    {
        $request->addMerchant();
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['type']='Merchant';
        $input['merchant_id']=$request->id;
        $user = User::create($input);
        $user->assignRole('Merchant');
        $role = DB::table('roles')->where('name',$input['type'])->first();
        $permissions=DB::table('role_has_permissions')->where('role_id', $role->id)->get();
        foreach($permissions as $permission)
        {
            DB::table('model_has_permissions')->insert(
                ['permission_id' => $permission->permission_id, 'model_type' => 'App\Models\User','model_id'=>$user->id]
            );
        }

        Session::flash('message', 'You have added Merchant successfully');
        return redirect()->route('admin.merchants.index');
    }

    public function edit(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    public function update(
        UpdateMerchantRequest $request,
        Merchant $merchant)
    {
        $request->updateMerchant($merchant);
        $user = User::where('merchant_id',$merchant['id'])->first();
        $input = $request->all();
        if(!empty($input['password']) AND !empty($input['confirm-password'])){
            $input['password'] = Hash::make($input['password']);
            $user->update($input);
            $user->assignRole('Merchant');
            $role = DB::table('roles')->where('name','Merchant')->first();
            $permissions=DB::table('role_has_permissions')->where('role_id', $role->id)->get();
            foreach($permissions as $permission)
            {
                $user_permision= DB::table('model_has_permissions')->where('permission_id',$permission->permission_id)->where('model_id',$user->id)->first();
                if(empty($user_permision))
                {
                    DB::table('model_has_permissions')->insert(
                        ['permission_id' => $permission->permission_id, 'model_type' => 'App\Models\User','model_id'=>$user->id]
                    );
                }
               
            }
        }
       
       
        Session::flash('message', 'You have edited Merchant successfully');
        return redirect()->route('admin.merchants.index');
    }

    public function delete(Merchant $merchant)
    {
        $merchant->delete();
        Session::flash('message', 'You have deleted Merchant successfully');
        return redirect()->route('admin.merchants.index');
    }

    public function status(Merchant $merchant)
    {
        if($merchant->status == 'not_active') {
            $merchant->status = 'active';
            $merchant->update();
            $action = 'activated';
        }
        else if($merchant->status == 'active') {
            $merchant->status = 'not_active';
            $merchant->update();
            $action = 'inactivated';
        }
        $merchant->update();

        Session::flash('message', 'You have '. $action .' Merchant successfully');
        return redirect()->route('admin.merchants.index');
    }

    public function show(Merchant $merchant)
    {
        return view('admin.merchants.show', compact('merchant'));

    }

    public function changeSecretId(Request $request)
    {
        $secret_id = Str::random(30);
        return $secret_id;
    }
}
