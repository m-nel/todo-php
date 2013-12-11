<?php

class BaseModel extends Eloquent {

  /**
   * The models validation errors
   * 
   * @var array
   */
  protected $errors;

  /**
   * Validate the model.
   * 
   * @return bool
   */
  public function validate()
  {
    if ($this->fireModelEvent('validating') === false)
    {
      return false;
    }

    $validation = Validator::make($this->getAttributes(), static::$rules);

    if($validation->fails())
    {
      $this->errors = $validation->messages();
      return false;
    }

    $this->fireModelEvent('validated', false);

    return true;
  }

  /**
   * Get all the current validation errors of the model.
   * 
   * @return array
   */
  public function getErrors()
  {
    return $this->errors;
  }

  /**
   * Register a validating model event with the dispatcher.
   * 
   * @param Closure|string $callback
   * @return void
   */
  public static function validating($callback)
  {
    static::registerModelEvent('validating', $callback);
  }

  /**
   * Register a validated model event with the dispatcher.
   * 
   * @param Closure|string $callback
   * @return void
   */
  public static function validated($callback)
  {
    static::registerModelEvent('validated', $callback);
  }

  /**
   * Get the observable event names.
   *
   * @return array
   */
  public function getObservableEvents()
  {
    return array_merge(
      parent::getObservableEvents(),
      [
        'validating',
        'validated'
      ]
    );
  }
}