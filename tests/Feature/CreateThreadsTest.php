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


        $this->signIn();

        $thread = create(\App\Thread::class);

        $this->post('/threads',$thread->toArray());

        $this->get(route('threads.show',[$thread->channel->slug,$thread->id]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }


}
