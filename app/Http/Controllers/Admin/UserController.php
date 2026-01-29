<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Merchant;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Auth;
class UserController extends Controller
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));

    }

    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if($request->input('roles'))
        {
            switch ($request->input('roles'))
            {
                case 'Admin':
                    $input['type']='Admin';
                    break;
                case 'Manager':
                    $input['type']='Manager';
                    break;
                case 'Merchant':
                    $input['type']='Merchant';
                    break;
            }
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $role = DB::table('roles')->where('name',$input['type'])->first();
        $permissions=DB::table('role_has_permissions')->where('role_id', $role->id)->get();
        foreach($permissions as $permission)
        {
            DB::table('model_has_permissions')->insert(
                ['permission_id' => $permission->permission_id, 'model_type' => 'App\Models\User','model_id'=>$user->id]
            );
        }
        Session::flash('message', 'User created successfully');
        return redirect()->route('users.index');

    }

    

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show',compact('user'));

    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);
        if($user->type == 'merchant')
        {
            $merchant = Merchant::where('id',$user->merchant_id)->first();
            return view('admin.users.profile-merchant',compact('merchant'));
        }
        else {
            return view('admin.users.profile',compact('user')); 
        }


    }
    

    

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {

        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.edit',compact('user','roles','userRole'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        if($request->input('roles'))
        {
            switch ($request->input('roles'))
            {
                case 'Admin':
                    $input['type']='Admin';
                    break;
                case 'Manager':
                    $input['type']='Manager';
                    break;
                case 'Merchant':
                    $input['type']='Merchant';
                    break;
            }
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        DB::table('model_has_permissions')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        $role = DB::table('roles')->where('name',$input['type'])->first();
        $permissions=DB::table('role_has_permissions')->where('role_id', $role->id)->get();
        foreach($permissions as $permission)
        {
            DB::table('model_has_permissions')->insert(
                ['permission_id' => $permission->permission_id, 'model_type' => 'App\Models\User','model_id'=>$id]
            );
        }
        Session::flash('message', 'User updated successfully');
        return redirect()->route('users.index');

    }

    
    public function delete($id)
    {
        User::find($id)->delete();
        Session::flash('message', 'You have deleted Merchant successfully');
        return redirect()->route('users.index');
    }
    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }

}
