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
}
