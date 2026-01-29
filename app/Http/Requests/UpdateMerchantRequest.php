<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantRequest extends FormRequest
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

    public function updateMerchant(Merchant $merchant)
    {
        $merchant->name = $this->name;
        $merchant->email = $this->email;
        $merchant->telephone = $this->telephone;
        $merchant->address = $this->address;
        $merchant->secret_id = $this->secret_id;
        ($this->credit_card == 'on') ? $merchant->credit_card = 1 : $merchant->credit_card = 0;
        ($this->paypal == 'on') ? $merchant->paypal = 1 : $merchant->paypal = 0;
        ($this->user_credit == 'on') ? $merchant->user_credit = 1 : $merchant->user_credit = 0;
        if($this->hasFile('logo'))
        {
            $image = $this->file('logo');
            $fileName = $this->name.rand().'.'. $this->file('logo')->getClientOriginalExtension();
            $image->move('merchant_logos', $fileName);
            $merchant->logo = $fileName;
        }


        $merchant->update();
    }
}
