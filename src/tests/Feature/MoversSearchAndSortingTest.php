<?php

namespace Feature;

use App\Models\Mover;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MoversSearchAndSortingTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_executive' => true,
        ]);

        $this->test_mover = Mover::factory()->create([
            'name' => 'Тимур',
            'lastname' => 'Квиря',
            'birth_date' => '2002-08-04 00:00:00',
            'gender' => 'чол',
            'address' => 'Харків, Вулиця 3',
            'phone' => '+380951234222',
            'email' => 'em22ail@test.com',
            'note' => 'кат. 4',
            'advantages' => 'Автонавантажувач',
            'bank_card' => '4567678975343423',
            'passport_number' => '117479',
            'passport_series' => 'ТЕ',
        ]);

    }

    public function test_mover_search_json_results_with_valid_date(): void
    {
        $expectedMoverId = $this->test_mover->id;

        $this->assertSuccessfulSearch('Квиря', '4567678975343423', "em22ail@test.com", $expectedMoverId);
        $this->assertSuccessfulSearch('Харків', '4567678975343423', "em22ail@test.com", $expectedMoverId);
        $this->assertSuccessfulSearch('0951234222', '4567678975343423', "em22ail@test.com", $expectedMoverId);
        $this->assertSuccessfulSearch('em22ail@test.com', '4567678975343423', "em22ail@test.com", $expectedMoverId);
    }

    private function assertSuccessfulSearch(string $searchQuery, string $expectedBankCard, string $expectedEmail, $expectedMoverId): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $expectedMoverId)
                ->where("movers.data.0.bank_card", $expectedBankCard)
                ->where("movers.data.0.email", $expectedEmail)
                ->etc()
            );
    }

    public function test_mover_search_json_results_with_absentees_date(): void
    {
        $this->assertAbsenteesSearch('444444');
        $this->assertAbsenteesSearch('Барег');
        $this->assertAbsenteesSearch('09845678');
        $this->assertAbsenteesSearch('tesnmail');
    }

    private function assertAbsenteesSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.search', ['search' => $searchQuery]));
        $response->assertStatus(200)
            ->assertJsonMissingPath("movers.data.0")
            ->assertJsonMissingPath("movers.data.0.id");
    }

    public function test_mover_search_json_results_with_invalid_date(): void
    {
        $this->assertInvalidSearch('!@#$%');
        $this->assertInvalidSearch("<blink>Hello there</blink>");
        $this->assertInvalidSearch("Robert'); DROP TABLE Students;--");
    }

    private function assertInvalidSearch(string $searchQuery): void
    {
        $response = $this->actingAs($this->user)->get(route('erp.executive.movers.search', ['search' => $searchQuery]));
        $response->assertStatus(302);
        $response->assertSessionHasErrors('search', 'The search field format is invalid.');
    }

    public function test_mover_search_json_results_with_long_text_date(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.search', ['search' => str_repeat('A', 301)]));
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The search field must not be greater than 50 characters.']);

    }


    public function test_mover_filter_by_name_results(): void
    {
        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.movers.index', ['mover' => $this->test_mover->id]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }

    public function test_mover_filter_by_phone_results(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.index', ['phone' => $this->test_mover->phone]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }

    public function test_mover_filter_by_category_results(): void
    {

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.index', ['note' => $this->test_mover->note]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }

    public function test_mover_filter_by_advantages_results(): void
    {

        $response = $this->actingAs($this->user)->getJson(route('erp.executive.movers.index', ['advantages' => $this->test_mover->advantages]));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }


    public function test_mover_filter_by_start_age_results(): void
    {

        $this->test_mover['birth_date'] = '1981-12-27 09:00:01';
        $this->test_mover->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.movers.index', ['age_from' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );

    }

    public function test_mover_filter_by_end_age_results(): void
    {

        $this->test_mover['birth_date'] = '1986-02-28 09:00:01';
        $this->test_mover->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.movers.index', ['age_to' => '40']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }

    public function test_mover_filter_by_start_end_age_results(): void
    {

        $this->test_mover['birth_date'] = '1999-12-28 09:44:54';
        $this->test_mover->save();

        $this->actingAs($this->user);
        $response = $this->getJson(route('erp.executive.movers.index', ['age_from' => '20', 'age_to' => '30']));
        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where("movers.data.0.id", $this->test_mover->id)
                ->where("movers.data.0.bank_card", $this->test_mover->bank_card)
                ->where("movers.data.0.phone", $this->test_mover->phone)
                ->etc()
            );
    }

}
