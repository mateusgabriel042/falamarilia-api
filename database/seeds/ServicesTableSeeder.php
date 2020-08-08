<?php

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Service::class, 5)->create()->each(function ($service) {
            $service->category()->save(factory(Category::class)->make());
        });
    }
}
