<?php

class TagCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_tag_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tag/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tag');
    }
}
