<?php

namespace Modules\Reservation\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Illuminate\Contracts\Validation\DataAwareRule;
use Modules\Lawyer\Repositories\Api\LawyerRepository;

class Vacation implements Rule, DataAwareRule
{
    use WorkingWithTimeTrait;
    public $lawyerRepository;
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];


    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lawyerRepository = new LawyerRepository();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $lawyer = $this->lawyerRepository->findById($this->data['lawyer_id']);
        return !($lawyer->isClosedOn($this->data['date']));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('lawyer::Api.messages.is_closed_message');
    }
}
