@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="header_block col-md-12">
            <h1 class="d-block float-left">{{ $staff->full_name }}</h1>
            {{ Form::open(['method'=>'DELETE', 'action'=>['StaffsController@destroy', $staff->id], 'class'=>'d-block float-right']) }}
                {{ Form::submit('Удалить', ['class'=>'btn btn-danger']) }}
            {{ Form::close() }}
            <a href="{{ action('StaffsController@edit', $staff->id) }}" class="btn d-inline btn-primary float-right mr-1">Редактировать</a>
        </div>

        <div class="info_block col-md-12 row">
            <div class="image_block col-md-2">
                <img src="{{ $staff->images ? asset($staff->images->full_img) : asset('/images/no-photo.jpg') }}" />
            </div>
            <ul class="list-group list-group col-md-10">
                <li class="list-group-item">Email: {{ $staff->email }}</li>
                <li class="list-group-item">Должность: {{ $staff->position->name }}</li>
                <li class="list-group-item">Зарплата: {{ $staff->salary }}</li>
                <li class="list-group-item">Дата найма: {{ $staff->employ_at }}</li>
            </ul>
        </div>
    </div>

@endsection











































{{--@if(count($tasks) > 0)--}}
    {{--<ul class="list-group col-lg-6">--}}
        {{--@foreach($tasks as $task)--}}
            {{--<li class="list-group-item">--}}
                {{--<div class="float-left"><a href="{{ action('TasksController@show', $task->id) }}">{{ $task->name }}</a></div>--}}
                {{--{{ Form::open(['method'=>'DELETE', 'action'=>['TasksController@destroy', $task->id], 'class'=>'d-inline float-right']) }}--}}
                {{--<button class="float-right btn btn-danger">DELETE</button>--}}
                {{--{{ Form::close() }}--}}
                {{--<a href="{{ action('TasksController@edit', $task->id) }}" class="btn d-inline btn-primary float-right mr-1">EDIT</a>--}}
            {{--</li>--}}
        {{--@endforeach--}}
    {{--</ul>--}}
{{--@endif--}}
{{--<div class="col-lg-6">--}}
    {{--<a href="{{url('tasks/create')}}" class="mt-3 btn btn-dark float-right">ADD TASK</a>--}}
{{--</div>--}}

