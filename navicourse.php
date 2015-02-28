<?php
/**
 * @package Navicourse
 */
/*
Plugin Name: Navicourse
Plugin URI: http://navicourse.com/
Description: Navi Course is a web application that is able to create a Military Land Navigation Course Based on the MGRS system. 
It generates a pdf file with Lane Strips and Solutions, and also plots all your points on a map.
Author: Jean N Pijeau
Author URI: http://logickeau.com
License: GPLv2 or later
Text Domain: navicourse
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


function add_navicourse_scripts()
{
    wp_enqueue_style('navicourse_style_main', plugins_url('css/style_main.css',
        __file__));
    wp_enqueue_script('google_maps',
        'http://maps.google.com/maps/api/js?sensor=false', array('jquery'));
}
add_action('wp_enqueue_scripts', 'add_navicourse_scripts');



/*
|--------------------------------------------------------------------------
| Defines
|--------------------------------------------------------------------------
*/
if (!defined('NAVICOURSE_PLUGIN_BASENAME'))
    define('NAVICOURSE_PLUGIN_BASENAME', plugin_basename(__file__));

if (!defined('NAVICOURSE_PLUGIN_NAME'))
    define('NAVICOURSE_PLUGIN_NAME', trim(dirname(NAVICOURSE_PLUGIN_BASENAME), '/'));

if (!defined('NAVICOURSE_PLUGIN_DIR'))
    define('NAVICOURSE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . NAVICOURSE_PLUGIN_NAME .
        '/');

if (!defined('NAVICOURSE_PLUGIN_URL')) {
    if (is_ssl()) {
        define('NAVICOURSE_PLUGIN_URL', str_replace('http', 'https', WP_PLUGIN_URL) .
            '/' . NAVICOURSE_PLUGIN_NAME . '/');
    } else {
        define('NAVICOURSE_PLUGIN_URL', WP_PLUGIN_URL . '/' . NAVICOURSE_PLUGIN_NAME .
            '/');
    }
}

//Autoload all navicourse classes.
function autoloader($class)
{
    $class = strtolower(str_replace('_', '-', $class));
    if (file_exists(plugin_dir_path(__file__) . 'classes/class-' . $class . '.php')) {
        include (plugin_dir_path(__file__) . 'classes/class-' . $class . '.php');
    }
}
spl_autoload_register('autoloader');


function navicourse()
{ 
    $pointsFile = (!empty($_FILES["file"]["tmp_name"])) ? file($_FILES["file"]["tmp_name"]) : "";        
    if (isset($_POST['submit'])) {
        switch($_POST["task"]){
        case "generate" :
            return NV_Generator::buildCourse($pointsFile);
            break;
        case "coursepoints":
            return NV_Generator::buildPointsForm($pointsFile);
            break;
            }
    } else {
        return NV_Generator::buildCourseForm($pointsFile);
    }
}
add_shortcode('navi', 'navicourse');