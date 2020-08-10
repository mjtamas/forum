<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
   public function guest_may_not_create_a_thread ()
    {
        // We should expect an authenticated error exception
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        // Given we have a thread
       // $thread = factory(\App\Thread::class)->make();
       $thread = make(\App\Thread::class);

        // And a guest posts a new thread to the endpoint
        $this->post(route('threads.store', $thread->toArray()));
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();

        // Given we have a user
        $user = create(\App\User::class);

        // And that user is authenticated
        $this->signIn($user);

        // And we have a thread created by that user
        $thread = create(\App\Thread::class,['user_id' => $user->id]);

        // And once we hit the endpoint to create a new thread
        $this->post(route('threads.store', $thread->toArray()));

        // And when we visit the thread page
        $response = $this->get($thread->path());

        // Then we should see the new thread's title and body
        $response
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


}
