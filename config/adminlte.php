<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'إدارة عيادات الأسنان',
    'title_prefix' => '',
    'title_postfix' => '',
    'use_ico_only' => true,
    'use_full_favicon' => false,
    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-logo
    |
    */

    'logo' => '<b>عيادات</b> الأسنان ',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image-xl',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'عيادات الأسنان',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => 'container-fluid',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-sidebar
    |
    */

    'sidebar_mini' => true,
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
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-control-sidebar-right-sidebar
    |
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
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => false,

    'password_reset_url' => false,

    'password_email_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-menu
    |
    */

    'menu' => [

        [
            'text'        => 'الرئيسية',
            'url'         => './home',
            'icon'        => 'nav-icon fas fa-tachometer-alt',
            'permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ]
            //'label'       => 4,
            //'label_color' => 'success',
        ],
        [
            'text'    => 'المرضى',
            'icon'    => 'fa fa-user',
            'permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ],
            'submenu' => [
                [
                    'text' => 'إضافة مريض',
                    'url'  => '/user/add',
                    'icon'    => 'fa fa-user-plus','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]

                ],

                [
                    'text' => 'البحث عن مريض',
                    'url'  => '/user/search',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ]
                ],
                [
                    'text' => 'تعديل بطاقة مريض',
                    'url'  => '/user/edit',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]
                ],
            ],
        ],
        [
            'text'    => 'المواعيد',
            'icon'    => 'fas fa-tasks',
            'permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة موعد',
                    'url'  => '/dates/choose',
                    'icon'    => 'fas fa-folder-plus','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]
                ],

                [
                    'text' => 'اظهار مواعيد طبيب',
                    'url'  => '/dates/select',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]
                ],

            ],
        ],
        [
            'text'    => 'السجلات',
            'icon'    => 'fas fa-folder',
            'permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ],
            'submenu' => [
                [
                    'text' => 'إضافة سجل',
                    'url'  => '/records/select',
                    'icon'    => 'fas fa-folder-plus','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],

                [
                    'text' => 'البحث عن سجل',
                    'url'  => '/records/search',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],
                [
                    'text' => 'تعديل معلومات سجل',
                    'url'  => '/records/edit',
                    'icon'    => 'fas fa-folder-minus','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],
            ],
        ],
        [
            'text'    => 'محاسبة',
            'icon'    => 'fas fa-money-bill',
            'permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ],
            'submenu' => [
                [
                    'text' => 'عمليات محاسبية ',
                    'url'  => '/money/select',
                    'icon'    => 'fas fa-hospital','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],
                [
                    'text' => 'استعراض',
                    'url'  => '/money/view',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],
            ],
        ],
        [
            'text'    => 'الأطباء',
            'icon'    => 'fa fa-user-md',
            'permission'  => [ 1=>true, 2=>false, 3=>true, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة طبيب',
                    'url'  => '/doctor/add',
                    'icon'    => 'fa fa-user-md','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],

                [
                    'text' => 'البحث عن طبيب',
                    'url'  => '/doctor/search',
                    'icon'    => 'fa fa-stethoscope','permission'  => [ 1=>true, 2=>false, 3=>true, 4=>false ]
                ],
                [
                    'text' => 'تعديل معلومات طبيب',
                    'url'  => '/doctor/edit',
                    'icon'    => 'fa fa-medkit','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],
            ],
        ],

        [
            'text'    => 'المراكز',
            'icon'    => 'fab fa-fort-awesome',
            'permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة مركز',
                    'url'  => '/center/add',
                    'icon'    => 'fa fa-user-plus','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],

                [
                    'text' => 'البحث عن مركز',
                    'url'  => '/center/search',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],
                [
                    'text' => 'تعديل معلومات مركز',
                    'url'  => '/center/edit',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],
            ],
        ],
        [
            'text'    => 'المخابر',
            'icon'    => 'fas fa-hospital-alt',
            'permission'  => [ 1=>true, 2=>true, 3=>false, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة مخبر',
                    'url'  => '/lab/add',
                    'icon'    => 'fas fa-hospital','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],

                [
                    'text' => 'البحث عن مخبر',
                    'url'  => '/lab/search',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>false ]
                ],
                [
                    'text' => 'تعديل معلومات مخبر',
                    'url'  => '/lab/edit',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ]
                ],
            ],
        ],



        [
            'text'    => 'الأمراض',
            'icon'    => 'fas fa-frown' ,
            'permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة مرض',
                    'url'  => '/diseases/add',
                    'icon'    => 'fas fa-hospital','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]
                ],
                [
                    'text' => 'الأمراض',
                    'url'  => '/diseases/view',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>false ]
                ],
            ],
        ],

        [
            'text'    => 'اليوزرات',
            'icon'    => 'fas fa-users',
            'permission'  => [ 1=>true, 2=>false, 3=>false, 4=>false ],
            'submenu' => [
                [
                    'text' => 'إضافة مستخدم',
                    'url'  => '/account/add',
                    'icon'    => 'fas fa-hospital','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ]
                ],

                [
                    'text' => 'البحث  مستخدم',
                    'url'  => '/account/search',
                    'icon'    => 'fa fa-search','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ]
                ],
                [
                    'text' => 'تعديل معلومات مستخدم',
                    'url'  => '/account/edit',
                    'icon'    => 'fa fa-users','permission'  => [ 1=>true, 2=>true, 3=>true, 4=>true ]
                ],
            ],
        ],
        [
            'text'    => 'المعالجات',
            'icon'    => 'fas fa-tooth',
            'permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ],
            'submenu' => [
                [
                    'text' => 'إضافة',
                    'url'  => '/Treatment/add',
                    'icon'    => 'fas fa-teeth-open','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]

                ],
                [
                    'text' => 'عرض المعالجات',
                    'url'  => '/Treatment/search',
                    'icon'    => 'fa fa-teeth','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],
                [
                    'text' => 'تعديل',
                    'url'  => '/Treatment/edit',
                    'icon'    => 'fa fa-stethoscope','permission'  => [ 1=>true, 2=>true, 3=>false, 4=>true ]
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        //JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\MyMenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
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
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'daterangepicker',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/momentjs/latest/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
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
    ],
];
