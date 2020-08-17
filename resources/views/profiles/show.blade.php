@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->name }}
                <small> - Joined {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        @foreach ($profileUser->threads as $thread)
            <div class="card">
                <div class="card-header" style="background-color: rgb(105, 162, 214)">

                    <a href="{{ route('threads.show', [$thread->channel->slug, $thread->id]) }}">{{ $thread->title }}</a>

                </div>

                <div class="card-body">

                    {{ $thread->body }}

                </div>
            </div>

        @endforeach
    </div>

@endsection
