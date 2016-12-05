<?php

class UserCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_user_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/user/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/user');
    }
}
