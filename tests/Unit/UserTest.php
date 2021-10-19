<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects() {
        $user = User::factory()->create();

        $this->assertInstanceOf( Collection::class, $user->projects );
    }

    /** @test */
    public function a_user_has_accessible_projects() {
        $jonn = $this->signIn();

        ProjectFactory::ownedBy($jonn)->create();

        $this->assertCount(1, $jonn->accessibleProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);

        $this->assertCount(1, $jonn->accessibleProjects());

        $project->invite($jonn);

        $this->assertCount(2, $jonn->accessibleProjects());
    }

}
