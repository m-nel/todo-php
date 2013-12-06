
<footer id="footer">

  <span id="todo-count">
    <strong>{{ Task::todo()->get()->count() }}</strong> item{{ Task::todo()->get()->count()==1?'':'s' }} left
  </span>

  <ul id="filters">
    <li>
      {{ link_to_route('home', 'All', [], ['class' => Request::query('filter')?'':'selected']) }}
    </li>
    <li>
      {{ link_to_route('home', 'Active', ['filter' => 'active'], ['class' => Request::query('filter') == 'active'?'selected':'']) }}
    </li>
    <li>
      {{ link_to_route('home', 'Completed', ['filter' => 'completed'], ['class' => Request::query('filter') == 'completed'?'selected':'']) }}
    </li>
  </ul>

  @if(count(Task::completed()->get()))
    {{ Form::open(['route' => 'tasks.clearCompleted', 'method' => 'PATCH']) }}
      <button id="clear-completed">
        Clear completed ({{ Task::completed()->get()->count() }})
      </button>
    {{ Form::close() }}
  @endif

</footer>