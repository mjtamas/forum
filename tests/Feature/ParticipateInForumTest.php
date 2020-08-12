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

        $this
            ->post('/threads/some-channel/1/replies',[])
            ->assertRedirect('/login');

    }


    /** @test */
   public function an_authenticated_user_may_participate_in_forum_threads()
    {

        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class);

        $this->post(route('threads.show',[$thread->channel,$thread]).'/replies', $reply->toArray());
        $this->get(route('threads.show',[$thread->channel,$thread]))->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {

        $this->signIn();
        $thread = create(\App\Thread::class);
        $reply = make(\App\Reply::class,['body' => null]);
        $this->post(route('threads.show',[$thread->channel,$thread]).'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');

    }
}
