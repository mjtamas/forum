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

        $this->withExceptionHandling();

        $this->get(route('threads.create'))
            ->assertRedirect('/login');

        $this->post(route('threads.store'))
            ->assertRedirect('/login');

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
        die($this->get(route('threads.show',[$thread->channel->slug,$thread->id])));



        // // Then we should see the new thread's title and body
        // $response
        //     ->assertSee($thread->title)
        //     ->assertSee($thread->body);
    }


}
