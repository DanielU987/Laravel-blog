@extends('layouts.app')
@section('content')
    @include('partials.post-card')
    <h3 class="m-4">Comments</h3>
    <div class="card">
        <form action="{{route('post.comment',['post'=>$post])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <textarea class="form-control" name="comment" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Add comment">
            </div>

        </form>
    </div><br>
    <div>


        @foreach($post->comments()->latest()->get() as $comment)
            <div class="card">
                <div class="card-body">
                    <p class="card-text">{{$comment->body}}</p>
                </div>
                <div class="card-footer">
                    {{$comment->user->name}}<br>
                    {{$comment->created_at->diffForHumans()}}
                </div>

            </div>
            <br>
        @endforeach
    </div>
@endsection
