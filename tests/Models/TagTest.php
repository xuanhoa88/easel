<?php

use Canvas\Models\Post;
use EGALL\EloquentPHPUnit\EloquentTestCase;

class TagTest extends EloquentTestCase
{
    use CreatesUser;

    /**
     * The tag model's full namespace.
     *
     * @var string
     */
    protected $model = 'Canvas\Models\Tag';

    public function the_database_table_has_all_of_the_correct_columns()
    {
        $this->table->column('id')->integer()->increments();
        $this->table->column('tag')->string()->unique();
        $this->table->column('title')->string()->notNullable();
        $this->table->column('subtitle')->string()->notNullable();
        $this->table->column('meta_description')->string();
        $this->table->column('layout')->string()->defaults(config('blog.tag_layout'));
        $this->table->column('reverse_direction')->boolean();
        $this->table->hasTimestamps();
    }

    public function it_has_the_correct_model_properties()
    {
        $this->belongsToMany(Post::class)
            ->hasCasts(['reverse_direction' => 'boolean'])
            ->hasFillable('tag', 'title', 'subtitle', 'meta_description', 'reverse_direction', 'created_at', 'updated_at');
    }
}
