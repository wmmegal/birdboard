<?php

namespace Tests\Unit;

use App\Models\Project as ProjectAlias;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    function it_has_a_path() {
        $project = ProjectAlias::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

}
