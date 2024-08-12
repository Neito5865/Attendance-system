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

        // テスト中のCSRFトークン検証を無効化
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
           'name' => str_repeat('a', 192), // 192文字の名前
           'email' => 'test_' . uniqid() . '@example.com', // 必要な他のフィールドも追加
           'password' => 'password', // 必要な他のフィールドも追加
           'password_confirmation' => 'password', // 必要な他のフィールドも追加
        ]);

       // ステータスコード422（バリデーションエラー）を確認
        $response->assertStatus(422);

       // JSONレスポンスにエラーが含まれていることを確認
        $response->assertJsonValidationErrors(['name']);
    }
}
