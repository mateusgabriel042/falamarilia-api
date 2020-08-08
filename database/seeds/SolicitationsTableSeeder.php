<?php

use App\Models\Category;
use App\Models\Service;
use App\Models\Solicitation;
use Illuminate\Database\Seeder;

class SolicitationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Solicitation::class, 1)->create();
    }
}
