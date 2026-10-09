<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_rendered_by_slug(): void
    {
        $page = new Page();
        $page->title = 'Test Contact Page';
        $page->slug = 'contact';
        $page->body = 'This is a test contact page.';
        $page->save();

        $page2 = new Page();
        $page2->title = 'Test About Page';
        $page2->slug = 'about';
        $page2->body = 'This is a test about page.';
        $page2->save();

        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Test About Page');
        $response->assertSee('This is a test about page.');
        $response->assertDontSee('Test Contact Page');
        $response->assertDontSee('This is a test contact page.');
    }
}
