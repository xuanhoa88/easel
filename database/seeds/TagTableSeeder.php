<?php

namespace Canvas;

use Canvas\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Seed the tags table with the Welcome tag.
     */
    public function run()
    {
        factory(Tag::class, 1)->create();
    }
}
