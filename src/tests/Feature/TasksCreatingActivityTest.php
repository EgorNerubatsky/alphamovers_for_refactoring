<?php

namespace Feature;


use App\Models\Kanban;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TasksCreatingActivityTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();


        $this->test_user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->second_test_user = User::factory()->create([
            'is_manager' => true,
        ]);


        $this->invalidData = [
            'user_id' => $this->test_user->id,
            'task_to_user_id' => $this->second_test_user->id,
            'task' => '@#$%^&',
            'start_task' => '2024--11-26',
            'end_task' => '2024--12-26',
            'status' => '@#$%^&',
        ];

        $this->creatingData = [
            'user_id' => $this->test_user->id,
            'task_to_user_id' => $this->second_test_user->id,
            'task' => 'Тестове завдання № 1',
            'start_task' => '2024-11-26',
            'end_task' => '2024-12-26',
            'status' => 'Нове',
        ];
        $this->creatingKanbanData = [
            'user_id' => $this->test_user->id,
            'kanban_title' => 'Новий канбан',
            'title_color' => 'primary',
        ];
        $this->creatingKanbanTaskData = [
            'task' => 'Новий таск',
            'task_color' => 'secondary',
        ];
        $this->creatingKanbanTaskInvalidData = [
            'task' => 'Новий @#$%^&',
            'task_color' => '@#$%^&',
        ];

        $this->creatingKanbanInvalidData = [
            'user_id' => $this->test_user->id,
            'kanban_title' => 'Новий @#$%^&',
            'title_color' => '@#$%^&',
        ];
    }

    public function test_create_task_with_valid_data(): void
    {

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.store', $this->creatingData));
        $response->assertStatus(302);


        $this->assertDatabaseHas('user_tasks', [
            'user_id' => $this->creatingData['user_id'],
            'task_to_user_id' => $this->creatingData['task_to_user_id'],
            'task' => $this->creatingData['task'],
            'start_task' => $this->creatingData['start_task'] . ' 03:00:00',
            'end_task' => $this->creatingData['end_task'] . ' 03:00:00',
            'status' => $this->creatingData['status'],
        ]);
    }

    public function test_create_kanban_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanban', $this->creatingKanbanData));
        $response->assertStatus(302);

        $this->assertDatabaseHas('kanbans', [
            'user_id' => $this->creatingKanbanData['user_id'],
            'kanban_title' => $this->creatingKanbanData['kanban_title'],
            'title_color' => $this->creatingKanbanData['title_color'],
        ]);
    }

    public function test_create_kanban_task_with_valid_data(): void
    {
        $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanban', $this->creatingKanbanData))->assertStatus(302);
        $kanbanId = Kanban::where('kanban_title', $this->creatingKanbanData['kanban_title'])->first();
        $this->creatingKanbanTaskData['kanban_id'] = $kanbanId->id;

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanbanTask', $this->creatingKanbanTaskData));
        $response->assertStatus(302);


        $this->assertDatabaseHas('kanban_tasks', $this->creatingKanbanTaskData);
    }


    public function test_try_to_create_task_with_invalid_data(): void
    {

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.store', $this->invalidData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'task' => 'The task field format is invalid.',
            'start_task' => 'The start task field must be a valid date.',
            'end_task' => 'The end task field must be a valid date.',
            'status' => 'The status field format is invalid.',

        ]);

        $this->assertDatabaseMissing('user_tasks', [
            'user_id' => $this->invalidData['user_id'],
            'task_to_user_id' => $this->invalidData['task_to_user_id'],
            'task' => $this->invalidData['task'],
        ]);
    }

    public function test_try_to_create_task_without_required_data(): void
    {

        unset($this->creatingData['task']);
        unset($this->creatingData['start_task']);
        unset($this->creatingData['end_task']);


        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.store', $this->creatingData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'task' => 'The task field is required.',
            'start_task' => 'The start task field is required.',
            'end_task' => 'The end task field is required.',
        ]);

        $this->assertDatabaseMissing('user_tasks', $this->creatingData);
    }


    public function test_try_to_create_task_with_long_text(): void
    {
        $this->creatingData['task'] = str_repeat('Aa', 150);

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.store', $this->creatingData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'task' => 'The task field must not be greater than 120 characters.',

        ]);
        $this->assertDatabaseMissing('user_tasks', $this->creatingData);
    }

    public function test_try_to_create_kanban_with_invalid_data(): void
    {

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanban', $this->creatingKanbanInvalidData))->assertStatus(302);
        $response->assertSessionHasErrors([
            'kanban_title' => 'The kanban title field format is invalid.',
            'title_color' => 'The title color field format is invalid.',
                    ]);

        $this->assertDatabaseMissing('kanbans', [
            'user_id' => $this->creatingKanbanInvalidData['user_id'],
            'kanban_title' => $this->creatingKanbanInvalidData['kanban_title'],
            'title_color' => $this->creatingKanbanInvalidData['title_color'],
        ]);
    }

    public function test_try_to_create_kanban_task_with_valid_data(): void
    {
        $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanban', $this->creatingKanbanData))->assertStatus(302);
        $kanbanId = Kanban::where('kanban_title', $this->creatingKanbanData['kanban_title'])->first();
        $this->creatingKanbanTaskInvalidData['kanban_id'] = $kanbanId->id;

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.storeKanbanTask', $this->creatingKanbanTaskInvalidData));
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'task' => 'The task field format is invalid.',
            'task_color' => 'The task color field format is invalid.',
        ]);
    }


}
