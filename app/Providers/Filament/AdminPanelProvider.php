<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\MapWidget;
use App\Filament\Resources\UltimosPedidosResource\Widgets\Pedidos; // Importando o widget Pedidos
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\FontProviders\GoogleFontProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Widgets\StatsOverview; // Importando o widget StatsOverview
use App\Filament\Widgets\OrderTableWidget; // Importando o seu widget personalizado
use Filament\Icons\Heroicon;
use Illuminate\Auth\Middleware\Authenticate;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin_panel') // Definindo um ID único para o painel
            ->default() // Configuração padrão
            ->path('produtores') // Definindo a URL base do painel
            ->login() // Habilitando login no painel
            ->registration() // Habilitando registro no painel
            ->colors([
                'primary' => Color::Green, // Definindo a cor primária para o painel
            ])
            ->topNavigation() // Método para configurar a navegação superior
            ->font('Gotham Black', provider: GoogleFontProvider::class) // Definindo fonte do painel
            ->brandLogo(asset('images/tb3logo.png')) // Logo do painel
            ->favicon(asset('images/favicontb3.png')) // Favicon
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') // Descobrir recursos
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') // Descobrir páginas
            ->pages([
                Pages\Dashboard::class, // Página do Dashboard
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // Descobrir widgets na pasta correta
            ->widgets([
                StatsOverview::class, // Registrando o widget StatsOverview
                Pedidos::class, // Registrando o widget Pedidos
            ])
            ->resources([
                // Recursos como o OrderResource podem ser registrados aqui, se necessário
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                Authenticate::class, // Middleware correto de autenticação
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label('Dashboard')
                    ->url('/produtores')
                    ->icon('heroicon-o-home')
                    ->badge(fn () => static::getNavigationBadge()), // Badge para Dashboard
            ])
            ->maxContentWidth('ExtraLarge') // Não deve ter ponto e vírgula aqui, porque estamos continuando o encadeamento
            ->databaseNotifications()  // Ativando notificações no banco de dados
            ->databaseNotificationsPolling('30s');  // Definindo o intervalo de polling para notificações (30 segundos)
    }

    /**
     * Método para retornar o badge da navegação.
     *
     * @return int
     */
    public static function getNavigationBadge()
    {
        return rand(10, 50); // Exemplo de número aleatório para badge
    }
}
