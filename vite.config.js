import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Resources paths
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
            
                // Resources assets js file paths
                'resources/assets/js/accordion',
                'resources/assets/js/advanced-form-elements',
                'resources/assets/js/apexcharts',
                'resources/assets/js/carousel',
                'resources/assets/js/chart.chartjs',
                'resources/assets/js/chart.flot',
                'resources/assets/js/chart.morris',
                'resources/assets/js/chart.peity',
                'resources/assets/js/chart.sparkline',
                'resources/assets/js/chat',
                'resources/assets/js/check-all-mail',
                'resources/assets/js/checkout-jquery-steps',
                'resources/assets/js/colorpicker',
                'resources/assets/js/contact',
                'resources/assets/js/echarts',
                'resources/assets/js/file-details',
                'resources/assets/js/form-editor-2',
                'resources/assets/js/form-editor',
                'resources/assets/js/form-elements',
                'resources/assets/js/form-layouts',
                'resources/assets/js/form-validation',
                'resources/assets/js/form-wizard',
                'resources/assets/js/fullcalendar',
                'resources/assets/js/gallery-1',
                'resources/assets/js/gallery',
                'resources/assets/js/handleCounter',
                'resources/assets/js/image-comparision',
                'resources/assets/js/index-dark',
                'resources/assets/js/index-map',
                'resources/assets/js/index',
                'resources/assets/js/index1',
                'resources/assets/js/invoice',
                'resources/assets/js/left-menu',
                'resources/assets/js/mail-two',
                'resources/assets/js/map-leafleft',
                'resources/assets/js/map.bluewater',
                'resources/assets/js/map.mapbox',
                'resources/assets/js/map.shiftworker',
                'resources/assets/js/modal-popup',
                'resources/assets/js/modal',
                'resources/assets/js/navigation',
                'resources/assets/js/newsticker',
                'resources/assets/js/popover',
                'resources/assets/js/profile',
                'resources/assets/js/rangeslider',
                'resources/assets/js/select2',
                'resources/assets/js/sidemenu',
                'resources/assets/js/summernote',
                'resources/assets/js/sweet-alert',
                'resources/assets/js/table-data',
                'resources/assets/js/tabs',
                'resources/assets/js/timline',
                'resources/assets/js/tooltip',
                'resources/assets/js/vector-map',
                'resources/assets/js/themecolor',
                'resources/assets/switcher/js/switcher',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
              {
                src: (['resources/assets/img/', 'resources/assets/plugins/', 'resources/assets/js/jquery.vmap.sampledata.js', 'resources/assets/js/sticky.js', 'resources/assets/iconfonts/', 'resources/assets/landing/']),
                dest: 'assets/'
              }
            ]
          }),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
});