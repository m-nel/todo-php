<?php

class Task extends BaseModel {

  /**
   * Do not use timestamps
   * 
   * @var bool
   */
  public $timestamps = false;

  /**
   * Whitelist of attributes that are mass assignable
   * 
   * @var array
   */
  protected $fillable = ['title','completed'];

  /**
   * Validation rules of the model's attributes
   * 
   * @var array
   */
  protected static $rules = [
    'title' => 'required'
  ];

  /**
   * Trim the title before setting it.
   * 
   * @return void
   */
  public function setTitleAttribute($title)
  {
    $this->attributes['title'] = trim($title);
  }

  /**
   * Scope
   * Only tasks that have not been completed.
   * 
   * @return Illuminate\Database\Eloquent\Builder
   */
  public function scopeTodo($query)
  {
    return $query->whereCompleted(false);
  }

  /**
   * Scope
   * Only tasks that are completed.
   * 
   * @return Illuminate\Database\Eloquent\Builder
   */
  public function scopeCompleted($query)
  {
    return $query->whereCompleted(true);
  }

  /**
   * Scope
   * Apply the specified scope.
   * If the scope does not exist, default fallback is no scope applied.
   * 
   * @return Illuminate\Database\Eloquent\Builder
   */
  public function scopeFilterBy($query, $by)
  {
    switch($by)
    {
      case 'active';
        return $query->todo();
      case 'completed';
        return $query->completed();
      default:
        return $query;
    }
  }

  /**
   * Toggle the status of all the tasks. If all tasks are completed 
   * make all tasks active, otherwise make all tasks completed.
   * 
   * @return void
   */
  public static function toggleAll()
  {
    DB::table('tasks')->update(['completed' => Task::hasTodo()]);
  }

  /**
   * Determine if an active task exists.
   * 
   * @return bool
   */
  public static function hasTodo()
  {
    return Task::todo()->count() > 0;
  }
}