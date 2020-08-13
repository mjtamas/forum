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

        $response = $this->post('/threads',$thread->toArray());

        $this->get(route('threads.show',[$thread->channel->slug,$thread->id]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory(\App\Channel::class,2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function guests_cannot_delete_threads()
    {
        $thread = create(\App\Thread::class);

        $response = $this->delete(route('threads.show',[$thread->channel->slug,$thread->id]) );
        $response->assertRedirect('/login');

    }

    /** @test */
    public function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create(\App\Thread::class);
        $reply = create(\App\Reply::class,['thread_id' => $thread->id]);


        $this->json('DELETE',route('threads.show',[$thread->channel->slug,$thread->id]) );

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);

    }

    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(\App\Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
