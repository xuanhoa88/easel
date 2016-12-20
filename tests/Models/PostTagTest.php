<?php

use EGALL\EloquentPHPUnit\EloquentTestCase;

class PostTagTest extends EloquentTestCase
{
    /**
     * The user model's full namespace.
     *
     * @var string
     */
    protected $model = 'Canvas\Models\PostTag';

    /**
     * Disable database seeding.
     *
     * @var bool
     */
    protected $seedDatabase = false;

    public function the_database_table_has_all_of_the_correct_columns()
    {
        $this->table->column('post_id')->integer()->primary();
        $this->table->column('tag_id')->integer()->primary();
        $this->table->hasTimestamps();
    }

    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable(['post_id', 'tag_id', 'created_at', 'updated_at']);
    }
}
