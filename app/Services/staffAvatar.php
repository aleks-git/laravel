<?php


namespace App\Services;

use App\Image as ImageStaff;
use Intervention\Image\Facades\Image;

class StaffAvatar
{
    /**
     * Load staff avatar and make preview
     * @param $staff
     * @param $request
     */
    static function makeAvatar($staff, $request){
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = 'ava_'.$staff->id.'.'.$extension;
            $file->move(public_path().'/images/avatars/full/',$filename);

            ImageStaff::updateOrCreate(['staff_id'=>$staff->id], ['preview_img'=>'images/avatars/preview/'.$filename, 'full_img'=>'images/avatars/full/'.$filename]);

            Image::make('images/avatars/full/' . $filename)->resize(50, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('images/avatars/preview/' . $filename);

        }
    }

}