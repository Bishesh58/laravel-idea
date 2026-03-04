<?php

use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected to login when accessing ideas routes', function (): void {
    $this->get(route('ideas.index'))->assertRedirect(route('login'));
    $this->get(route('ideas.create'))->assertRedirect(route('login'));
});

test('authenticated user can create and view an idea', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('ideas.store'), [
        'title' => 'Add export dashboard',
        'description' => 'Allow exporting key reports in CSV format.',
        'status' => IdeaStatus::InProgress->value,
        'links' => ['https://example.com/spec', '', 'https://example.com/mockup'],
    ]);

    $idea = Idea::query()->firstOrFail();

    $response->assertRedirect(route('ideas.show', $idea));
    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'user_id' => $user->id,
        'title' => 'Add export dashboard',
        'status' => IdeaStatus::InProgress->value,
    ]);

    $this->actingAs($user)
        ->get(route('ideas.show', $idea))
        ->assertSuccessful()
        ->assertSee('Add export dashboard')
        ->assertSee('In Progress');
});

test('index filtering shows only users ideas in selected status', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Idea::factory()->for($user)->create([
        'title' => 'User pending',
        'status' => IdeaStatus::Pending->value,
    ]);

    Idea::factory()->for($user)->create([
        'title' => 'User completed',
        'status' => IdeaStatus::Completed->value,
    ]);

    Idea::factory()->for($otherUser)->create([
        'title' => 'Other completed',
        'status' => IdeaStatus::Completed->value,
    ]);

    $this->actingAs($user)
        ->get(route('ideas.index', ['status' => IdeaStatus::Completed->value]))
        ->assertSuccessful()
        ->assertSee('User completed')
        ->assertDontSee('User pending')
        ->assertDontSee('Other completed');
});

test('user can update and delete own idea', function (): void {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create([
        'title' => 'Original title',
        'status' => IdeaStatus::Pending->value,
    ]);

    $this->actingAs($user)
        ->put(route('ideas.update', $idea), [
            'title' => 'Updated title',
            'description' => 'Updated details',
            'status' => IdeaStatus::Completed->value,
            'links' => ['https://example.com/final'],
        ])
        ->assertRedirect(route('ideas.show', $idea));

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'title' => 'Updated title',
        'status' => IdeaStatus::Completed->value,
    ]);

    $this->actingAs($user)
        ->delete(route('ideas.destroy', $idea))
        ->assertRedirect(route('ideas.index'));

    $this->assertDatabaseMissing('ideas', [
        'id' => $idea->id,
    ]);
});

test('user cannot view or modify other users idea', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $idea = Idea::factory()->for($otherUser)->create();

    $this->actingAs($user)->get(route('ideas.show', $idea))->assertForbidden();

    $this->actingAs($user)->put(route('ideas.update', $idea), [
        'title' => 'Hacked',
        'description' => 'Nope',
        'status' => IdeaStatus::Pending->value,
        'links' => [],
    ])->assertForbidden();

    $this->actingAs($user)->delete(route('ideas.destroy', $idea))->assertForbidden();
});
