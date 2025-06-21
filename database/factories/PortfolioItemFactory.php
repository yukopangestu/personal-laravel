<?php

namespace Database\Factories;

use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioItem>
 */
class PortfolioItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PortfolioItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(3, true),
            'thumbnail' => $this->faker->imageUrl(600, 400),
            'featured_image' => $this->faker->imageUrl(1200, 800),
            'gallery' => [
                $this->faker->imageUrl(800, 600),
                $this->faker->imageUrl(800, 600),
                $this->faker->imageUrl(800, 600),
            ],
            'category' => $this->faker->randomElement(['Web Development', 'Mobile App', 'UI/UX Design', 'E-commerce']),
            'client' => $this->faker->company,
            'completion_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'project_url' => $this->faker->url,
            'technologies' => $this->faker->randomElements(['Laravel', 'Vue.js', 'React', 'Node.js', 'PHP', 'JavaScript', 'MySQL', 'MongoDB', 'AWS', 'Docker'], $this->faker->numberBetween(2, 5)),
            'is_featured' => $this->faker->boolean(30), // 30% chance of being featured
            'order' => $this->faker->numberBetween(1, 10),
            'meta_data' => [
                'seo_title' => $this->faker->sentence,
                'seo_description' => $this->faker->paragraph,
                'seo_keywords' => implode(', ', $this->faker->words(5)),
            ],
        ];
    }

    /**
     * Indicate that the portfolio item is featured.
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
