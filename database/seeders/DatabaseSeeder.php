<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            $this->call([
                UserSeeder::class,
                GenerateRandVessel::class
            ]);

            DB::commit();
        } catch(Exception $err) {
            DB::rollBack();
            dd($err);
        }
    }
}
