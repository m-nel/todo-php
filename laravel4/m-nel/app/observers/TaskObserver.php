<?php

class TaskObserver {

  /**
   * If the title is empty and the model already exists, delete the task.
   *
   * @return boolean False if the task has been deleted, true otherwise.
   */
  public function validating($task)
  {
    if ($task->exists && empty($task->title))
    {
      $task->delete();
      return false;
    }

    return true;
  }
}