<?php

namespace Tests\Feature;

use App\Models\ClassModel;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingStoreValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_online_meeting_requires_meeting_link(): void
    {
        $class = ClassModel::create([
            'name' => 'Kelas A',
        ]);

        $mentor = User::factory()->create([
            'role' => 'mentor',
            'class_id' => $class->id,
        ]);

        $response = $this->actingAs($mentor)->post(route('meetings.store'), [
            'title' => 'Meeting Online',
            'meeting_date' => '2026-06-01',
            'meeting_time' => '10:00',
            'meeting_type' => 'online',
            'meeting_link' => '',
        ]);

        $response->assertSessionHasErrors('meeting_link');
        $this->assertDatabaseCount('meetings', 0);
    }

    public function test_offline_meeting_can_be_created_without_meeting_link(): void
    {
        $class = ClassModel::create([
            'name' => 'Kelas B',
        ]);

        $mentor = User::factory()->create([
            'role' => 'mentor',
            'class_id' => $class->id,
        ]);

        $response = $this->actingAs($mentor)->post(route('meetings.store'), [
            'title' => 'Meeting Offline',
            'meeting_date' => '2026-06-02',
            'meeting_time' => '11:00',
            'meeting_type' => 'offline',
            'meeting_link' => '',
        ]);

        $response->assertRedirect(route('meetings.index'));
        $this->assertDatabaseHas('meetings', [
            'title' => 'Meeting Offline',
            'meeting_link' => null,
        ]);
        $this->assertEquals(1, Meeting::count());
    }
}
