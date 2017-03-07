<?php

namespace Canvas;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('Canvas\PostTableSeeder');
        $this->call('Canvas\TagTableSeeder');
        $this->call('Canvas\PostTagTableSeeder');
    }
}
