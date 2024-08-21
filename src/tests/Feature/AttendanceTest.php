<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Timestamp;
use Illuminate\Support\Facades\Mail;

class AttendanceTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function it_validates_name_length()
    {
        Mail::fake();

        $response = $this->postJson('/register', [
            'name' => str_repeat('a', 192),
            'email' => 'test_' . uniqid() . '@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['name']);
    }
}
