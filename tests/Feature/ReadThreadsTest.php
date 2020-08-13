<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = create(\App\Thread::class);
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $this->get(route('threads.index'))->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get(route('threads.show',[$this->thread->channel,$this->thread]))->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create(\App\Reply::class,['thread_id' => $this->thread->id]);

        $this->get(route('threads.show',[$this->thread->channel,$this->thread]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(\App\Channel::class);
        $threadInChannel = create(\App\Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(\App\Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create(\App\User::class,['name' => 'UserName']));

        $threadByUserName = create(\App\Thread::class, ['user_id' => auth()->id()]);
        $threadNotByUserName = create(\App\Thread::class);

        $this->get('threads?by=UserName')
            ->assertSee($threadByUserName->title)
            ->assertDontSee($threadNotByUserName->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies=create(\App\Thread::class);
        create(\App\Reply::class,['thread_id' => $threadWithThreeReplies->id],3);
        $threadWithTwoReplies=create(\App\Thread::class);
        create(\App\Reply::class,['thread_id' => $threadWithTwoReplies->id],2);
        $threadWithNoReplies=$this->thread;

        $response = $this->get('threads?popular=1');
        $response->assertSeeInOrder([
            $threadWithThreeReplies->title,
            $threadWithTwoReplies->title,
            $threadWithNoReplies->title
          ]);


    }
}
