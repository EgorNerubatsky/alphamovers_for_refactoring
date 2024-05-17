<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


/**
 * @method get(string $string)
 */
class LeadPageTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);


    }

    public function test_user_index(): void
    {
        $response = $this->get('/');

//        dump($response->status());
//        dump($response->content());

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }


}
