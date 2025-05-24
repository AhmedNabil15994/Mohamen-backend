<?php

namespace Modules\Reservation\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Lawyer\Repositories\Api\LawyerRepository;

class ReservationTimeExist implements Rule, DataAwareRule {
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
  public function setData($data) {
    $this->data = $data;

    return $this;
  }
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct() {
    $this->lawyerRepository = new LawyerRepository();
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value) {
    $availability = $this->lawyerRepository
      ->findLawyerAvailabilitiesByDate(
        $this->data['lawyer_id'],
        $this->data['date']
      );
    if (!$availability) {
      return false;
    }

    $times = $this->availableTimes($availability, $this->data['date']);
    return $times->where('from', $value['from'])->first();
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message() {
    return __('reservation::api.message.unavailable_time');
  }
}
