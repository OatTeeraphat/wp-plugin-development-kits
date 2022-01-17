<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Plugin Name:       WP Plugin Development Kits
 * Plugin URI:        https://github.com/VaLeXaR/wp-plugin-development-kit
 * Description:       Stater kits for wordpress development plugin
 * Author:            Incommon Studio
 * Text Domain:       wp-plugin-development-kits
 * Version:           1.0.0
 *
 * @package  WPM
 * @category Core
 * @author   Incommon Studio
 */

require('utils/router.php');
require('app/main.php');
require('app-child/main.php');