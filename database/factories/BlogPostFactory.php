<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(5, true),
            'featured_image' => $this->faker->imageUrl(1200, 800),
            'user_id' => User::factory(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            'tags' => $this->faker->randomElements(['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'Web Development', 'Design', 'DevOps', 'Testing'], $this->faker->numberBetween(2, 5)),
            'category' => $this->faker->randomElement(['Tutorial', 'Case Study', 'Opinion', 'News', 'Technology']),
            'meta_data' => [
                'seo_title' => $this->faker->sentence,
                'seo_description' => $this->faker->paragraph,
                'seo_keywords' => implode(', ', $this->faker->words(5)),
            ],
        ];
    }

    /**
     * Indicate that the blog post is published.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now()->subDays($this->faker->numberBetween(1, 100)),
            ];
        });
    }

    /**
     * Indicate that the blog post is unpublished.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unpublished()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }

    /**
     * Indicate that the blog post is featured.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function featured()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_featured' => true,
            ];
        });
    }
}
