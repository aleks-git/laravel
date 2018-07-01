@extends('layouts.app')

@section('content')

    @if(Session::has('main_staff_message'))
        <div class="alert alert-success">
            {{ Session('main_staff_message') }}
        </div>
    @endif
    {{ Form::open(['method'=>'get', 'action'=>'StaffsController@allStaffs', 'id'=>'staffSearchForm']) }}
        <div class="form-group">
            {{ Form::text('search', null, ['class'=>'form-controll p-1 pb-2', 'id'=>'searchInput', 'placeholder'=>'Поиск']) }}
            {{ Form::submit('Поиск', ['class'=>'btn btn-primary']) }}
            <a href="#x" id="resetParam" class="btn d-inline btn-dark mr-1 float-right">Сбросить все параметры</a>
        </div>
    {{ Form::close() }}

    <div id="table_block">
        @include('staffs.particial.load_staffs')
    </div>

@endsection


