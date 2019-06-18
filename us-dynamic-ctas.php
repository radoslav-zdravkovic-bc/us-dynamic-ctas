<?php
/*
Plugin Name:  US Dynamic CTAs
Plugin URI:   https://github.com/radoslav-zdravkovic-bc/us-dynamic-ctas/
Description:  Plugin that helps you add dynamic CTAs to the US sites
Version:      1.0
Author:       Radoslav Zdravkovic
Author URI:   https://github.com/radoslav-zdravkovic-bc/
*/

use USDynamicCTAs\UDCInit;

define('USDCM_PATH',  plugin_dir_path( __FILE__ ));

require 'vendor/autoload.php';

$USDynamicCTAsInit = new UDCInit();

