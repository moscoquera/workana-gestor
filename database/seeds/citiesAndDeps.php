<?php

use Illuminate\Database\Seeder;

class citiesAndDeps extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $handler = fopen('cities.txt','r');
        $deps=[];
        $cities=[];

        while(( $data = fgetcsv($handler))!== FALSE){
            if (!isset($deps[$data[2]])){
                $deps[$data[2]]=$data[3];
            }
            array_push($cities,[
               'id'=>intval($data[0]),
               'name'=>$data[1],
               'department_id'=>$data[2]
            ]);
        }

        foreach($deps as $code=>$name){
            $depid=DB::table('departments')->where('name',$name)->value('id');
            if (!$depid){
                $depid = DB::table('departments')->insertGetId([
                    'name'=>$name
                ]);
            }
            $deps[$code]=$depid;
        }

        foreach ($cities as $city){
            if (DB::table('cities')->where('name',$city['name'])->where('department_id',$deps[$city['department_id']])->count()==0){
                DB::table('cities')->insert([
                    'name'=>$city['name'],
                    'department_id'=>$deps[$city['department_id']]
                ]);
            }
        }

    }
}
