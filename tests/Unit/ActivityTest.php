<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_user()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
    }
}
