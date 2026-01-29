<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaypalSettingsRequest extends FormRequest
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
            'paypal_sandbox_client_id' => 'required',
            'paypal_sandbox_client_secret' => 'required',
            'paypal_live_client_id' => 'required',
            'paypal_live_client_secret' => 'required',
        ];
    }

    public function updatePaypalSettings()
    {
        $data = Setting::Orderby('id', 'desc')->first();
        $data->paypal_sandbox_client_id = $this->paypal_sandbox_client_id;
        $data->paypal_sandbox_client_secret = $this->paypal_sandbox_client_secret;
        $data->paypal_live_client_id = $this->paypal_live_client_id;
        $data->paypal_live_client_secret = $this->paypal_live_client_secret;
        $data->update();

    }
}
