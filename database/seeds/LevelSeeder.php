<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Level::insert([
            [
                'slug'=>'A',
                'name'=>'ACTIVO'
            ],
            [
                'slug'=>'GS',
                'name'=>'GRUPO SIGNIFICATIVO'
            ],
            [
                'slug'=>'EDIL',
                'name'=>'GRUPO DE EDILES'
            ],
            [
                'slug'=>'UA',
                'name'=>'UBICADO DE APOYO'
            ],
            [
                'slug'=>'UB',
                'name'=>'UBICADO BARRANQUILLA'
            ],
            [
                'slug'=>'UM',
                'name'=>'UBICADO MUNICIPIOS'
            ],
            [
                'slug'=>'UN',
                'name'=>'UBICADO  NACIONAL'
            ],
            [
                'slug'=>'UESP',
                'name'=>'UBICADOS ESPECIALES'
            ],
            [
                'slug'=>'MIX',
                'name'=>'LIDER QUE VOTA EN BQUILLA Y MPIOS ATLANTICO'
            ],
            [
                'slug'=>'E',
                'name'=>'ELIMINADO'
            ],
            [
                'slug'=>'OD',
                'name'=>'LIDER DE OTRO DEPARTAMENTO'
            ],
            [
                'slug'=>'LLA',
                'name'=>'LIDER INACTIVO Y POR LLAMAR'
            ],
            [
                'slug'=>'PEN',
                'name'=>'LIDER INACTIVO PENDIENTE'
            ],
            [
                'slug'=>'IND',
                'name'=>'LIDER INDECISO'
            ],

        ]);
    }
}
