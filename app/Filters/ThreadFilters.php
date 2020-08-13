<?php

namespace App\Filters;

use App\User;
use App\Filters\Filters;

class ThreadFilters extends Filters
{
    protected array $filters = ['by' , 'popular'];

    /**
     * Filter the query by a given username.
     *
     * @param string $username
     * @return mixed
     */

    protected function by(string $userName)
    {
        $user = User::whereName($userName)->firstOrFail();

        return $this->builder->whereUserId($user->id);
    }

     /**
     * Filter the query by popularity.
     *
     *
     * @return $this
     */
    protected function popular()
    {
        return $this->builder->orderBy('replies_count','desc');
    }
}
