<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create (User $user) {
        return true;
    }
    public function edit (User $user, Topic $topic) {
        return $user->id == $topic->author_id ? Response::allow() : Response::deny('You do not own this topic.');;
    }
    public function update (User $user, Topic $topic) {
        return $user->id == $topic->author_id ? Response::allow() : Response::deny('You do not own this topic.');;
    }
    public function delete (User $user, Topic $topic) {
        return $user->id == $topic->author_id;
    }
}
