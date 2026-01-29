<?php
namespace App\Http\Controllers\Admin\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MerchantDataTableController extends Controller
{
    public function __invoke(Request $request)
    {
        $merchants = Merchant::orderBy('id', 'DESC');
        if ($request->merchant_name != '') {
            $merchants->where('name', 'like', "%{$request->merchant_name}%");
        }
        if ($request->merchant_email != '') {
            $merchants->where('email', 'like', "%{$request->merchant_email}%");
        }
        if ($request->merchant_phone != '') {
            $merchants->where('telephone', 'like', "%{$request->merchant_phone}%");
        }
        if ($request->merchant_address != '') {
            $merchants->where('address', 'like', "%{$request->merchant_address}%");
        }
        if ($request->merchant_store_name != '') {
            $merchants->where('store_name', 'like', "%{$request->merchant_store_name}%");
        }
        if ($request->merchant_address != '') {
            $merchants->where('address', 'like', "%{$request->merchant_address}%");
        }
        if ($request->merchant_merchantUrl != '') {
            $merchants->where('merchantUrl', 'like', "%{$request->merchant_merchantUrl}%");
        }
        if ($request->merchant_code != '') {
            $merchants->where('merchant_code', 'like', "%{$request->merchant_code}%");
        }
        if ($request->merchant_secret_id != '') {
            $merchants->where('secret_id', 'like', "%{$request->merchant_secret_id}%");
        }
        if ($request->status != '') {
            $merchants->where('status', "{$request->status}");
        }

        $merchants = $merchants->get();
        return DataTables::of($merchants)
        ->addColumn('checkboxes', function ($merchant) {
            $action = '<input type="checkbox" name="pdr_checkbox[]" class="pdr_checkbox" value="' . $merchant->id . '" />';
            return $action;
        })

        ->addColumn('status', function ($merchant){
            if($merchant->status == 'not_active')
            {
                $status = 'Inactive';
            }
            else if ($merchant->status == 'active')
            {
                $status = 'Active';
            }
            return $status;
        })

        ->addColumn('actions', function ($merchant)  {
            $action = '';
            $message = "'Are you sure you want to remove this merchant'";
            $action .= '
            <div class="btn-group">
            <a  href="' . route('admin.merchants.show', ['merchant' => $merchant]) . '"  class="btn btn-dark" data-toggle="tooltip"
            data-placement="bottom" title="Show"><i class="fa fa-eye"></i></a>

            <a href="' . route('admin.merchants.edit', ['merchant' => $merchant]) . '"
                class="btn btn-primary" data-toggle="tooltip"
                data-placement="bottom" title="Edit"><i class="fa fa-edit"></i>
            </a>
            <a  href="' . route('admin.merchants.delete', ['merchant' => $merchant]) . '"  class="btn btn-danger" data-toggle="tooltip"
            data-placement="bottom" title="Delete" onclick="return confirm('.$message.')" ><i class="fa fa-trash"></i></a>
            ';


            if($merchant->status == 'not_active')
            {
                $action .= '  <a  href="' . route('admin.merchants.status', ['merchant' => $merchant]) . '"  class="btn btn-success" data-toggle="tooltip"
                data-placement="bottom" title="Active"><i class="fa fa-upload"></i></a>
                </div>
            ';
            }
            else if ($merchant->status == 'active')
            {
                $action .= '  <a  href="' . route('admin.merchants.status', ['merchant' => $merchant]) . '"  class="btn btn-warning" data-toggle="tooltip"
                data-placement="bottom" title="Inactive"><i class="fa fa-download"></i></a>
                </div>
            ';
            }



            return $action;
        })

        ->rawColumns(['checkboxes', 'actions'])
        ->make(true);
    }
}
