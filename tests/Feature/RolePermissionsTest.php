<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_access_user_manager_page(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);

        $response = $this->actingAs($admin)->get('/usuarios');

        $response->assertOk();
    }

    public function test_gestor_cannot_access_user_manager_page(): void
    {
        $gestor = User::factory()->create(['rol' => 'gestor']);

        $response = $this->actingAs($gestor)->get('/usuarios');

        $response->assertStatus(403);
    }

    public function test_administrator_can_delete_client(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);
        $client = Client::create(['empresa' => 'Acme Corp', 'estado' => 'Activo']);

        $component = Livewire::actingAs($admin)
            ->test(\App\Livewire\ClientManager::class)
            ->call('delete', $client->cliente_id);

        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('clientes', ['cliente_id' => $client->cliente_id]);
    }

    public function test_gestor_cannot_delete_client(): void
    {
        $gestor = User::factory()->create(['rol' => 'gestor']);
        $client = Client::create(['empresa' => 'Acme Corp', 'estado' => 'Activo']);

        $component = Livewire::actingAs($gestor)
            ->test(\App\Livewire\ClientManager::class)
            ->call('delete', $client->cliente_id);

        $component->assertHasNoErrors();
        $this->assertDatabaseHas('clientes', ['cliente_id' => $client->cliente_id]);
    }

    public function test_administrator_can_delete_payment(): void
    {
        $admin = User::factory()->create(['rol' => 'administrador']);
        $client = Client::create(['empresa' => 'Acme Corp', 'estado' => 'Activo']);
        $payment = Payment::create([
            'cliente_id' => $client->cliente_id,
            'monto' => '100000',
            'servicio' => 'Hosting',
            'fecha' => '2026-06-29'
        ]);

        $component = Livewire::actingAs($admin)
            ->test(\App\Livewire\PaymentManager::class)
            ->call('delete', $payment->pago_id);

        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('pagos', ['pago_id' => $payment->pago_id]);
    }

    public function test_gestor_cannot_delete_payment(): void
    {
        $gestor = User::factory()->create(['rol' => 'gestor']);
        $client = Client::create(['empresa' => 'Acme Corp', 'estado' => 'Activo']);
        $payment = Payment::create([
            'cliente_id' => $client->cliente_id,
            'monto' => '100000',
            'servicio' => 'Hosting',
            'fecha' => '2026-06-29'
        ]);

        $component = Livewire::actingAs($gestor)
            ->test(\App\Livewire\PaymentManager::class)
            ->call('delete', $payment->pago_id);

        $component->assertHasNoErrors();
        $this->assertDatabaseHas('pagos', ['pago_id' => $payment->pago_id]);
    }
}
