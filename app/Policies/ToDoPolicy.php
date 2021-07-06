<?php

namespace App\Policies;

use App\Models\ToDo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ToDoPolicy
{
    use HandlesAuthorization;

    public function authorizeUser(User $user, ToDo $toDo)
    {
        return $user->id === $toDo->user_id ? Response::allow()
            : false;
    }
}
