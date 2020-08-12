<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{
   use DatabaseMigrations;

   /** @test */
   public function a_channel_consists_of_threads()
   {
        $channel = create(\App\Channel::class);
        $thread = create(\App\Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));

   }
}
