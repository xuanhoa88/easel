<?php

class PostCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_post_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/post/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/post');
    }
}
