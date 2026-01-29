<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserDataTableController extends Controller
{
    public function __invoke(Request $request)
    {
        $users = User::orderBy('id', 'DESC');
        if ($request->user_name != '') {
            $users->where('name', 'like', "%{$request->user_name}%");
        }
        if ($request->user_email != '') {
            $users->where('email', 'like', "%{$request->user_email}%");
        }
        if ($request->user_role != '') {
            $users->where('type', 'like', "%{$request->user_role}%");
        }
        

        $users = $users->get();
        return DataTables::of($users)
        ->addColumn('checkboxes', function ($user) {
            $action = '<input type="checkbox" name="pdr_checkbox[]" class="pdr_checkbox" value="' . $user->id . '" />';
            return $action;
        })

        ->addColumn('actions', function ($user)  {
            $action = '';
            $message = "'Are you sure you want to remove this merchant'";
            if($user->type!="Merchant")
            {
                $action .= '
                <a class="btn btn-dark" href="'.route('users.show',$user->id).'" data-toggle="tooltip"
                data-placement="bottom" title="Show"><i class="fa fa-eye"></i></a>
                <a class="btn btn-primary" href="'.route('users.edit',$user->id).'" data-toggle="tooltip"
                data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></a>
                <a  href="' . route('users.delete', $user->id) . '"  class="btn btn-danger" data-toggle="tooltip"
                 data-placement="bottom" title="Delete" onclick="return confirm('.$message.')" ><i class="fa fa-trash"></i></a>';
            }
          else 
            {
                $action .= '<a class="btn btn-dark" href="'.route('users.show',$user->id).'" data-toggle="tooltip"
                data-placement="bottom" title="Show"><i class="fa fa-eye"></i></a>';
            }



            return $action;
        })

        ->rawColumns(['checkboxes', 'actions'])
        ->make(true);
    }
}
