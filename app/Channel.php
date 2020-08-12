<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    //    solved by defining the routekeyname in web.php - Route
    // }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
