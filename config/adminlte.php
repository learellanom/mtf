<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => 'MTF |',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>MoneyTracking</b>Financial',
    'logo_img' => 'vendor/adminlte/dist/img/tio_ammy.jpg',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'TioAmmi',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 80,
            'height' => 80,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 300,
            'height' => 300,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-dark',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,



    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-light elevation-4 text-sm',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'sm',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => false,
    'sidebar_nav_animation_speed' => 500,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => false,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => false,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar menu',
        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
       // ['header' => 'Master',
        //'classes' =>'text-uppercase font-weight-bold text-light',],
        //[
          //  'text'        => 'Comandas',
            //'url'         => 'comanda',
            //'icon'        => 'fas fa-chart-line',
            //'label'       => 4,
            //'label_color' => 'success',
        //],

        ['header' => 'Estadisticas',
        'classes' =>'text-uppercase font-weight-bold text-light',],

        [
            'text' => 'Estadisticas',
            'url'  => 'dashboardest',
            'icon' => 'fas fa-fw fas fa-chart-line',
            'can'  => 'dashboardtest',
        ],
        [
            'text' => 'Detalles de movimiento',
            'url'  => 'estadisticasDetalle',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.index',
        ],
        [
            'text' => 'Resumen por Cliente',
            'url'  => 'estadisticasResumenCliente',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenCliente',
        ],        
        [
            'text' => 'Resumen por Agente',
            'url'  => 'estadisticasResumenUsuario',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenCliente',
        ],
        [
            'text' => 'Resumen por Grupo',
            'url'  => 'estadisticasResumenGrupo',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenUsuario',
        ],
        [
            'text' => 'Resumen por Caja',
            'url'  => 'estadisticasResumenWallet',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenWallet',
        ],
        [
            'text' => 'Conciliacion por Grupo',
            'url'  => 'estadisticasConciliacionGrupo',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenConciliacionFechaGrupo'
        ],
        [
            'text' => 'Conciliacion por Fecha',
            'url'  => 'estadisticasConciliacionFecha',
            'icon' => 'fas fa-fw fas fa-chart-bar',
            'can'  => 'estadisticasDetalle.statisticsResumenConciliacionFecha'
        ],
        ['header' => 'Operaciones',
        'classes' =>'text-uppercase font-weight-bold text-light',],
        [
            'text'        => 'Transacciónes',
            'url'         => 'movimientos',
            'active'      => ['movimientos', 'regex:@^movimientos/[0-9]+/edit+$@', 'movimientos/create'],
            'can'         => 'transactions.index',
            'icon'        => 'fas fa-fw fas fa-retweet',
            'label'       => 4,
            'label_color' =>'success',
        ],
        [
            'text'        => 'Transacciónes en efectivo',
            'url'         => 'movimientos/efectivo',
            'active'      => ['movimientos/create_efectivo'],
            'can'         => 'transactions.create_efectivo',
            'icon'        => 'fas fa-fw fa-money-bill-alt',
            'label'       => 4,
            'label_color' =>'success',
        ],
        [
            'text'        => 'Transacciónes Master',
            'url'         => 'movimientos_master',
            'active'      => ['movimientos_master', 'regex:@^movimientos_master/[0-9]+/edit+$@', 'movimientos_master/create'],
            'can'         => 'transactions_master.index',
            'icon'        => 'fas fa-fw fas fa-money-check-alt',
            'label'       => 10,
            'label_color' =>'danger',
        ],
        [
            'text'        => 'Credito Caja',
            'url'         => "movimientos/credito",
            'active'      => ['credito'],
            'icon'        => 'fas fa-fw fas fa-box',
            'can'         => 'transactions.credit',
            'label'       => 4,
            'label_color' =>'success',
        ],

        ['header' => 'Configuración',
        'classes' =>'text-uppercase font-weight-bold text-light', 'can'  => 'users.index'],
        [
            'text'    => 'Usuarios',
            'url'  => 'usuarios',
            'active'      => ['usuarios*'],
            'icon'    => 'fas fa-fw fa-users',
            'can'         => 'users.index',
        ],
        [
            'text' => 'Roles',
            'url'  => 'roles',
            'active'      => ['roles*'],
            'icon'    => 'fas fa-fw fa-id-card-alt',
            'can'         => 'roles.index',
        ],
        [
            'text' => 'Clientes',
            'url'  => 'clientes',
            'active'      => ['clientes*'],
            'icon'    => 'fas fa-fw fa-user-tag',
            'can'         => 'clients.index',
        ],
        [
            'text' => 'Grupos',
            'url'  => 'grupos',
            'active'      => ['grupos*'],
            'icon' => 'fab fa-whatsapp',
            'can'         => 'groups.index'
        ],
        [
            'text'        => 'Cajas',
            'url'         => 'cajas',
            'active'      => ['cajas*'],
            'icon'        => 'fas fa-wallet',
            'label'       => 4,
            'label_color' => 'success',
            'can'         => 'wallets.index',
        ],
        [
            'text' => 'Tipo de movimiento',
            'url'  => 'tipo_transaccion',
            'active'      => ['tipo_transaccion*'],
            'icon'    => 'fas fa-exchange-alt',
            'can'         => 'type_transactions.index',
        ],
        [
            'text' => 'Tipo de monedas',
            'url'  => 'tipo_moneda',
            'active'      => ['tipo_moneda*'],
            'icon'    => 'fas fa-file-invoice-dollar',
            'can'         => 'type_coins.index',
        ],


        ],
        ['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
        ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],

            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    // 'location' => 'cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                    'location' => 'vendor/chart.js/Chart.js',
                ],
            ],
        ],
        'Fileinput' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fileinput/purify.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fileinput/sortable.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fileinput/fileinput.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fileinput/theme.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fileinput/es.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/fileinput/fileinput.css',
                ],
            ],
        ],


        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];

?>
