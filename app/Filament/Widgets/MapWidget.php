<?php

namespace App\Filament\Widgets;

use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MapWidget extends WorldMapWidget
{
    /**
     * Método stats() com assinatura compatível com o método da classe pai.
     *
     * @return array*/

protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '4s';
     
    protected static ?string $heading = 'Últimas 15 Transações';

    public function stats(): array
    {
        // Obter o ID do usuário logado
        $userId = Auth::id();

        // Consultar a tabela 'orders' para contar a quantidade de pedidos por país
        $ordersCount = DB::table('orders')
            ->select('address_country', DB::raw('count(*) as total'))
            ->where('user_id', $userId) // Filtro baseado no usuário logado
            ->groupBy('address_country') // Agrupar por país
            ->get();

        // Preparar os dados para o formato esperado pelo widget
        $stats = [];
        foreach ($ordersCount as $order) {
            // Adicionar o total de pedidos por país
            $stats[$order->address_country] = $order->total;
        }

        return $stats;
    }

    /**
     * Define a altura do widget.
     *
     * @return string
     */
    public function height(): string
    {
        return '332px'; // Altura padrão do widget
    }

    /**
     * Define a largura do widget.
     *
     * @return string
     */
    public function width(): string
    {
        return '10px'; // Largura padrão do widget
    }

    /**
     * Definir o título exibido para o widget.
     *
     * @return string
     */
    public function label(): string
    {
        return 'Pedidos por País'; // Título que será exibido para o cliente
    }
}
