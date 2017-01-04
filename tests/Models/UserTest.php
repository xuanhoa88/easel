<?php

use EGALL\EloquentPHPUnit\EloquentTestCase;

class UserTest extends EloquentTestCase
{
    use CreatesUser;

    /**
     * The user model's full namespace.
     *
     * @var string
     */
    protected $model = 'Canvas\Models\User';

    /**
     * Disable database seeding.
     *
     * @var bool
     */
    protected $seedDatabase = false;

    public function the_database_table_has_all_of_the_correct_columns()
    {
        $this->table->column('id')->integer()->increments()->index();
        $this->table->column('first_name')->string()->nullable();
        $this->table->column('last_name')->string()->nullable();
        $this->table->column('display_name')->string()->notNullable();
        $this->table->column('url')->string()->nullable();
        $this->table->column('twitter')->string()->nullable();
        $this->table->column('facebook')->string()->nullable();
        $this->table->column('github')->string()->nullable();
        $this->table->column('linkedin')->string()->nullable();
        $this->table->column('resume_cv')->string()->nullable();
        $this->table->column('address')->string()->nullable();
        $this->table->column('city')->string()->nullable();
        $this->table->column('country')->string()->nullable();
        $this->table->column('bio')->text()->nullable();
        $this->table->column('job')->string()->nullable();
        $this->table->column('phone')->string()->nullable();
        $this->table->column('gender')->string()->nullable();
        $this->table->column('relationship')->string()->nullable();
        $this->table->column('birthday')->string()->nullable();
        $this->table->column('email')->string()->unique();
        $this->table->column('password')->string()->notNullable();
        $this->table->column('remember_token')->string()->nullable();
        $this->table->hasTimestamps();
    }

    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable('first_name', 'last_name', 'display_name', 'url', 'twitter', 'facebook', 'github', 'linkedin', 'resume_cv', 'address', 'city', 'country', 'bio', 'job', 'phone', 'gender', 'relationship', 'birthday', 'email', 'password', 'role');
    }
}
