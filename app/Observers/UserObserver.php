<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    
    /**
     * created - handle the user "created" event
     *
     * @param \App\Models\User $user
     */
    public function created(User $user)
    {
        //dd(request()->all());
    }
}
