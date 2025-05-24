<?php

namespace Modules\Level\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LevelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= [
                    'title.*'	     => 'required',
                    'image'	         => 'nullable',
                    'winning_count'	 => 'required|integer|min:0',
                ];

        if ($this->isMethod('PUT')) {
            $rules['image'] = 'sometimes';
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
