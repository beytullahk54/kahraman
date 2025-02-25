<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;
    public function test_appointments_index_returns_200()
    {
        // Test kullanıcısı oluştur
        $user = User::factory()->create();
        
        
        Log::info('Test kullanıcısı oluşturuldu', ['user_id' => $user->id]);
        
        // Kullanıcı olarak istek yap
        $response = $this->actingAs($user)
            ->get(route('appointments.index'));

        Log::info('Appointments index isteği yapıldı', [
            'status' => $response->status(),
            'user_id' => $user->id
        ]);

        // 200 durum kodu aldığımızı kontrol et
        $response->assertStatus(200);
    }
} 