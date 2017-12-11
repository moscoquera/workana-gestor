<?php

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Town;
use App\Models\Neighborhood;


class BarranquillaNeighborhoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file =fopen('neighborhoods.txt','r');
        $ultimaZona=false;
        $barranquilla=City::where('name','Barranquilla')->first();
        while(($line = fgets($file))!==false){
            if (!$line){continue;}
            $line=trim($line);
            if(substr($line,0,3)==='==='){
                $line=str_replace('===','',$line);
                $line=str_replace(']]','',$line);
                $line=str_replace('[[','',$line);
                if(strpos($line,'|')!==false){
                    $line=explode('|',$line)[1];
                }
                $ultimaZona=Town::create([
                    'name'=>$line,
                    'city_id'=>$barranquilla->id
                ]);
            }elseif(substr($line,0,1) ==='*') {
                $line = substr($line, 1);
                Neighborhood::create([
                    'name'=>$line,
                    'city_id'=>$barranquilla->id,
                    'town_id'=>$ultimaZona->id
                ]);
            }
        }
        fclose($file);
    }
}
