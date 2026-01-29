<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditCardSettingsRequest extends FormRequest
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
            'credit_card_sandbox_merchant_id' => 'required',
            'credit_card_sandbox_api_key' => 'required',
            'credit_card_live_merchant_id' => 'required',
            'credit_card_live_api_key' => 'required'
        ];
    }

    public function updateCreditSetiings()
    {
        $data = Setting::Orderby('id', 'desc')->first();
        $data->credit_card_sandbox_merchant_id = $this->credit_card_sandbox_merchant_id;
        $data->credit_card_sandbox_api_key = $this->credit_card_sandbox_api_key;
        $data->credit_card_live_merchant_id = $this->credit_card_live_merchant_id;
        $data->credit_card_live_api_key = $this->credit_card_live_api_key;
        $data->update();
    }
}
