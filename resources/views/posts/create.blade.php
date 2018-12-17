@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['action' => 'PostsController@store' , 'method', 'POST' , 'enctype'=> 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('University_Name','University Name')}}
            {{Form::text('University_Name','',['class'=>'form-control','placeholder'=>'Enter your university name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Enty_Date','Entry Date')}}
            <div class="input-group">
                <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
                </div>
                {{Form::text('Entry_Date','',['class'=>'form-control','placeholder'=>'DD/MM/YYYY'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('Release_Date','Release Date')}}
            <div class="input-group">
                <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
                </div>
                {{Form::text('Release_Date','',['class'=>'form-control','placeholder'=>'DD/MM/YYYY'])}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('Advantages', 'Advantages')}}
            {{Form::textArea('Advantages','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Enter the advanteges of this university'])}}
        </div>
        <div class="form-group">
            {{Form::label('Drowbacks', 'Drowbacks')}}
            {{Form::textArea('Drowbacks','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Enter the dowbacks of this university'])}}
        </div>
        <div class="form-group">
            {{Form::label('Tips', 'Tips')}}
            {{Form::textArea('Tips','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Tips'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_img')}}
        </div>
        {{Form::submit('submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection