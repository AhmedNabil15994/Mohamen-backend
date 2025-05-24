<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LessonContentRequest extends FormRequest
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
                   'lesson_id'	 => 'required|exists:lessons,id',
                   'type'	     => 'required|in:exam,resource,video',
                   'exam_id'	 => 'required_if:type,exam',
                   'resource'	 => 'required_if:type,resource',
                   'video'	     => 'required_if:type,video',
                   'order'	     => 'nullable|required|integer'
                ];

        if ($this->isMethod('PUT')) {
            if ($this->model_type== 'video'&&$this->type='video') {
                $rules['video']	 = 'sometimes';
            }
            if ($this->model_type=='resource'&&$this->type='resource') {
                $rules['resource']	 = 'sometimes';
            }
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



/**
 * model_type $model->type (old_type)
 * if old_type== 'video'&&type='video'
 * then video sometimes and delete if there is new
 * if old_type== 'resource'&&type='resource'
 * then resource sometimes
 * and delete if there is new
 * if old_type !== type
 * it mean post validation
 */
