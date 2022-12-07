@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th>Id</th>
                <th>{{$post->id}}</th>
            </tr>
            <tr>
                <th>Id</th>
                <th>{{$post->body}}</th>
            </tr>
            <tr>
                <th>Id</th>
                <th>{{$post->created_at}}</th>
            </tr>
            <tr>
                <th>Id</th>
                <th>{{$post->updated_at}}</th>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
