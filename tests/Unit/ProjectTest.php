<?php

namespace Tests\Unit;

use App\Models\Project as ProjectAlias;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = ProjectAlias::factory()->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = ProjectAlias::factory()->create();

        $this->assertInstanceOf('App\Models\User', $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = ProjectAlias::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = ProjectAlias::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }

}