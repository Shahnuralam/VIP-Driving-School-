<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'VIP Driving School',
    'title_prefix' => '',
    'title_postfix' => ' | Admin',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>VIP</b> Driving',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'VIP Driving School',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'VIP Driving School',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
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
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    'use_route_url' => true,
    'dashboard_url' => 'admin.dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => 'password.request',
    'password_email_url' => 'password.email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        ['header' => 'SERVICES MANAGEMENT'],

        [
            'text' => 'Services',
            'icon' => 'fas fa-fw fa-car',
            'submenu' => [
                [
                    'text' => 'All Services',
                    'route' => 'admin.services.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add Service',
                    'route' => 'admin.services.create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
                [
                    'text' => 'Categories',
                    'route' => 'admin.service-categories.index',
                    'icon' => 'fas fa-fw fa-tags',
                ],
            ],
        ],

        [
            'text' => 'Packages',
            'icon' => 'fas fa-fw fa-box',
            'submenu' => [
                [
                    'text' => 'All Packages',
                    'route' => 'admin.packages.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add Package',
                    'route' => 'admin.packages.create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Locations',
            'icon' => 'fas fa-fw fa-map-marker-alt',
            'submenu' => [
                [
                    'text' => 'All Locations',
                    'route' => 'admin.locations.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add Location',
                    'route' => 'admin.locations.create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        ['header' => 'BOOKING MANAGEMENT'],

        [
            'text' => 'Bookings',
            'icon' => 'fas fa-fw fa-calendar-check',
            'submenu' => [
                [
                    'text' => 'All Bookings',
                    'route' => 'admin.bookings.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Calendar View',
                    'route' => 'admin.bookings.calendar',
                    'icon' => 'fas fa-fw fa-calendar-alt',
                ],
                [
                    'text' => 'Pending Bookings',
                    'route' => 'admin.bookings.pending',
                    'icon' => 'fas fa-fw fa-clock',
                ],
            ],
        ],

        [
            'text' => 'Availability',
            'icon' => 'fas fa-fw fa-clock',
            'submenu' => [
                [
                    'text' => 'Manage Slots',
                    'route' => 'admin.availability.index',
                    'icon' => 'fas fa-fw fa-calendar-plus',
                ],
                [
                    'text' => 'Blocked Dates',
                    'route' => 'admin.availability.blocked',
                    'icon' => 'fas fa-fw fa-ban',
                ],
            ],
        ],

        ['header' => 'CONTENT MANAGEMENT'],

        [
            'text' => 'Pages',
            'icon' => 'fas fa-fw fa-file-alt',
            'submenu' => [
                [
                    'text' => 'All Pages',
                    'route' => 'admin.pages.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Add Page',
                    'route' => 'admin.pages.create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],

        [
            'text' => 'Info Cards',
            'route' => 'admin.info-cards.index',
            'icon' => 'fas fa-fw fa-info-circle',
        ],

        [
            'text' => 'Testimonials',
            'route' => 'admin.testimonials.index',
            'icon' => 'fas fa-fw fa-quote-left',
        ],

        [
            'text' => 'FAQs',
            'route' => 'admin.faqs.index',
            'icon' => 'fas fa-fw fa-question-circle',
        ],

        [
            'text' => 'Documents',
            'route' => 'admin.documents.index',
            'icon' => 'fas fa-fw fa-file-pdf',
        ],

        ['header' => 'CUSTOMERS & BOOKING'],

        [
            'text' => 'Customers',
            'route' => 'admin.customers.index',
            'icon' => 'fas fa-fw fa-user-friends',
        ],

        [
            'text' => 'Gift Vouchers',
            'route' => 'admin.gift-vouchers.index',
            'icon' => 'fas fa-fw fa-gift',
        ],

        [
            'text' => 'Instructors',
            'route' => 'admin.instructors.index',
            'icon' => 'fas fa-fw fa-chalkboard-teacher',
        ],

        [
            'text' => 'Coupons',
            'route' => 'admin.coupons.index',
            'icon' => 'fas fa-fw fa-tag',
        ],

        [
            'text' => 'Reviews',
            'route' => 'admin.reviews.index',
            'icon' => 'fas fa-fw fa-star',
        ],

        [
            'text' => 'Reschedule Requests',
            'route' => 'admin.reschedule-requests.index',
            'icon' => 'fas fa-fw fa-calendar-alt',
        ],

        [
            'text' => 'Cancellation Requests',
            'route' => 'admin.cancellation-requests.index',
            'icon' => 'fas fa-fw fa-times-circle',
        ],

        [
            'text' => 'Waitlist',
            'route' => 'admin.waitlist.index',
            'icon' => 'fas fa-fw fa-hourglass-half',
        ],

        ['header' => 'CONTENT & MARKETING'],

        [
            'text' => 'Blog',
            'icon' => 'fas fa-fw fa-blog',
            'submenu' => [
                ['text' => 'Categories', 'route' => 'admin.blog.categories.index', 'icon' => 'fas fa-fw fa-folder'],
                ['text' => 'Posts', 'route' => 'admin.blog.posts.index', 'icon' => 'fas fa-fw fa-file-alt'],
            ],
        ],

        [
            'text' => 'Newsletter',
            'route' => 'admin.newsletter.index',
            'icon' => 'fas fa-fw fa-envelope',
        ],

        [
            'text' => 'Service Areas',
            'route' => 'admin.suburbs.index',
            'icon' => 'fas fa-fw fa-map',
        ],

        [
            'text' => 'Theory Test',
            'icon' => 'fas fa-fw fa-book',
            'submenu' => [
                ['text' => 'Categories', 'route' => 'admin.theory.categories.index', 'icon' => 'fas fa-fw fa-list'],
            ],
        ],

        [
            'text' => 'Analytics',
            'route' => 'admin.analytics.index',
            'icon' => 'fas fa-fw fa-chart-line',
        ],

        ['header' => 'SETTINGS'],

        [
            'text' => 'Site Settings',
            'route' => 'admin.settings.index',
            'icon' => 'fas fa-fw fa-cog',
        ],

        [
            'text' => 'Users',
            'route' => 'admin.users.index',
            'icon' => 'fas fa-fw fa-users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
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
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'FullCalendar' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css',
                ],
            ],
        ],
        'Toastr' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
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
    */

    'livewire' => false,
];
