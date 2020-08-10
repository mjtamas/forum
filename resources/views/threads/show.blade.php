@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">

                        {{ $thread->body }}

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($thread->replies as $reply)
                    @include ('threads.reply')
                @endforeach
            </div>
        </div>

        @auth
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('replies.store',$thread) }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body"  class="form-control" placeholder="What's in your mind?" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>

        @endauth
        @guest
            <p class="text-center">Please <a href="{{route('login')}}">sign in</a>  to add reply!</p>
        @endguest
    </div>
@endsection
