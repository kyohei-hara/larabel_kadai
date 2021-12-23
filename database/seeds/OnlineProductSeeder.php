<?php

use Illuminate\Database\Seeder;
use App\Models\OnlineProduct;

class OnlineProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineProduct::class, 15)->states('snack')->create();
        factory(OnlineProduct::class, 15)->states('chocolate')->create();
        factory(OnlineProduct::class, 15)->states('candy')->create();
    }
}