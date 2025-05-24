<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= [
                 'title.*'	 => 'required',
                 'course_id' => 'required|exists:courses,id',
                 'image'	 => 'required|image|max:2048',
                 'status'	 => 'nullable',
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
