
<ul data-parent-id="{{ $parentStaffId }}">
    @if($level-- != 0)
        @foreach($subStaffsArray as $staff)
            <li>
                <span data-id="{{ $staff->id }}"  class="{{ (isset($staff->childs) && $level == 0) ? 'haveChild' : '' }}">
                    {{ $staff->full_name }} ({{ $staff->position_name }})
                </span>
                @if(isset($staff->childs))
                    @include('staffs.particial.sub_staffs_tree',['subStaffsArray'=>$staff->childs, 'parentStaffId'=>$staff->id])
                    @else <ul data-parent-id="{{ $staff->id }}"></ul>
                @endif
            </li>
        @endforeach
    @endif
</ul>










































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

