<?php

namespace App\Filament\Widgets;

use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Order;  // Usando o modelo Order
use App\Models\Keys;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Busca o usuário logado
        $user = auth()->user(); // Usuário logado

        // Acessa a chave associada ao usuário
        $key = Keys::where('user_id', $user->id)->first();

        // Inicializa as variáveis de contagem
        $totalPedidos = 0;
        $pedidosDigistore = 0;

        // Verifica se encontrou a chave para esse usuário
        if ($key) {
            // Faz a requisição à API CartPanda para obter o total de pedidos
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $key->authorization,
            ])->get("https://accounts.cartpanda.com/api/v3/{$key->shop_slug}/orders/count");

            // Verifica se a resposta foi bem-sucedida
            if ($response->successful()) {
                $totalPedidos = $response->json()['count'] ?? 0;
            }

            // Consulta a tabela 'orders' para contar quantos pedidos têm o mesmo 'merchant_name' do usuário logado
            // Agora, a consulta busca pelo merchant_name do usuário logado
            $pedidosDigistore = Order::where('merchant_name', $user->merchant_name)->count();
        }

        // Retorna as estatísticas com gráficos, integrando os dados de pedidos e o ID do usuário
        return [
            Stat::make('ID do produtor', $user->id)
                ->icon('heroicon-o-user')
                ->color('primary')
                ->icon('heroicon-o-user')
                ->backgroundColor('gray')
                ->progress(10)
                ->progressBarColor('gray')
                ->iconBackgroundColor('gray')
                ->chartColor('gray')
                ->iconPosition('start')
                ->description('Seu ID #TB3.')
                ->descriptionIcon('heroicon-o-arrow-right-end-on-rectangle', 'before')
                ->descriptionColor('Amber')
                ->iconColor('success'),

            Stat::make('Pedidos CartPanda', $totalPedidos)
                ->icon('heroicon-o-beaker')
                ->description('Total Pedidos')
                ->descriptionIcon('heroicon-o-bell-alert', 'before')
                ->descriptionColor('primary')
                ->iconColor('warning'),

            // Novo campo: Pedidos Digistore
            Stat::make('Pedidos Digistore', $pedidosDigistore)
                ->icon('heroicon-o-globe-americas')
                ->description('Total Pedidos')
                ->descriptionIcon('heroicon-o-information-circle', 'before')
                ->descriptionColor('primary')
                ->iconColor('warning'),
        ]; 
    }
}
