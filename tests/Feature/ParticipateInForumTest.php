<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $thread = create(\App\Thread::class);
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();
        $this->post(route('replies.store', $thread), []);

    }


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {

        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class);

        $this->post(route('threads.show',$thread).'/replies', $reply->toArray());
        $this->get(route('threads.show',$thread))->assertSee($reply->body);
    }
}
