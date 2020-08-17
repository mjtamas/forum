@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @forelse ($threads as $thread)
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ route('threads.show', [$thread->channel->slug, $thread->id]) }}">{{ $thread->title }}</a>

                                </h4>
                                <a href=" {{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->replies_count }}
                                    {{ str_plural('reply', $thread->replies_count) }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p>There are no relevant threads in this channel.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
