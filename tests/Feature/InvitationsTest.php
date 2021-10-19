<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectTasksController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function non_owners_may_not_invite_users()
    {

        $project = ProjectFactory::create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post($project->path() .'/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
            ->post($project->path() .'/invitations')
            ->assertStatus(403);
    }

    /** @test */
    function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();
        $userToInvite = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path().'/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    function the_email_address_must_be_associated_with_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path().'/invitations', [
                'email' => 'notauser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.'
            ], null, 'invitations');
    }

    /** @test */
    function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();
        $task = ['body' => 'Foo task'];

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);
        $this->post(action([ProjectTasksController::class, 'store'], $project), $task);

        $this->assertDatabaseHas('tasks', $task);

    }
}
