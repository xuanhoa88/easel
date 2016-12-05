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

    /** @test */
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

    /** @test */
    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable('first_name', 'last_name', 'display_name', 'url', 'twitter', 'facebook', 'github', 'linkedin', 'resume_cv', 'address', 'city', 'country', 'bio', 'job', 'phone', 'gender', 'relationship', 'birthday', 'email', 'password', 'role');
    }

    /** @test */
    public function it_validates_the_user_create_form()
    {
        $this->actingAs($this->user)->post('admin/user/create', ['first_name' => 'foo']);
        $this->actingAs($this->user)
            ->visit('/admin/user/create')
            ->type('will', 'first_name')
            ->type('notValidate', 'last_name')
            ->press('Save');
        $this->seePageIs('admin/user/create');
        $this->dontSeeInDatabase('users', ['first_name' => 'will', 'last_name' => 'notValidate']);
    }

    /** @test */
    public function it_can_create_a_user_and_save_it_to_the_database()
    {
        $this->actingAs($this->user)
            ->visit('/admin/user/create')
            ->type('first', 'first_name')
            ->type('last', 'last_name')
            ->type('display', 'display_name')
            ->type('email@example.com', 'email')
            ->type('password', 'password')
            ->select(1, 'role')
            ->press('Save');

        $this->seeInDatabase('users', [
            'id'            => 2,
            'first_name'    => 'first',
            'last_name'     => 'last',
            'display_name'  => 'display',
            'role'          => 1,
            'email'         => 'email@example.com',
        ]);

        $this->seePageIs('admin/user');
        $this->see('Success! New user has been created.');
        $this->assertSessionMissing('errors');
    }

    /** @test */
    public function it_can_edit_a_users_details()
    {
        $this->it_can_create_a_user_and_save_it_to_the_database();

        $this->actingAs($this->user)
            ->visit('/admin/user/2/edit')
            ->type('New Name', 'first_name')
            ->press('Save')
            ->seePageIs('/admin/user/2/edit')
            ->see('Success! User has been updated.')
            ->seeInDatabase('users', ['first_name' => 'New Name']);
    }

    /** @test */
    public function it_can_delete_a_user_from_the_database()
    {
        $this->it_can_create_a_user_and_save_it_to_the_database();

        $this->actingAs($this->user)
            ->visit('/admin/user/2/edit')
            ->press('Delete')
            ->dontSee('Success! User has been deleted.')
            ->press('Delete User')
            ->see('Success! User has been deleted.')
            ->dontSeeInDatabase('users', ['first_name' => 'first']);
    }

    /** @test */
    public function it_validates_the_user_password_update_form()
    {
        $this->it_can_create_a_user_and_save_it_to_the_database();

        $this->actingAs($this->user)
            ->visit('/admin/user/2/privacy')
            ->type('secretpassword', 'new_password')
            ->press('Save')
            ->seePageIs('admin/user/2/privacy');
    }

    /** @test */
    public function it_can_update_a_users_password()
    {
        $this->it_can_create_a_user_and_save_it_to_the_database();

        $this->actingAs($this->user)
            ->visit('/admin/user/2/privacy')
            ->type('secretpassword', 'new_password')
            ->type('secretpassword', 'new_password_confirmation')
            ->press('Save')
            ->seePageIs('admin/user/2/edit')
            ->see('Success! Password has been updated.');
    }
}
