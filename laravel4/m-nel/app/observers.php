<?php

BaseModel::observe(App::make('BaseModelObserver'));
Task::observe(App::make('TaskObserver'));