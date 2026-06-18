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
}
