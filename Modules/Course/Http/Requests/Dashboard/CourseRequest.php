<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title.*'                           => 'required',
            'desc.*'                            => 'required',
            'period'                            => 'required|string',
            'image'                             => 'required|image|max:2048',
            'price'                             => 'required|numeric',
            'categories'                        => 'required|array',
            'categories.*'                      => 'required|exists:categories,id',
            'instructor_id'                     => 'required|exists:users,id',
            'intro_video'                       => 'sometimes|file|mimes:mp4,mov,ogg,qt|max:20000'

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
