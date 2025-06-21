<?php

namespace Tests\Unit;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_blog_post()
    {
        $blogPost = BlogPost::factory()->create();

        $this->assertInstanceOf(BlogPost::class, $blogPost);
        $this->assertDatabaseHas('blog_posts', ['id' => $blogPost->id]);
    }

    /** @test */
    public function it_can_update_a_blog_post()
    {
        $blogPost = BlogPost::factory()->create();

        $newData = [
            'title' => 'Updated Blog Post',
            'excerpt' => 'This is an updated excerpt',
            'content' => 'This is updated content for the blog post',
        ];

        $blogPost->update($newData);
        $blogPost->refresh();

        $this->assertEquals('Updated Blog Post', $blogPost->title);
        $this->assertEquals('This is an updated excerpt', $blogPost->excerpt);
        $this->assertEquals('This is updated content for the blog post', $blogPost->content);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $blogPost = BlogPost::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $blogPost->user);
        $this->assertEquals($user->id, $blogPost->user->id);
    }

    /** @test */
    public function it_can_scope_to_published_posts()
    {
        // Create unpublished post
        BlogPost::factory()->unpublished()->create();

        // Create published posts
        $publishedPost1 = BlogPost::factory()->published()->create();
        $publishedPost2 = BlogPost::factory()->published()->create();

        $publishedPosts = BlogPost::published()->get();

        $this->assertCount(2, $publishedPosts);
        $this->assertTrue($publishedPosts->contains($publishedPost1));
        $this->assertTrue($publishedPosts->contains($publishedPost2));
    }

    /** @test */
    public function it_can_scope_to_featured_posts()
    {
        // Create non-featured posts
        BlogPost::factory()->create(['is_featured' => false]);
        BlogPost::factory()->create(['is_featured' => false]);

        // Create featured post
        $featuredPost = BlogPost::factory()->featured()->create();

        $featuredPosts = BlogPost::featured()->get();

        $this->assertCount(1, $featuredPosts);
        $this->assertTrue($featuredPosts->contains($featuredPost));
    }

    /** @test */
    public function it_casts_tags_as_array()
    {
        $tags = ['Laravel', 'Testing', 'PHP'];

        $blogPost = BlogPost::factory()->create([
            'tags' => $tags
        ]);

        $this->assertIsArray($blogPost->tags);
        $this->assertEquals($tags, $blogPost->tags);
    }

    /** @test */
    public function it_casts_meta_data_as_array()
    {
        $metaData = [
            'seo_title' => 'Blog Post Title',
            'seo_description' => 'Blog post description for SEO',
            'seo_keywords' => 'blog, post, laravel',
        ];

        $blogPost = BlogPost::factory()->create([
            'meta_data' => $metaData
        ]);

        $this->assertIsArray($blogPost->meta_data);
        $this->assertEquals($metaData, $blogPost->meta_data);
    }

    /** @test */
    public function it_casts_published_at_as_datetime()
    {
        $date = now()->subDays(5);

        $blogPost = BlogPost::factory()->create([
            'published_at' => $date
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $blogPost->published_at);
        $this->assertEquals($date->format('Y-m-d H:i:s'), $blogPost->published_at->format('Y-m-d H:i:s'));
    }
}
