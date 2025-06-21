<?php

namespace Tests\Unit;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_profile()
    {
        $profile = Profile::factory()->create();

        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertDatabaseHas('profile', ['id' => $profile->id]);
    }

    /** @test */
    public function it_can_update_a_profile()
    {
        $profile = Profile::factory()->create();

        $newData = [
            'name' => 'John Doe',
            'title' => 'Senior Developer',
            'bio' => 'Updated bio information',
        ];

        $profile->update($newData);
        $profile->refresh();

        $this->assertEquals('John Doe', $profile->name);
        $this->assertEquals('Senior Developer', $profile->title);
        $this->assertEquals('Updated bio information', $profile->bio);
    }

    /** @test */
    public function it_casts_skills_as_array()
    {
        $skills = ['Laravel', 'Vue.js', 'PHP'];

        $profile = Profile::factory()->create([
            'skills' => $skills
        ]);

        $this->assertIsArray($profile->skills);
        $this->assertEquals($skills, $profile->skills);
    }

    /** @test */
    public function it_casts_meta_data_as_array()
    {
        $metaData = [
            'seo_title' => 'My Profile',
            'seo_description' => 'This is my profile page',
            'seo_keywords' => 'profile, developer, laravel',
        ];

        $profile = Profile::factory()->create([
            'meta_data' => $metaData
        ]);

        $this->assertIsArray($profile->meta_data);
        $this->assertEquals($metaData, $profile->meta_data);
    }
}
