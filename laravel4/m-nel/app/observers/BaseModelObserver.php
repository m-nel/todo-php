<?php

class BaseModelObserver {

  /**
   * Validate the model before saving.
   * 
   * @return boolean
   */
  public function saving($model)
  {
    return $model->validate();
  }
}