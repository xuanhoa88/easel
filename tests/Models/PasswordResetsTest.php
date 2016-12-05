<?php

use EGALL\EloquentPHPUnit\EloquentTestCase;

class PasswordResetsTest extends EloquentTestCase
{
    /**
     * The user model's full namespace.
     *
     * @var string
     */
    protected $model = 'Canvas\Models\PasswordResets';

    /**
     * Disable database seeding.
     *
     * @var bool
     */
    protected $seedDatabase = false;

    /** @test */
    public function the_database_table_has_all_of_the_correct_columns()
    {
        $this->table->column('email')->string()->index();
        $this->table->column('token')->string()->index();
        $this->table->column('created_at')->dateTime()->nullable();
    }

    /** @test */
    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable(['email', 'token', 'created_at']);
    }
}
