<?php

namespace Tests\Unit;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_contact_message()
    {
        $contactMessage = ContactMessage::factory()->create();

        $this->assertInstanceOf(ContactMessage::class, $contactMessage);
        $this->assertDatabaseHas('contact_messages', ['id' => $contactMessage->id]);
    }

    /** @test */
    public function it_can_update_a_contact_message()
    {
        $contactMessage = ContactMessage::factory()->create();

        $newData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Updated Subject',
            'message' => 'This is an updated message',
        ];

        $contactMessage->update($newData);
        $contactMessage->refresh();

        $this->assertEquals('John Doe', $contactMessage->name);
        $this->assertEquals('john@example.com', $contactMessage->email);
        $this->assertEquals('Updated Subject', $contactMessage->subject);
        $this->assertEquals('This is an updated message', $contactMessage->message);
    }

    /** @test */
    public function it_can_scope_to_unread_messages()
    {
        // Create read messages
        ContactMessage::factory()->read()->create();
        ContactMessage::factory()->read()->create();

        // Create unread messages
        $unreadMessage1 = ContactMessage::factory()->unread()->create();
        $unreadMessage2 = ContactMessage::factory()->unread()->create();

        $unreadMessages = ContactMessage::unread()->get();

        $this->assertCount(2, $unreadMessages);
        $this->assertTrue($unreadMessages->contains($unreadMessage1));
        $this->assertTrue($unreadMessages->contains($unreadMessage2));
    }

    /** @test */
    public function it_can_mark_a_message_as_read()
    {
        $contactMessage = ContactMessage::factory()->unread()->create();

        $this->assertFalse($contactMessage->is_read);
        $this->assertNull($contactMessage->read_at);

        $contactMessage->markAsRead();

        $this->assertTrue($contactMessage->is_read);
        $this->assertNotNull($contactMessage->read_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $contactMessage->read_at);
    }

    /** @test */
    public function it_casts_is_read_as_boolean()
    {
        $contactMessage = ContactMessage::factory()->create([
            'is_read' => true
        ]);

        $this->assertIsBool($contactMessage->is_read);
        $this->assertTrue($contactMessage->is_read);
    }

    /** @test */
    public function it_casts_read_at_as_datetime()
    {
        $date = now();

        $contactMessage = ContactMessage::factory()->create([
            'is_read' => true,
            'read_at' => $date
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $contactMessage->read_at);
        $this->assertEquals($date->format('Y-m-d H:i:s'), $contactMessage->read_at->format('Y-m-d H:i:s'));
    }
}
