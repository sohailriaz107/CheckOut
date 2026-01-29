<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class AddMerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'address' => 'required',
        ];
    }

    public function addMerchant()
    {
        $merchant = new Merchant();
        $merchant->name = $this->name;
        $merchant->email = $this->email;
        $merchant->telephone = $this->telephone;
        $merchant->address = $this->address;
        $char = strtoupper(substr($this->name, 0, 2));
        $merchant_code = $char . random_int(100000, 999999);
        $merchant->merchant_code = $merchant_code;
        $secret_id = Str::random(30);
        $merchant->secret_id = $secret_id;
        $number = Merchant::orderBy('id', 'desc')->first()->id + 1;
        $store_name = $number . $char;
        $merchant->store_name = $store_name;

        ($this->credit_card == 'on') ? $merchant->credit_card = 1 : $merchant->credit_card = 0;
        ($this->paypal == 'on') ? $merchant->paypal = 1 : $merchant->paypal = 0;
        ($this->user_credit == 'on') ? $merchant->user_credit = 1 : $merchant->user_credit = 0;

        if ($this->file('logo')) {
            $image = $this->file('logo');
            $fileName = $this->name . rand() . '.' . $this->file('logo')->getClientOriginalExtension();
            $image->move('merchant_logos', $fileName);
            $merchant->logo = $fileName;
        }
        $merchant->save();

    }

}
