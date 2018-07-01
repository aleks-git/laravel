
@if(count($staffs) > 0)
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col th-inner sortable both">Фото</th>
            <th scope="col th-inner sortable both">
                <a href="{{ action('StaffsController@allStaffs', array('sort[full_name]' => $sortKey=='full_name'?!$sortVal:1)) }}" >
                    ФИО
                </a>
                <i class="fa fa-fw  {{$sortKey=='full_name'?($sortVal==1?'fa-sort-asc':'fa-sort-desc'):'fa-sort'}}" data-sort="full_name"></i>
            </th>
            <th scope="col th-inner sortable both">
                <a href="{{ action('StaffsController@allStaffs', array('sort[email]' => $sortKey=='email'?!$sortVal:1)) }}" >
                    Email
                </a>
                <i class="fa fa-fw  {{$sortKey=='email'?($sortVal==1?'fa-sort-asc':'fa-sort-desc'):'fa-sort'}}" data-sort="email"></i>
            </th>
            <th scope="col th-inner sortable both">
                <a href="{{ action('StaffsController@allStaffs', array('sort[position]' => $sortKey=='position'?!$sortVal:1)) }}" >
                    Должность
                </a>
                <i class="fa fa-fw  {{$sortKey=='position'?($sortVal==1?'fa-sort-asc':'fa-sort-desc'):'fa-sort'}}" data-sort="position"></i>
            </th>
            <th scope="col th-inner sortable both">
                <a href="{{ action('StaffsController@allStaffs', array('sort[salary]' => $sortKey=='salary'?!$sortVal:1)) }}" >
                    Зарплата
                </a>
                <i class="fa fa-fw  {{$sortKey=='salary'?($sortVal==1?'fa-sort-asc':'fa-sort-desc'):'fa-sort'}}" data-sort="salary"></i>
            </th>
            <th scope="col th-inner sortable both">
                <a href="{{ action('StaffsController@allStaffs', array('sort[employ_at]' => $sortKey=='employ_at'?!$sortVal:1)) }}" >
                    Дата найма
                </a>
                <i class="fa fa-fw  {{$sortKey=='employ_at'?($sortVal==1?'fa-sort-asc':'fa-sort-desc'):'fa-sort'}}" data-sort="employ_at"></i>
            </th>
            <th scope="col th-inner"></th>
        </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
                <tr>
                    <td>
                        <a href="{{ action('StaffsController@show', $staff->id) }}">
                            <img src="{{ $staff->images? asset($staff->images->preview_img) : asset('/images/no-photo.jpg') }}" class="staff_preview_img" />
                        </a>
                    </td>
                    <td><a href="{{ action('StaffsController@show', $staff->id) }}">{{ $staff->full_name }}</a></td>
                    <td>{{ $staff->email }}</td>
                    <td>{{ $staff->position->name }}</td>
                    <td>{{ $staff->salary }}</td>
                    <td>{{ $staff->employ_at }}</td>
                    <td>
                        <a href="{{ action('StaffsController@edit', $staff->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        {{ Form::open(['method'=>'DELETE', 'action'=>['StaffsController@destroy', $staff->id], 'class'=>'d-inline float-right']) }}
                            <button class="float-right btn btn-danger p-0"><i class="fa fa-times" aria-hidden="true"></i></button>
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $staffs->links() }}
@else Здесь нет пользователей, которых вы ищете)
@endif


