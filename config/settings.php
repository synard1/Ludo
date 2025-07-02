<?php

return [

    'KT_THEME_BOOTSTRAP' => [
        'default' => \App\Core\Bootstrap\BootstrapDefault::class,
        'auth' => \App\Core\Bootstrap\BootstrapAuth::class,
        'system' => \App\Core\Bootstrap\BootstrapSystem::class,
    ],

    'KT_THEME' => 'metronic',

    # Theme layout templates directory

    'KT_THEME_LAYOUT_DIR' => 'layout',


    # Theme Mode
    # Value: light | dark | system

    'KT_THEME_MODE_DEFAULT' => 'light',
    'KT_THEME_MODE_SWITCH_ENABLED' => true,


    # Theme Direction
    # Value: ltr | rtl

    'KT_THEME_DIRECTION' => 'ltr',


    # Keenicons
    # Value: duotone | outline | bold

    'KT_THEME_ICONS' => 'duotone',


    # Theme Assets

    'KT_THEME_ASSETS' => [
        'favicon' => 'assets/media/logos/favicon.ico',
        'fonts' => [
            'https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700',
        ],
        'global' => [
            'css' => [
                'assets/plugins/global/plugins.bundle.css',
                'assets/css/style.bundle.css',
            ],
            'js' => [
                'assets/plugins/global/plugins.bundle.js',
                'assets/js/scripts.bundle.js',
                // 'assets/js/widgets.bundle.js',
            ],
        ],
    ],


    # Theme Vendors

    'KT_THEME_VENDORS' => [
        'datatables' => [
            'css' => [
                '//cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css',
            ],
            'js' => [
                '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
                '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js',
                '//cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js',
            ],
        ],
        // 'datatables' => [
        //     'css' => [
        //         'assets/plugins/custom/datatables/datatables.bundle.css',
        //     ],
        //     'js' => [
        //         'assets/plugins/custom/datatables/datatables.bundle.js',
        //     ],
        // ],
        'formrepeater' => [
            'js' => [
                'assets/plugins/custom/formrepeater/formrepeater.bundle.js',
            ],
        ],
        'fullcalendar' => [
            'css' => [
                'assets/plugins/custom/fullcalendar/fullcalendar.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/fullcalendar/fullcalendar.bundle.js',
            ],
        ],
        'flotcharts' => [
            'js' => [
                'assets/plugins/custom/flotcharts/flotcharts.bundle.js',
            ],
        ],
        'google-jsapi' => [
            'js' => [
                '//www.google.com/jsapi',
            ],
        ],
        'tinymce' => [
            'js' => [
                // 'assets/plugins/custom/tinymce/tinymce.js',
                'https://cdn.tiny.cloud/1/74rug7pscx6df81im7i19olwtfsjqe72nms1ld0ttq7qi6a8/tinymce/6/tinymce.min.js',
            ],
        ],
        'ckeditor-classic' => [
            'js' => [
                'assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js',
            ],
        ],
        'ckeditor-inline' => [
            'js' => [
                'assets/plugins/custom/ckeditor/ckeditor-inline.bundle.js',
            ],
        ],
        'ckeditor-balloon' => [
            'js' => [
                'assets/plugins/custom/ckeditor/ckeditor-balloon.bundle.js',
            ],
        ],
        'ckeditor-balloon-block' => [
            'js' => [
                'assets/plugins/custom/ckeditor/ckeditor-balloon-block.bundle.js',
            ],
        ],
        'ckeditor-document' => [
            'js' => [
                'assets/plugins/custom/ckeditor/ckeditor-document.bundle.js',
            ],
        ],
        'draggable' => [
            'js' => [
                'assets/plugins/custom/draggable/draggable.bundle.js',
            ],
        ],
        'fslightbox' => [
            'js' => [
                'assets/plugins/custom/fslightbox/fslightbox.bundle.js',
            ],
        ],
        'jkanban' => [
            'css' => [
                'assets/plugins/custom/jkanban/jkanban.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/jkanban/jkanban.bundle.js',
            ],
        ],
        'typedjs' => [
            'js' => [
                'assets/plugins/custom/typedjs/typedjs.bundle.js',
            ],
        ],
        'cookiealert' => [
            'css' => [
                'assets/plugins/custom/cookiealert/cookiealert.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/cookiealert/cookiealert.bundle.js',
            ],
        ],
        'cropper' => [
            'css' => [
                'assets/plugins/custom/cropper/cropper.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/cropper/cropper.bundle.js',
            ],
        ],
        'vis-timeline' => [
            'css' => [
                'assets/plugins/custom/vis-timeline/vis-timeline.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/vis-timeline/vis-timeline.bundle.js',
            ],
        ],
        'jstree' => [
            'css' => [
                'assets/plugins/custom/jstree/jstree.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/jstree/jstree.bundle.js',
            ],
        ],
        'prismjs' => [
            'css' => [
                'assets/plugins/custom/prismjs/prismjs.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/prismjs/prismjs.bundle.js',
            ],
        ],
        'leaflet' => [
            'css' => [
                'assets/plugins/custom/leaflet/leaflet.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/leaflet/leaflet.bundle.js',
            ],
        ],
        'amcharts' => [
            'js' => [
                'https://cdn.amcharts.com/lib/5/index.js',
                'https://cdn.amcharts.com/lib/5/xy.js',
                'https://cdn.amcharts.com/lib/5/percent.js',
                'https://cdn.amcharts.com/lib/5/radar.js',
                'https://cdn.amcharts.com/lib/5/themes/Animated.js',
            ],
        ],
        'amcharts-maps' => [
            'js' => [
                'https://cdn.amcharts.com/lib/5/index.js',
                'https://cdn.amcharts.com/lib/5/map.js',
                'https://cdn.amcharts.com/lib/5/geodata/worldLow.js',
                'https://cdn.amcharts.com/lib/5/geodata/continentsLow.js',
                'https://cdn.amcharts.com/lib/5/geodata/usaLow.js',
                'https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js',
                'https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js',
                'https://cdn.amcharts.com/lib/5/themes/Animated.js',
            ],
        ],
        'amcharts-stock' => [
            'js' => [
                'https://cdn.amcharts.com/lib/5/index.js',
                'https://cdn.amcharts.com/lib/5/xy.js',
                'https://cdn.amcharts.com/lib/5/themes/Animated.js',
            ],
        ],
        'bootstrap-select' => [
            'css' => [
                'assets/plugins/custom/bootstrap-select/bootstrap-select.bundle.css',
            ],
            'js' => [
                'assets/plugins/custom/bootstrap-select/bootstrap-select.bundle.js',
            ],
        ],
        'signpad' => [
            'css' => [
                'assets/css/jquery.signature.css',
            ],
            'js' => [
                'assets/js/jquery.signature.js',
            ],
        ],
        'tempus-dominus' => [
            'css' => [
                'https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css',
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous',
            ],
        ],
    ],

];
