<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_persisted(): void
    {
        $page = new Page();

        $page->title = 'Test Page';
        $page->slug = 'test-page';
        $page->body = 'This is a test page';
        $page->save();

        $this->assertDatabaseHas('pages', [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'body' => 'This is a test page',
        ]);
    }

    public function test_page_slug_must_be_unique(): void
    {
        $page1 = new Page();

        $page1->title = 'Test Page 1';
        $page1->slug = 'about';
        $page1->body = 'This is the first test page';
        $page1->save();

        $page2 = new Page();
        $page2->title = 'Test Page 2';
        $page2->slug = 'about';
        $page2->body = 'this is the second test page';

        $this->expectException(UniqueConstraintViolationException::class);
        $page2->save();
    }
}
