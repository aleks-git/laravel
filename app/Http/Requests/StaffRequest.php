<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
        $rulesArray = [
            'full_name' => 'required|min:3',
            'email' => 'required|email|unique:staffs',
            'position_id' => 'required',
            'parent_id' => 'required',
            'salary' => 'required|integer',
            'employ_at' => 'required:date',
            'avatar'=> 'image|max:3072'
        ];

        if($this->method() == 'PATCH') array_set($rulesArray, 'email', 'required|email|unique:staffs,id'.$this->get('id'));
        return $rulesArray;
    }
}
