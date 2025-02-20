<?php

namespace Database\Seeders;

use App\Models\Role as Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function() {

            Model::create([
                'code'=> 'ADMIN', 
                'name' => 'Administrator'
            ]);

            Model::create([
                'code'=> 'SUPPORT', 
                'name' => 'Support'
            ]);
        });
    }
}
