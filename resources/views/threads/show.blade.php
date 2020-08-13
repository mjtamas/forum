@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: rgb(105, 162, 214)">
                        <div class="level">
                            <span class="flex">
                                {{ $thread->title }}
                            </span>
                        <form action="{{route('threads.show',[$thread->channel->slug,$thread->id])}}" method="POST">
                        @csrf
                        {{method_field('DELETE')}}

                        <button type="submit" class="btn btn-link">Delete Thread</button>
                        </form>

                        </div>

                    </div>

                    <div class="card-body">

                        {{ $thread->body }}

                    </div>
                </div>


                @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach

                {{$replies->links()}}

                @auth
                    <form method="POST" action="{{ route('replies.store', [$thread->channel, $thread]) }}">
                        @csrf
                        <div class="form-group" style="margin-top: 2em">
                            <textarea name="body" id="body" class="form-control" placeholder="What's in your mind?" rows="5"
                                required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @endauth
                @guest
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to add reply!</p>
                @endguest
            </div>

            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{route('profiles.show',$thread->creator)}}">{{ $thread->creator->name }}</a> and currently has
                            {{ $thread->replies_count }} {{str_plural('comment', $thread->replies_count)}}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
