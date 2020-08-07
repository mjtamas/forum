<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;




    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {

        $this->be($user = factory(\App\User::class)->create());
        $thread = factory(\App\Thread::class)->create();
        $reply = factory(\App\Reply::class)->create();
        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }
}
