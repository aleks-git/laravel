@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="header_block col-md-12">
            <h1 class="d-block text-center">Добавить нового Сотрудника</h1>
        </div>

        <div class="col-md-6">
            @include('staffs.particial.errors')

            {{ Form::open(['url'=>'staffs', 'enctype'=>'multipart/form-data']) }}

                <div class="form-group">
                    {{ Form::label('full_name', 'ФИО') }}
                    {{ Form::text('full_name', null, ['class'=>'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::text('email', null, ['class'=>'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('position_id', 'Должность') }}
                    {{ Form::select('position_id', $positions, null, ['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('parent_name', 'Начальник') }}
                    {{ Form::text('parent_name', null, ['class'=>'form-control', 'id'=>'parent_name', 'required', 'placeholder'=>'Начните ввод ФИО начальника']) }}
                    {{ Form::hidden('parent_id', null, ['class'=>'form-control', 'id'=>'parent_id']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('salary', 'Зарплата') }}
                    {{ Form::number('salary', null, ['class'=>'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('employ_at', 'Дата найма') }}
                    {{ Form::date('employ_at', null, ['class'=>'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <div class="avatar-container">
                        <img id="imageAvatar" src="{{ asset('/images/no-photo.jpg') }}" alt="" title="Фото сотрудника" />
                    </div>
                    <div class="addAvatarText btn btn-outline-info">
                        {{ Form::file('avatar', ['id'=>'avatarInput']) }}
                        Изменить </br> фото
                    </div>
                </div>

                {{ Form::submit('Добавить', ['class'=>'btn btn-primary form-control']) }}

            {{ Form::close() }}
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

