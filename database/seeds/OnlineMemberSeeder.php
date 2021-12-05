<?php

use Illuminate\Database\Seeder;
use App\Models\OnlineMember;

class OnlineMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineMember::class,1)->create();
    }
}
