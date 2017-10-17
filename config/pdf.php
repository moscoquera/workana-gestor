<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10/16/17
 * Time: 4:57 PM
 */

define('_MPDF_TTFONTDATAPATH',sys_get_temp_dir().'/');
return [
    'mode'                 => '',
    'format'               => 'A4',
    'default_font_size'    => '12',
    'default_font'         => 'sans-serif',
    'margin_left'          => 10,
    'margin_right'         => 10,
    'margin_top'           => 10,
    'margin_bottom'        => 10,
    'margin_header'        => 10,
    'margin_footer'        => 10,
    'orientation'          => 'P',
    'title'                => 'Laravel mPDF',
    'author'               => '',
    'watermark'            => '',
    'show_watermark'       => false,
    'watermark_font'       => 'sans-serif',
    'display_mode'         => 'fullpage',
    'watermark_text_alpha' => 0.1
];