<?php

namespace App\Filters;

use App\User;
use App\Filters\Filters;

class ThreadFilters extends Filters
{
    protected array $filters = ['by'];

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
}
