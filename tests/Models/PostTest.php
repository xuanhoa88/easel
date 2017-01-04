<?php

use Canvas\Models\Tag;
use Canvas\Models\User;
use EGALL\EloquentPHPUnit\EloquentTestCase;

class PostTest extends EloquentTestCase
{
    use CreatesUser;

    /**
     * The post model's full namespace.
     *
     * @var string
     */
    protected $model = 'Canvas\Models\Post';

    public function the_database_table_has_all_of_the_correct_columns()
    {
        $this->table->column('id')->integer()->increments();
        $this->table->column('user_id')->integer()->defaults(1)->index();
        $this->table->column('title')->string()->notNullable();
        $this->table->column('subtitle')->string()->notNullable();
        $this->table->column('content_raw')->text()->notNullable();
        $this->table->column('page_image')->string()->nullable();
        $this->table->column('meta_description')->string()->nullable();
        $this->table->column('is_draft')->boolean()->defaults(0);
        $this->table->column('layout')->string()->defaults(config('blog.post_layout'));
        $this->table->column('published_at')->dateTime()->index();
        $this->table->hasTimestamps();
    }

    public function the_post_tag_table_relationship()
    {
        $this->resetTable('post_tag');
        $this->table->column('tag_id')->integer()->primary();
        $this->table->column('post_id')->integer()->primary();
        $this->table->hasTimestamps();
    }

    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable('title', 'subtitle', 'content_raw', 'page_image', 'meta_description', 'layout', 'is_draft', 'published_at', 'slug', 'user_id')
            ->hasDates('published_at')
            ->belongsToMany(Tag::class)
            ->belongsTo(User::class);
    }
}
