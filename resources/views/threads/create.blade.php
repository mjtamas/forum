@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create a New Thread') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('threads.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label for="channel_id">Choose a channel:</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">Choose a one...</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                                @error('channel_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control  " id="title" name="title"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea name="body" id="body" class="form-control" rows="10" required>{{ old('body') }}</textarea>
                                @error('body')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-primary">Publish</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
