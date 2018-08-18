<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/croppie.css',
        'css/colorPicker.css',
        'css/datepicker.css',
        # 'themes/inspinia/css/bootstrap.min.css', # core, already included
        'themes/inspinia/font-awesome/css/font-awesome.css',
        'themes/inspinia/css/animate.css',
        'themes/inspinia/css/style.css',
        'themes/inspinia/css/plugins/toastr/toastr.min.css',
        'themes/inspinia/js/plugins/gritter/jquery.gritter.css',
        'themes/inspinia/css/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'themes/inspinia/css/plugins/summernote/summernote.css',
        'themes/inspinia/css/plugins/summernote/summernote-bs3.css',
        'themes/inspinia/css/plugins/iCheck/custom.css',

        # calendar-related
        'themes/inspinia/css/plugins/fullcalendar/fullcalendar.css',
        'css/jquery-ui.css',

    ];
    public $js = [
        # 'themes/inspinia/js/jquery-2.1.1.js', # core, already included
        # 'themes/inspinia/js/bootstrap.min.js', # core, already included
        'themes/inspinia/js/plugins/metisMenu/jquery.metisMenu.js',
        'themes/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'themes/inspinia/js/plugins/flot/jquery.flot.js',
        'themes/inspinia/js/plugins/flot/jquery.flot.tooltip.min.js',
        'themes/inspinia/js/plugins/flot/jquery.flot.spline.js',
        'themes/inspinia/js/plugins/flot/jquery.flot.resize.js',
        'themes/inspinia/js/plugins/flot/jquery.flot.pie.js',
        'themes/inspinia/js/plugins/peity/jquery.peity.min.js',
        'themes/inspinia/js/demo/peity-demo.js',
        'themes/inspinia/js/inspinia.js',
        'themes/inspinia/js/plugins/pace/pace.min.js',
        'themes/inspinia/js/plugins/jquery-ui/jquery-ui.min.js',
        'themes/inspinia/js/plugins/gritter/jquery.gritter.min.js',
        'themes/inspinia/js/plugins/sparkline/jquery.sparkline.min.js',
        'themes/inspinia/js/demo/sparkline-demo.js',
//        'themes/inspinia/js/plugins/chartJs/Chart.min.js',
        'themes/inspinia/js/plugins/toastr/toastr.min.js',
        'themes/inspinia/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'themes/inspinia/js/plugins/masonary/masonry.pkgd.min.js',

        # iCheck
        'themes/inspinia/js/plugins/iCheck/icheck.min.js',

        # calendar-related
        'themes/inspinia/js/plugins/fullcalendar/moment.min.js',
        'themes/inspinia/js/plugins/fullcalendar/fullcalendar.min.js',
        'js/summernote/summernote.min.js',
        'js/jquery-ui.js',

        'js/jquery.are-you-sure.js',
        'js/croppie.min.js',
        'js/bootstrap-datepicker.js',
        'js/site.js',
        'js/jquery.colorPicker.js',
        '/js/PDFObject-master/pdfobject.js',
        'js/ajax-modal-popup.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        # 'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset', # this is a replacement for 'BootstrapAsset' to force the inclusion of bootstrap JS
    ];
}
