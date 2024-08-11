<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Timestamp;

class AttendanceTest extends TestCase
{
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
    public function user_cannot_start_work_twice(){
        $user = User::factory()->create();
        $this->actingAs($user);

        // 最初の勤務開始リクエストを送信
        $response = $this->post('/work_in');
        $response->assertStatus(302); // リダイレクトが発生するかを確認
        $response->assertSessionHas('message', '勤務を開始しました');

        // 再度勤務開始リクエストを送信
        $response = $this->post('/work_in');
        $response->assertStatus(302); // リダイレクトが発生するかを確認
        $response->assertSessionHas('error', 'すでに勤務を開始しています');

        // データベースに勤務開始が2回作成されていないことを確認
        $this->assertCount(1, Timestamp::where('user_id', $user->id)->get());
    }
}
