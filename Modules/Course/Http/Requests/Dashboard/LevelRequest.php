<?php

namespace Modules\Course\Http\Requests\Dashboard;

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
                'title.*'           =>'required',
                'short_desc.*'      =>'required',
                'desc.*'            =>'required',
                'image'	            =>'required|image|max:2048',
                'pdf'               =>'required|file|max:2048',
                'start_exam'        =>'exclude_unless:require_start_exam,true|exists:exams,id',
                'end_exam'          =>'exclude_unless:require_start_exam,true|exists:exams,id',
                ];

        if ($this->isMethod('PUT')) {
            $rules['image']     = 'sometimes';
            $rules['pdf']       = 'sometimes';
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
