<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Core\Models\Task;
use App\Core\Models\Project;
use Illuminate\Support\Facades\Event;

class HomePageTest extends TestCase
{
    /** @test */
    public function user_can_see_current_work_in_progress_assigned_to_them()
    {
        Event::fake();
        $project = factory(Project::class)->create(['office_id' => null, 'team_id' => null]);
        $project->members()->attach($this->user->id);
        $task = factory(Task::class)->create(['taskable_type' => 'project', 'taskable_id' => $project->id, 'assigned_to' => $this->user->id, 'status_id' => 2]);
        $this->actingAs($this->user)
             ->get('/')
             ->assertSee($task->name);
    }
}
