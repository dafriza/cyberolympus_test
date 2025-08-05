<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'alamat' => 'required',
            'telephone' => 'required',
            'regist_date' => 'required',
            'created_at' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'account_role' => 'nullable'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => isset(explode(' ', $this->fullname)[0]) ? explode(' ', $this->fullname)[0] : '',
            'last_name' => isset(explode(' ', $this->fullname)[1]) ? explode(' ', $this->fullname)[1] : '',
            'created_at' => $this->regist_date,
            'address' => $this->alamat,
            'phone' => $this->telephone,
            'account_role' => isset($this->account_role) ? $this->account_role : 'customer'
        ]);
    }
}
