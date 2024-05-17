<?php

namespace Feature;

use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TasksSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
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
            'task_to_user_id' => $this->test_user->id,
            'task' => 'Тестове завдання № 1',
            'start_task' => '2024-11-26',
            'end_task' => '2024-12-26',
            'status' => 'Нове',
        ]);

        $this->validSearch = [
            "Тестове",
            'завдання',
            '№ 1',
            'Тестове завдання № 1',
        ];

        $this->invalidSearch = [
            "C@#$%^o",
            '6@#$%^872561',
            "<script>alert('Executing JS')</script>",
            '@#$%^',
            '://www.mysite.com',
        ];

        $this->longTextSearch = [
            str_repeat('A', 70),
            str_repeat('A', 301),
            str_repeat('A', 5000),
        ];

        $this->absenteesSearch = [
            "RTY",
            '603241888555',
            'Днепр',
            'вул.345',
            '0305743555',
        ];
        $this->irrelevantFilterData = [
            'company' => "RRT",
            'director_name' => "RRT",
            'contact_person_position' => 'Менеджер'
        ];

    }

    public function test_task_search_results_with_valid_data(): void
    {

        foreach ($this->validSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json
                    ->where("events.0.id", $this->test_task->id)
                    ->where("events.0.title", $this->test_task->task)
                    ->etc()
                );
        }
    }

    public function test_task_search_results_with_absentees_data(): void
    {
        foreach ($this->absenteesSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.search', ['search' => $search]));
            $response->assertStatus(200)
                ->assertJsonMissing([
                    "events.0.id" => $this->test_task->id,
                    "events.0.title" => $this->test_task->task,
                ]);
        }
    }

    public function test_task_search_results_with_invalid_data(): void
    {
        foreach ($this->invalidSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field format is invalid.']);
        }

    }

    public function test_task_search_results_with_long_text(): void
    {
        foreach ($this->longTextSearch as $search) {
            $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.search', ['search' => $search]));
            $response->assertStatus(422);
            $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);
        }
    }


    public function test_task_search_results_by_actual_status_new(): void
    {
//        $this->test_task->status = 'Нове';
//        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'Нове']));
//        dd($response);
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("events.0.id", $this->test_task->id)
                ->where("events.0.title", $this->test_task->task)
                ->etc()
            );
    }

    public function test_task_search_results_by_non_actual_status_new(): void
    {
        $this->test_task->status = 'Виконано';
        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'Нове']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "events.0.id" => $this->test_task->id,
                "events.0.title" => $this->test_task->task,
            ]);
    }


    public function test_task_search_results_by_actual_status_at_work(): void
    {

        $this->test_task->status = 'У роботі';
        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'У роботі']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("events.0.id", $this->test_task->id)
                ->where("events.0.title", $this->test_task->task)
                ->etc()
            );
    }

    public function test_task_search_results_by_non_actual_status_at_work(): void
    {

        $this->test_task->status = 'Виконано';
        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'У роботі']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "events.0.id" => $this->test_task->id,
                "events.0.title" => $this->test_task->task,
            ]);
    }

    public function test_task_search_results_by_actual_status_completed(): void
    {

        $this->test_task->status = 'Виконано';
        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'Виконано']));
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where("events.0.id" ,$this->test_task->id)
                ->where("events.0.title", $this->test_task->task)
                ->etc()
            );
    }
    public function test_task_search_results_by_non_actual_status_completed(): void
    {

        $this->test_task->status = 'У роботі';
        $this->test_task->save();

        $response = $this->actingAs($this->test_user)->getJson(route('erp.executive.tasks.index', ['selectStatus' => 'Виконано']));
        $response->assertStatus(200)
            ->assertJsonMissing([
                "events.0.id" => $this->test_task->id,
                "events.0.title" => $this->test_task->task,
            ]);
    }

}
