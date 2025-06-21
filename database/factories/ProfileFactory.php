<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'title' => $this->faker->jobTitle,
            'bio' => $this->faker->paragraph,
            'avatar' => $this->faker->imageUrl(400, 400, 'people'),
            'resume' => $this->faker->url,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'location' => $this->faker->city . ', ' . $this->faker->country,
            'github_url' => 'https://github.com/' . $this->faker->userName,
            'linkedin_url' => 'https://linkedin.com/in/' . $this->faker->userName,
            'twitter_url' => 'https://twitter.com/' . $this->faker->userName,
            'instagram_url' => 'https://instagram.com/' . $this->faker->userName,
            'facebook_url' => 'https://facebook.com/' . $this->faker->userName,
            'website_url' => $this->faker->url,
            'skills' => $this->faker->randomElements(['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'MySQL', 'Docker', 'AWS', 'Git'], $this->faker->numberBetween(3, 8)),
            'meta_data' => [
                'seo_title' => $this->faker->sentence,
                'seo_description' => $this->faker->paragraph,
                'seo_keywords' => implode(', ', $this->faker->words(5)),
            ],
        ];
    }
}
