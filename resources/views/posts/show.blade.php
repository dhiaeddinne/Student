@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h3>University Name</h3>
    <p>{{$posts->University_Name}}</p>
    <h3>Advantages</h3>
    <p>{!!$posts->Advantage!!}</p>
    <h3>Drowbacks</h3>
    <p>{!!$posts->Drowbacks!!}</p>
    <h3>Some Tips That may help you</h3>
    <p>{!!$posts->Tips!!}</p>
    <hr>
    <small>Written On {{$posts->created_at}}</small>
    <br><br>
    @if (!Auth :: guest())
        @if (Auth::user()->id == $posts->user_id)
            <a href="/posts/{{$posts->id}}/edit" class="btn btn-default">Edit</a>
            {!! Form::open(['action' => ['PostsController@destroy',$posts->id] , 'method', 'POST' , 'class'=>'pull-right']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection