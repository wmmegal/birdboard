<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase {
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_projects() {
        $attributes = Project::factory()->raw();

        $this->post( '/projects', $attributes )->assertRedirect( 'login' );
    }

    /** @test */
    public function a_user_can_create_a_project() {
        $this->withoutExceptionHandling();

        $this->actingAs( User::factory()->create());

        $attributes = [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post( '/projects', $attributes )->assertRedirect( '/projects' );

        $this->assertDatabaseHas( 'projects', $attributes );

        $this->get( '/projects' )->assertSee( $attributes['title'] );
    }

    /** @test */
    public function a_user_can_see_project() {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get( $project->path() )
             ->assertSee( $project->title )
             ->assertSee( $project->description );
    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->actingAs( User::factory()->create());

        $attributes = Project::factory()->raw( [ 'title' => '' ] );

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'title' );
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->actingAs( User::factory()->create());

        $attributes = Project::factory()->raw( [ 'description' => '' ] );

        $this->post( '/projects', $attributes )->assertSessionHasErrors( 'description' );
    }


}
