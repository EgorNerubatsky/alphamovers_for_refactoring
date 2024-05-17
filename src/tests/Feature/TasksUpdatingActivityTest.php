<?php

namespace Feature;


use App\Models\Kanban;
use App\Models\KanbanTask;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/**
 * @property string $longTestData
 */
class TasksUpdatingActivityTest extends TestCase
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
        $this->test_task = UserTask::create([
            'user_id' => $this->test_user->id,
            'task_to_user_id' => $this->second_test_user->id,
            'task' => 'Тестове завдання № 1',
            'start_task' => '2024-11-26',
            'end_task' => '2024-12-26',
            'status' => 'Нове',
        ]);

        $this->test_kanban = Kanban::create([
            'user_id' => $this->test_user->id,
            'kanban_title' => 'Новий канбан',
            'title_color' => 'primary',
        ]);
        $this->test_kanban_second = Kanban::create([
            'user_id' => $this->test_user->id,
            'kanban_title' => 'Другий канбан',
            'title_color' => 'secondary',
        ]);

        $this->test_kanban_task = KanbanTask::create([
            'kanban_id' => $this->test_kanban->id,
            'task' => 'Новий таск',
            'task_color' => 'secondary',
        ]);

        $this->taskUpdate = [
            'eventId' => $this->test_task->id,
            'eventStart' => '2024-11-29',
            'eventEnd' => '2024-11-29',
            'eventTitle' => 'Редагована задача',
            'status' => 'Виконано',
        ];

        $this->kanbanUpdate = [
            'kanban_id' => $this->test_kanban->id,
            'kanban_title' => 'Нова назва',
            'title_color' => 'danger',
        ];

        $this->kanbanTaskUpdate = [
            'kanban_task_id' => $this->test_kanban_task->id,
            'task' => 'Редагований таск',
            'task_color' => 'danger',
        ];

        $this->invalidData = [
            'user_id' => $this->test_user->id,
            'task_to_user_id' => $this->second_test_user->id,
            'task' => '@#$%^&',
            'start_task' => '2024--11-26',
            'end_task' => '2024--12-26',
            'status' => '@#$%^&',
            'eventStart' => '2024--11-29',
            'eventEnd' => '2024--11-29',
            'eventTitle' => '@#$%^& задача',
            'kanban_title' => '@#$%^& назва',
            'title_color' => '@#$%^&',
            'task_color' => '@#$%^&',
        ];
    }

    public function test_update_task_with_valid_data(): void
    {

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.update', $this->taskUpdate));
        $response->assertStatus(302);

        $this->assertDatabaseHas('user_tasks', [
            'user_id' => $this->test_task->user_id,
            'task_to_user_id' => $this->test_task->task_to_user_id,
            'task' => $this->taskUpdate['eventTitle'],
            'start_task' => $this->taskUpdate['eventStart'],
            'end_task' => $this->taskUpdate['eventEnd'],
            'status' => $this->taskUpdate['status'],
        ]);
    }


    public function test_update_kanban_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->put(route('erp.executive.tasks.updateKanban', $this->kanbanUpdate));
        $response->assertStatus(302);

        $this->assertDatabaseHas('kanbans', [
            'user_id' => $this->test_kanban->user_id,
            'kanban_title' => $this->kanbanUpdate['kanban_title'],
            'title_color' => $this->kanbanUpdate['title_color'],
        ]);
    }

    public function test_update_kanban_task_with_valid_data(): void
    {
        $response = $this->actingAs($this->test_user)->put(route('erp.executive.tasks.updateKanbanTask', $this->kanbanTaskUpdate));
        $response->assertStatus(302);

        $this->assertDatabaseHas('kanban_tasks', [
            'kanban_id' => $this->test_kanban_task->kanban_id,
            'task' => $this->kanbanTaskUpdate['task'],
            'task_color' => $this->kanbanTaskUpdate['task_color'],
        ]);
    }

    public function test_remove_task_to_new_date(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.remove', [
            'id' => $this->test_task->id,
            'start' => $this->taskUpdate['eventStart'],
            'end' => $this->taskUpdate['eventEnd'],

        ]));
        $response->assertStatus(302);

        $this->assertDatabaseHas('user_tasks', [
            'user_id' => $this->test_task->user_id,
            'task_to_user_id' => $this->test_task->task_to_user_id,
            'task' => $this->test_task->task,
            'start_task' => $this->taskUpdate['eventStart'] . ' 02:00:00',
            'end_task' => $this->taskUpdate['eventEnd'] . ' 02:00:00',
            'status' => $this->test_task->status,
        ]);
    }

    public function test_remove_kanban_task_to_new_kanban(): void
    {
        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.updateTaskColumn', [
            'task_id' => $this->test_kanban_task->id,
            'kanban_id' => $this->test_kanban_second->id,
        ]));
        $response->assertOk();

        $this->assertDatabaseHas('kanban_tasks', [
            'kanban_id' => $this->test_kanban_second->id,
            'task' => $this->test_kanban_task->task,
            'task_color' => $this->test_kanban_task->task_color,
        ]);
    }


    public function test_try_to_update_task_with_invalid_data(): void
    {

        $this->taskUpdate['eventStart'] = $this->invalidData['eventStart'];
        $this->taskUpdate['eventEnd'] = $this->invalidData['eventEnd'];
        $this->taskUpdate['eventTitle'] = $this->invalidData['eventTitle'];
        $this->taskUpdate['status'] = $this->invalidData['status'];

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.update', $this->taskUpdate))->assertStatus(302);
        $response->assertSessionHasErrors([
            'eventStart' => 'The event start field must be a valid date.',
            'eventEnd' => 'The event end field must be a valid date.',
            'eventTitle' => 'The event title field format is invalid.',
            'status' => 'The status field format is invalid.',
        ]);

        $this->assertDatabaseMissing('user_tasks', [
            'id' => $this->taskUpdate['eventId'],
            'task' => $this->taskUpdate['eventTitle'],
        ]);
    }

    public function test_try_to_update_task_without_required_data(): void
    {

        unset($this->taskUpdate['eventTitle']);

        $response = $this->actingAs($this->test_user)->post(route('erp.executive.tasks.update', $this->taskUpdate))->assertStatus(302);
        $response->assertSessionHasErrors([
            'eventTitle' => 'The event title field is required.',
        ]);



    }


    public function test_try_to_update_task_with_long_text(): void
    {

        $this->longTextTest(
            'taskUpdate',
            'event title',
            'eventTitle',
            'user_tasks',
            'task',
        '120',
            'update',
            'post',
        );
    }

    private function longTextTest($testData, $fullDescription, $shortDescription, $db, $column,$charactersVal, $routePart, $method): void
    {
        $this->$testData[$shortDescription] = str_repeat('Aa', 150);

        $response = $this->actingAs($this->test_user)->$method(route("erp.executive.tasks.$routePart", $this->$testData))->assertStatus(302);
        $response->assertSessionHasErrors([
            $shortDescription => "The $fullDescription field must not be greater than $charactersVal characters.",

        ]);
        $this->assertDatabaseMissing($db, [$column => $this->$testData[$shortDescription]]);

    }

    public function test_try_to_update_kanban_with_invalid_data(): void
    {

        $this->kanbanUpdate['kanban_title'] = $this->invalidData['kanban_title'];
        $this->kanbanUpdate['title_color'] = $this->invalidData['title_color'];

        $response = $this->actingAs($this->test_user)->put(route('erp.executive.tasks.updateKanban', $this->kanbanUpdate))->assertStatus(302);
        $response->assertSessionHasErrors([
            'kanban_title' => 'The kanban title field format is invalid.',
            'title_color' => 'The title color field format is invalid.',
        ]);

        $this->assertDatabaseMissing('kanbans', [
            'kanban_title' => $this->kanbanUpdate['kanban_title'],
            'title_color' => $this->kanbanUpdate['title_color'],
        ]);
    }

    public function test_try_to_update_kanban_without_required_data(): void
    {

        $this->testWithoutRequiredData(
            'kanbanUpdate',
            'kanban_title',
            'title_color',
            'kanban title',
            'title color',
            'updateKanban',
            'put',
        );

    }

    private function testWithoutRequiredData($testData, $firstVol, $secondVol, $fullFirstVol, $fullSecondVol, $routePart, $method): void
    {

        unset($this->$testData[$firstVol]);
        unset($this->$testData[$secondVol]);
        $response = $this->actingAs($this->test_user)->$method(route("erp.executive.tasks.$routePart", $this->$testData))->assertStatus(302);
        $response->assertSessionHasErrors([
            $firstVol => "The $fullFirstVol field is required.",
            $secondVol => "The $fullSecondVol field is required.",
        ]);
    }
    public function test_try_to_update_kanban_with_long_text_data(): void
    {
        $this->longTextTest(
            'kanbanUpdate',
            'kanban title',
            'kanban_title',
            'kanbans',
            'kanban_title',
            '50',
            'updateKanban',
            'put',
        );
    }


    public function test_try_to_update_kanban_task_with_invalid_data(): void
    {
        $this->kanbanTaskUpdate['task'] = $this->invalidData['task'];
        $this->kanbanTaskUpdate['task_color'] = $this->invalidData['task_color'];

        $response = $this->actingAs($this->test_user)->put(route('erp.executive.tasks.updateKanbanTask', $this->kanbanTaskUpdate))->assertStatus(302);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'task' => 'The task field format is invalid.',
            'task_color' => 'The task color field format is invalid.',
        ]);
    }

    public function test_try_to_update_kanban_task_without_required_data(): void
    {
        unset($this->kanbanTaskUpdate['task']);
        unset($this->kanbanTaskUpdate['task_color']);

        $response = $this->actingAs($this->test_user)->put(route('erp.executive.tasks.updateKanbanTask', $this->kanbanTaskUpdate))->assertStatus(302);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'task' => 'The task field is required.',
            'task_color' => 'The task color field is required.',
        ]);
    }

    public function test_try_to_update_kanban_task_with_long_text_data(): void
    {
        $this->longTextTest(
            'kanbanTaskUpdate',
            'task',
            'task',
            'kanban_tasks',
            'task',
            '50',
            'updateKanbanTask',
            'put',
        );
    }

    public function test_kanban_soft_delete(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.tasks.deleteKanban', ['id' => $this->test_kanban]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('kanbans', [
            'id' => $this->test_kanban->id,
            'kanban_title' => $this->test_kanban->kanban_title,
        ]);
    }

    public function test_kanban_task_soft_delete(): void
    {
        $response = $this->actingAs($this->test_user)->get(route('erp.executive.tasks.deleteKanbanTask', ['id' => $this->test_kanban_task]));
        $response->assertStatus(302);
        $this->assertSoftDeleted('kanban_tasks', [
            'id' => $this->test_kanban_task->id,
            'task' => $this->test_kanban_task->task,
        ]);
    }
}
