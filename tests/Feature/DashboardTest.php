<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_can_be_rendered_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk()
            ->assertSee('Resumen financiero')
            ->assertSee('Tendencia de Ingresos Mensuales')
            ->assertSee('Distribución por Periodicidad')
            ->assertSee('Próximos Vencimientos');
    }

    public function test_dashboard_calculates_financial_metrics(): void
    {
        $user = User::factory()->create();
        $client = Client::create([
            'titular' => 'Test Client',
            'empresa' => 'Test Corp',
            'estado' => 'Activo',
        ]);

        // Create some payments
        Payment::create([
            'cliente_id' => $client->cliente_id,
            'fecha' => now()->format('Y-m-d'),
            'monto' => '500000',
            'servicio' => 'Hosting',
            'periodicidad' => 'Mensual',
        ]);

        Payment::create([
            'cliente_id' => $client->cliente_id,
            'fecha' => now()->format('Y-m-d'),
            'monto' => '1200000',
            'servicio' => 'Web Design',
            'periodicidad' => 'Anual',
        ]);

        $component = Livewire::actingAs($user)
            ->test(\App\Livewire\Dashboard::class);

        $component->assertOk();
        
        // Assert public properties and calculated view variables
        $this->assertEquals(1700000, $component->viewData('ingresosTotales'));
        $this->assertEquals(1700000, $component->viewData('ingresoMes'));
        $this->assertEquals(850000, $component->viewData('ticketPromedio'));
        
        // Assert periodicity distribution
        $periodicity = $component->viewData('periodicitySums');
        $this->assertEquals(500000, $periodicity['Mensual']);
        $this->assertEquals(1200000, $periodicity['Anual']);
        $this->assertEquals(0, $periodicity['Único']);
    }

    public function test_dashboard_can_export_csv(): void
    {
        $user = User::factory()->create();
        $client = Client::create([
            'titular' => 'Test Client',
            'empresa' => 'Test Corp',
            'estado' => 'Activo',
        ]);

        Payment::create([
            'cliente_id' => $client->cliente_id,
            'fecha' => '2026-06-15',
            'monto' => '300000',
            'servicio' => 'Consulting',
            'periodicidad' => 'Único',
        ]);

        $response = Livewire::actingAs($user)
            ->test(\App\Livewire\Dashboard::class)
            ->call('exportCSV');

        $response->assertFileDownloaded();
    }

    public function test_payment_amount_formatting(): void
    {
        $this->assertEquals('858.000', Payment::formatMonto('858.000'));
        $this->assertEquals('583.200', Payment::formatMonto('583.200'));
        $this->assertEquals('629.980', Payment::formatMonto('629.980'));
        $this->assertEquals('1.096.200', Payment::formatMonto('1096200'));
        $this->assertEquals('1.118.000', Payment::formatMonto('1.118.000'));
        $this->assertEquals('1.280.000 Gs', Payment::formatMonto('1.280.000 Gs'));
        $this->assertEquals('30 u$', Payment::formatMonto('30 u$'));
        $this->assertEquals('0', Payment::formatMonto(''));
    }

    public function test_changing_client_updates_metrics(): void
    {
        $user = User::factory()->create();
        $client1 = Client::create(['titular' => 'Client One', 'estado' => 'Activo']);
        $client2 = Client::create(['titular' => 'Client Two', 'estado' => 'Activo']);

        Payment::create([
            'cliente_id' => $client1->cliente_id,
            'fecha' => '2026-06-01',
            'monto' => '500000',
            'servicio' => 'Hosting',
        ]);

        Payment::create([
            'cliente_id' => $client2->cliente_id,
            'fecha' => '2026-06-01',
            'monto' => '300000',
            'servicio' => 'Hosting',
        ]);

        $component = Livewire::actingAs($user)
            ->test(\App\Livewire\Dashboard::class)
            ->set('selected_client', $client1->cliente_id);

        $this->assertEquals(500000, $component->viewData('ingresosTotales'));
    }
}
