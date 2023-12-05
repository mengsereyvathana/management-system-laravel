<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Models\Team;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use LivewireUI\Spotlight\Spotlight;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#6521AF',
            ])
            ->font('Poppins')
            ->favicon('images/favicon.png')
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
//            ->sidebarCollapsibleOnDesktop()
//            ->sidebarFullyCollapsibleOnDesktop()
            ->navigationItems([
                NavigationItem::make('Blog')
                    ->url('https://vathana.com', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-pencil-square')
                    ->group('External')
                    ->sort(2)
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url('')
                    ->icon('heroicon-o-cog-6-tooth'),
                'logout' => MenuItem::make()->label('Log Out')
            ])
//            ->breadcrumbs(false)
            ->plugins([
                 SpotlightPlugin::make()
            ])
            //Multi-tenancy
            ->tenant(Team::class, ownershipRelationship: 'team')
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
