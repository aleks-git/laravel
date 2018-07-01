<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class Staff extends Model
{

    protected $table = 'staffs';

    protected $fillable = [
        'full_name',
        'email',
        'position_id',
        'salary',
        'employ_at',
        'parent_id',
        'password'
    ];

    protected $dates = ['employ_at'];

    public function position(){
        return $this->belongsTo('App\Position');
    }

    public function images(){
        return $this->hasOne('App\Image');
    }


    public function getEmployAtAttribute($date){
        $currentUri = Route::getCurrentRoute()->uri();
        if(strpos($currentUri, 'staffs/edit') === false)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
        else return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }


    public function setEmployAtAttribute($date){
        if(is_a($date, 'DateTime'))
            $this->attributes['employ_at'] = $date->format('Y-m-d');
        else $this->attributes['employ_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }



    /**
     * Get full staffs array with child staffs arrays
     *
     * @param $staffs
     * @return array|mixed
     */
    public static function makeStaffsArray($staffs, $rootStaffId){
        $childs = array();
        foreach($staffs as $staff){
            // $staff->position_name = Position::find($staff->position_id)->name;
            $staff->position_name = Staff::findOrFail($staff->id)->position->name;
            $childs[$staff->parent_id][] = $staff;
        }

        foreach($staffs as $staff){
            if(isset($childs[$staff->id])){
                $staff->childs = $childs[$staff->id];
            }
        }

        if(count($childs) > 0){
            $tree = $childs[$rootStaffId];
        }
        else $tree = [];

        return $tree;
    }


    /**
     * Make staffs searching
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeMakeSearch($query, $request){
        $search_string = trim($request->get('search'));
        if(!empty($search_string))
            $query = $query->when(DateTime::createFromFormat('d.m.Y', $search_string) , function ($query) use($search_string){
                return $query->whereDate('employ_at',  '=', Carbon::parse($search_string)->format('Y-m-d').' 00:00:00');
            },
                function ($query) use($search_string) {
                    return $query->where('full_name',  'LIKE', '%'.$search_string.'%')
                        ->orWhere('email',  'LIKE', '%'.$search_string.'%')
                        ->orWhere('salary',  'LIKE', '%'.$search_string.'%')
                        ->orWhereHas('position', function($q) use($search_string){
                            $q->where('name',  'LIKE', '%'.$search_string.'%');
                        });
                });

        return $query;
    }


    /**
     * Make staffs sorting
     * @param $query
     * @param $sortKey
     * @param $sortVal
     * @return mixed
     */
    public function scopeMakeSortBy($query, $sortKey, $sortVal){
        if(Schema::hasColumn('staffs', $sortKey)){
            $sortValText = $sortVal == 1 ? 'asc' : 'desc';

            if($sortKey == 'position') {
                return $query->join('positions', 'staffs.position_id', '=', 'positions.id')
                    ->orderBy('positions.name', $sortValText);
            }
            else return $query->orderBy($sortKey, $sortValText);
        }
    }


    /**
     * Get current sort param (key and value)
     * @param $sortParam
     * @return array
     */
    public static function getSortParam($sortParam){
        foreach($sortParam as $key=>$value){
            $sortKey = trim($key);
            $sortVal = (int)$value;
        }
        return array('sortKey'=>$sortKey, 'sortVal'=>$sortVal);
    }




}
