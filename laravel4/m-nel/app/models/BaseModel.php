<?php

class BaseModel extends Eloquent {

  protected $errors;

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

  public static function validating($callback)
  {
    static::registerModelEvent('validating', $callback);
  }

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

  public function getErrors()
  {
    return $this->errors;
  }
}