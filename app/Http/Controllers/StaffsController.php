<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Position;
use App\Staff;
use App\Image as ImageStaff;
use Illuminate\Http\Request;
use App\Services\StaffAvatar;

class StaffsController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['only'=>['allUsers', 'show', 'edit', 'create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parentStaffId = $request->get('parent_staff_id', 0);
        if($parentStaffId == 0) $level = 2;
        else $level = 5;

        $staffs = Staff::all();
        $staffsArray = Staff::makeStaffsArray($staffs, $parentStaffId);
        if ($request->ajax()) {
            $subStaffsArray = $staffsArray;
            return view('staffs.particial.sub_staffs_tree', compact('subStaffsArray', 'level', 'parentStaffId'));
        }
        return view('staffs.index', compact('staffsArray', 'level', 'parentStaffId'));
    }


    /**
     * Change Staff parent
     *
     * @param Request $request
     * @return string
     */
    public function staffChangeParent(Request $request){
        if($request->has(['elem_id', 'new_parent_id']) && $request->ajax()){
             Staff::findOrFail($request->elem_id)->update(['parent_id' => $request->new_parent_id]);
             return 'success';
        }
    }


    /**
     * Show all staffs in the list with opportunity
     * of sorting and searching
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allStaffs(Request $request){
        $sortParam = $request->get('sort');
        $staffs = Staff::with('position', 'images');
        $sortKey = '';

        if(isset($sortParam)){
            $sortParamArray = Staff::getSortParam($sortParam);
            $staffs = $staffs->makeSortBy($sortParamArray['sortKey'], $sortParamArray['sortVal']);
        }
        //$staffs = $this->>makeSearch($staffs, $request)->paginate(5);
        $staffs = $staffs->makeSearch($request)->paginate(5);

        if ($request->ajax()) {
            return view('staffs.particial.load_staffs', compact('staffs', 'sortKey', 'sortVal'))->render();
        }
        return view('staffs.all_staffs', compact('staffs', 'sortKey', 'sortVal'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::pluck('name', 'id');
        return view('staffs.create', compact('positions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $staff = Staff::create($request->all());
        StaffAvatar::makeAvatar($staff, $request);
        session()->flash('main_staff_message', 'Новый сотрудник '.$staff->full_name.' успешно создан');
        return redirect ('staffs');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        $staff->images;
        return view('staffs.show', compact('staff'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        $positions = Position::pluck('name', 'id');
        $parentId = $staff->parent_id;

        if($parentId != 0) $parentName = Staff::find($parentId)->full_name;
        else $parentName = 'Это Супер Босс - у него нет начальника!';

        $staff->images;
        return view('staffs.edit', compact('staff', 'positions', 'parentName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $staff->update($request->all());
        StaffAvatar::makeAvatar($staff, $request);
        session()->flash('main_staff_message', 'Данные сотрудника '.$staff->full_name.' успешно отредактированы.');
        return redirect('staffs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        Staff::where('parent_id', $staff->id)->update(['parent_id' => $staff->parent_id]);
        $image = ImageStaff::where('staff_id', $staff->id);
        if($image->count() > 0){
            if(is_file($fullImgSrc = $image->firstOrFail()->full_img)) unlink($fullImgSrc);
            if(is_file($previewImgSrc = $image->firstOrFail()->preview_img)) unlink($previewImgSrc);
            $image->delete();
        }
        $staff->delete();
        session()->flash('main_staff_message', 'Сотрудник '.$staff->full_name.' успешно удалён');
        return redirect(action('StaffsController@allStaffs'));
    }


    /**
     * Search staff by fullname with limit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function staffsSearch(Request $request){
        $search_string = $request->nameStartsWith;
        $staffs = Staff::where('full_name',  'LIKE', '%'.$search_string.'%')->get()->take(10);
        return response()->json($staffs);
    }


}
