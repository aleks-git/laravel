<?php

use Illuminate\Database\Seeder;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $parentArrayIdsLevel_1 = array();
        $parentArrayIdsLevel_2 = array();
        $parentArrayIdsLevel_3 = array();
        $parentArrayIdsLevel_4 = array();


        factory(App\Position::class, 'positions', 5)->create();

        factory(App\Staff::class, 'staffs', 1)->create(['full_name'=>'Супер Босс','position_id'=>1])->each(function($staff) use(&$parentArrayIdsLevel_1){
            $parentArrayIdsLevel_1[] = $staff->id;
        });



        factory(App\Staff::class, 'staffs', 10)->create(['position_id'=>2, 'salary'=>2000])->each(function($staff) use (&$parentArrayIdsLevel_2, $parentArrayIdsLevel_1){
            $parentArrayIdsLevel_2[] = $staff->id;
            $staff->parent_id = $parentArrayIdsLevel_1[array_rand($parentArrayIdsLevel_1)];
            $staff->save();
        });



        factory(App\Staff::class, 'staffs', 30)->create(['position_id'=>3, 'salary'=>1500])->each(function($staff) use (&$parentArrayIdsLevel_3, $parentArrayIdsLevel_2){
            $parentArrayIdsLevel_3[] = $staff->id;
            $staff->parent_id = $parentArrayIdsLevel_2[array_rand($parentArrayIdsLevel_2)];
            $staff->save();
        });



        factory(App\Staff::class, 'staffs', 60)->create(['position_id'=>4, 'salary'=>1000])->each(function($staff) use (&$parentArrayIdsLevel_4, $parentArrayIdsLevel_3){
            $parentArrayIdsLevel_4[] = $staff->id;
            $staff->parent_id = $parentArrayIdsLevel_3[array_rand($parentArrayIdsLevel_3)];
            $staff->save();
        });


        factory(App\Staff::class, 'staffs', 200)->create(['position_id'=>5, 'salary'=>500])->each(function($staff) use ($parentArrayIdsLevel_4){
            $staff->parent_id = $parentArrayIdsLevel_4[array_rand($parentArrayIdsLevel_4)];
            $staff->save();
        });



        /*
        factory(App\Staff::class, 'staffs', 16000)->create(['position_id'=>5, 'salary'=>500])->each(function($staff) use ($parentArrayIdsLevel_4){
            $staff->parent_id = $parentArrayIdsLevel_4[array_rand($parentArrayIdsLevel_4)];
            $staff->save();
        });
        */
    }
}
