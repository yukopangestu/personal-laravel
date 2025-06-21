<?php

namespace Tests\Unit;

use App\Models\PortfolioItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_portfolio_item()
    {
        $portfolioItem = PortfolioItem::factory()->create();

        $this->assertInstanceOf(PortfolioItem::class, $portfolioItem);
        $this->assertDatabaseHas('portfolio_items', ['id' => $portfolioItem->id]);
    }

    /** @test */
    public function it_can_update_a_portfolio_item()
    {
        $portfolioItem = PortfolioItem::factory()->create();

        $newData = [
            'title' => 'Updated Project',
            'description' => 'This is an updated project description',
            'client' => 'New Client',
        ];

        $portfolioItem->update($newData);
        $portfolioItem->refresh();

        $this->assertEquals('Updated Project', $portfolioItem->title);
        $this->assertEquals('This is an updated project description', $portfolioItem->description);
        $this->assertEquals('New Client', $portfolioItem->client);
    }

    /** @test */
    public function it_can_be_marked_as_featured()
    {
        $portfolioItem = PortfolioItem::factory()->create(['is_featured' => false]);

        $portfolioItem->update(['is_featured' => true]);
        $portfolioItem->refresh();

        $this->assertTrue($portfolioItem->is_featured);
    }

    /** @test */
    public function it_casts_gallery_as_array()
    {
        $gallery = [
            'image1.jpg',
            'image2.jpg',
            'image3.jpg',
        ];

        $portfolioItem = PortfolioItem::factory()->create([
            'gallery' => $gallery
        ]);

        $this->assertIsArray($portfolioItem->gallery);
        $this->assertEquals($gallery, $portfolioItem->gallery);
    }

    /** @test */
    public function it_casts_technologies_as_array()
    {
        $technologies = ['Laravel', 'Vue.js', 'MySQL'];

        $portfolioItem = PortfolioItem::factory()->create([
            'technologies' => $technologies
        ]);

        $this->assertIsArray($portfolioItem->technologies);
        $this->assertEquals($technologies, $portfolioItem->technologies);
    }

    /** @test */
    public function it_casts_meta_data_as_array()
    {
        $metaData = [
            'seo_title' => 'Project Title',
            'seo_description' => 'Project description for SEO',
            'seo_keywords' => 'project, portfolio, laravel',
        ];

        $portfolioItem = PortfolioItem::factory()->create([
            'meta_data' => $metaData
        ]);

        $this->assertIsArray($portfolioItem->meta_data);
        $this->assertEquals($metaData, $portfolioItem->meta_data);
    }

    /** @test */
    public function it_casts_completion_date_as_date()
    {
        $date = now()->subMonths(2);

        $portfolioItem = PortfolioItem::factory()->create([
            'completion_date' => $date
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $portfolioItem->completion_date);
        $this->assertEquals($date->format('Y-m-d'), $portfolioItem->completion_date->format('Y-m-d'));
    }
}
