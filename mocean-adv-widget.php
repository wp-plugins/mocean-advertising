<?php

/* * *
  Plugin Name: Mocean Advertisement Plugin
  Author URI: http://www.moceanmobile.com
  Description: Mocean Advertisement Plugin is a plugin for wordpress websites and provides a simple, straightforward way to place ads from an Mocean advertisement server on a website.
  Version: 1.0.0
  Author: Mojiva Inc, techsupport@moceanmobile.com
  Plugin URI: http://www.moceanmobile.com
 * * */

/* * *
  +---------------------------------------------------------------------------+
  | Copyright (c) 2013 Mojiva Inc                                             |
  |                                                                           |
  | This program is free software; you can redistribute it and/or modify      |
  | it under the terms of the GNU General Public License as published by      |
  | the Free Software Foundation; either version 2 of the License, or         |
  | (at your option) any later version.                                       |
  |                                                                           |
  | This program is distributed in the hope that it will be useful,           |
  | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
  | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
  | GNU General Public License for more details.                              |
  |                                                                           |
  | You should have received a copy of the GNU General Public License         |
  | along with this program; if not, write to the Free Software               |
  | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
  +---------------------------------------------------------------------------+
 */


$mocean_version = "1.0.0";
$mocean_db_version = "1.0.0";

/**
 * creates static mocean advertisement div on page
 * @param array $args
 * @param array $widget_args
 */
function mocean_widget($args, $widget_args = 1) {
    $options = get_option('mocean_widget_options');
    $number = $widget_args['number'];
    include 'views/mocean_widget.php';
}

/**
 * adds sidebar menu items to admin panel
 */
function mocean_admin_menu() {
    if (function_exists('add_options_page')) {
        add_options_page('options-general.php', 'Mocean Stats', 9, 'mocean_stats', 'mocean_stats');
        add_options_page('options-general.php', 'Mocean Error Logs', 10, 'mocean_errors', 'mocean_errors');
    }
}


/**
 * adds css, javascript to user header
 */
function mocean_head() {

    $options = get_option('mocean_widget_options');
    $options = $options['options'];
    unset($options[0]);

    foreach ($options as $key => $option) {

        $option['key'] = 6;
        $option['jsvar'] = 'adv' . $key;
        unset($option['title']);
        unset($option['zonecount']);

        if (!$option['keywords']) {
            unset($option['keywords']);
        }

        if (!$option['campaigns']) {
            unset($option['campaigns']);
        }

        if (!is_numeric($option['min_size_x']))
            unset($option['min_size_x']);
        if (!is_numeric($option['size_x']))
            unset($option['size_x']);
        if (!is_numeric($option['min_size_y']))
            unset($option['min_size_y']);
        if (!is_numeric($option['size_y']))
            unset($option['size_y']);


        $urls[$key] = "http://ads.mocean.mobi/ad?" . http_build_query($option);
        $keys[]=$key;
    }

    wp_enqueue_script('jquery');
    wp_enqueue_script('mocean', plugins_url('/js/mocean.js', __FILE__), array('scriptaculous'));
    
    include_once 'views/mocean_head.php';
}

/**
 * 
 * creates mocean stats page in admin panel
 */
function mocean_stats() {
    global $wpdb;


    if ($_GET['reset'] == 'true') {
        $sql = "DELETE FROM wp_mocean_click";
        $wpdb->query($sql);
        $last_1_day = 0;
        $last_7_day = 0;
        $last_30_day = 0;
        $last = 0;
    } else {
        $sql = "SELECT count(id) as 'count', date(time) as 'date', adv_id FROM wp_mocean_click WHERE time>(CURRENT_TIMESTAMP-86400) GROUP BY adv_id ORDER BY adv_id";
        $last_1_day = $wpdb->get_results($sql);

        $sql = "SELECT count(id) as 'count', date(time) as 'date', adv_id FROM wp_mocean_click WHERE time>(CURRENT_TIMESTAMP-7*86400) GROUP BY adv_id  ORDER BY adv_id";
        $last_7_day = $wpdb->get_results($sql);

        $sql = "SELECT count(id) as 'count', date(time) as 'date', adv_id FROM wp_mocean_click WHERE time>(CURRENT_TIMESTAMP-30*86400) GROUP BY adv_id ORDER BY adv_id";
        $last_30_day = $wpdb->get_results($sql);

        $sql = "SELECT count(id) as 'count', date(time) as 'date', adv_id FROM wp_mocean_click GROUP BY adv_id";
        $last = $wpdb->get_results($sql);
    }
    $options = get_option('mocean_widget_options');
    $options = $options['options'];

    $stats = array();

    foreach ($last as $lrow) {
        $row = new stdClass();
        $row->name = $options[$lrow->adv_id]['title'];
        if (strlen($row->name) == 0) {
            $row->name = 'Adv - ' . $lrow->adv_id;
        }

        $row->count = $lrow->count;
        foreach ($last_1_day as $l1day) {
            if ($l1day->adv_id == $lrow->adv_id) {
                $row->l1count = $l1day->count;
                break;
            }
        }

        if (!isset($row->l1count))
            $row->l1count = 0;

        foreach ($last_7_day as $l7day) {
            if ($l7day->adv_id == $lrow->adv_id) {
                $row->l7count = $l7day->count;
                break;
            }
        }

        if (!isset($row->l7count))
            $row->l7count = 0;

        foreach ($last_30_day as $l30day) {
            if ($l30day->adv_id == $lrow->adv_id) {
                $row->l30count = $l30day->count;
                break;
            }
        }

        if (!isset($row->l30count))
            $row->l30count = 0;

        $stats[] = $row;
    }

    wp_enqueue_style('visualize',plugins_url('/css/visualize.css', __FILE__));
    wp_enqueue_script('excanvas', plugins_url('/js/excanvas.js', __FILE__), array('scriptaculous'));
    wp_enqueue_script('visualize.jQuery', plugins_url('/js/visualize.jQuery.js', __FILE__), array('scriptaculous'));
    
    include_once 'views/mocean_stats.php';
}

/**
 * 
 * creates mocean errors page in admin panel
 */
function mocean_errors() {
    global $wpdb;

    if ($_GET['reset'] == 'true') {
        $sql = "DELETE FROM wp_mocean_error";
        $wpdb->query($sql);
        $rows = array();
    } else {
        $sql = "SELECT * FROM wp_mocean_error ORDER BY id DESC";
        $rows = $wpdb->get_results($sql);

        $options = get_option('mocean_widget_options');
        $options = $options['options'];
    }

    include_once 'views/mocean_errors.php';
}

/**
 * 
 * creates mocean widget control in admin panel. That is visible in widgets section
 */
function mocean_widget_control($widget_args = 1) {
    global $wpdb;

    global $wp_registered_widgets;
    static $updated = false; // Whether or not we have already updated the data after a POST submit

    if (is_numeric($widget_args))
        $widget_args = array('number' => $widget_args);

    $number = $widget_args['number'];

    // Data should be stored as array:  array(number => data for that instance of the widget, ...)
    $options = get_option('mocean_widget_options');
    if (!is_array($options))
        $options = mocean_widget_default_options();

    // We need to update the data
    if (!$updated && !empty($_POST['sidebar'])) {
        // Tells us what sidebar to put the data in
        $sidebar = (string) $_POST['sidebar'];

        $sidebars_widgets = wp_get_sidebars_widgets();
        if (isset($sidebars_widgets[$sidebar]))
            $this_sidebar = & $sidebars_widgets[$sidebar];
        else
            $this_sidebar = array();

        foreach ($this_sidebar as $_widget_id) {
            if ('widget_moceanadvwidget' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number'])) {
                $widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
                if (!in_array("widget_moceanadvwidget-$widget_number", $_POST['widget-id'])) {
                    // the widget has been removed. "widget_moceanadvwidget-$widget_number" is "{id_base}-{widget_number}
                    unset($options['options'][$widget_number]);

                    $sql = "DELETE FROM wp_mocean_click WHERE adv_id=$widget_number";
                    $wpdb->query($sql);
                    $sql = "DELETE FROM wp_mocean_error WHERE adv_id=$widget_number";
                    $wpdb->query($sql);
                }
            }
        }

        foreach ((array) $_POST['widget-widget_moceanadvwidget'] as $widget_number => $widget_instance) {
            // compile data from $widget_instance
            if (!isset($options['options'][$widget_number]) || key($_POST['widget-widget_moceanadvwidget']) == $widget_number) {
                $newoptions['zone'] = strip_tags(stripslashes($widget_instance['zone']));
                $newoptions['title'] = strip_tags(stripslashes($widget_instance['title']));
                $newoptions['type'] = strip_tags(stripslashes($widget_instance['type']));
                $newoptions['test'] = strip_tags(stripslashes($widget_instance['test']));
                $newoptions['keywords'] = strip_tags(stripslashes($widget_instance['keywords']));
                $newoptions['campaigns'] = strip_tags(stripslashes($widget_instance['campaigns']));
                $newoptions['min_size_x'] = strip_tags(stripslashes($widget_instance['min_size_x']));
                $newoptions['size_x'] = strip_tags(stripslashes($widget_instance['size_x']));
                $newoptions['min_size_y'] = strip_tags(stripslashes($widget_instance['min_size_y']));
                $newoptions['size_y'] = strip_tags(stripslashes($widget_instance['size_y']));
                $newoptions['zonecount'] = strip_tags(stripslashes($widget_instance['zonecount']));

                $options['options'][$widget_number] = $newoptions;
            }
        }

        update_option('mocean_widget_options', $options);

        $updated = true; // So that we don't go through this more than once
    }

    if ($number == -1) {
        $number = '%i%';
        $values = array('title' => '', 'type' => 3, 'test' => 1, 'zonecount' => 0);
    } else {
        $values = $options['options'][$number];
    }

    
    $title = htmlspecialchars($values['title'], ENT_QUOTES);
    $zone = htmlspecialchars($values['zone'], ENT_QUOTES);
    $type = htmlspecialchars($values['type'], ENT_QUOTES);
    $test = htmlspecialchars($values['test'], ENT_QUOTES);
    $keywords = htmlspecialchars($values['keywords'], ENT_QUOTES);
    $campaings = htmlspecialchars($values['campaigns'], ENT_QUOTES);
    $min_size_x = htmlspecialchars($values['min_size_x'], ENT_QUOTES);
    $size_x = htmlspecialchars($values['size_x'], ENT_QUOTES);
    $min_size_y = htmlspecialchars($values['min_size_y'], ENT_QUOTES);
    $size_y = htmlspecialchars($values['size_y'], ENT_QUOTES);

    include_once 'views/mocean_widget_control.php';
}

/**
 * returns defaults options for mocean widgets 
 * @return array
 */
function mocean_widget_default_options() {
    global $mocean_version;

    return array('version' => $mocean_version,
        'options' => array(0 => array('title' => '', 'min_size_x' => '', 'size_x' => '', 'min_size_y' => '', 'size_y' => '', 'zonecount' => 0)));
}

/**
 * 
 * tracks advertisement clicking
 */
function mocean_track_click() {
    global $wpdb;

    $wpdb->insert('wp_mocean_click', array(
        'ip' => $_SERVER['REMOTE_ADDR'],
        'adv_id' => $_POST['adv_id']), array('%s', '%d')
    );

    echo "";
    die();
}

/**
 * 
 * tracks error clicking
 */
function mocean_track_error() {
    global $wpdb;

    $wpdb->insert('wp_mocean_error', array(
        'error' => $_POST['error'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'adv_id' => $_POST['adv_id']), array('%s', '%s', '%d')
    );

    echo "";
    die();
}

/**
 * 
 * initializes mocean plugin
 */
function mocean_init() {

    if (!function_exists('register_sidebar_widget') || !function_exists('register_widget_control'))
        return;

    $options = get_option('mocean_widget_options');
    if (!is_array($options)) {
        $options = mocean_widget_default_options();
    }

    $widget_ops = array('classname' => 'widget_moceanadvwidget', 'description' => __('Widget to serve Mocean banners from sidebars', 'moceanadvwidget'));
    $control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'widget_moceanadvwidget');
    $name = __('Mocean Advertisement');
    $values = $options['options'];
    $registered = false;
    foreach (array_keys($values) as $o) {
        // Old widgets can have null values for some reason
        if (!isset($values[$o]['zonecount']))
            continue;

        // $id should look like {$id_base}-{$o}
        $id = "widget_moceanadvwidget-$o"; // Never never never translate an id
        $registered = true;
        wp_register_sidebar_widget($id, $name, 'mocean_widget', $widget_ops, array('number' => $o));
        if (is_admin()) {
            wp_register_widget_control($id, $name, 'mocean_widget_control', $control_ops, array('number' => $o));
        }
    }

    // If there are none, we register the widget's existance with a generic template
    if (!$registered) {
        wp_register_sidebar_widget('widget_moceanadvwidget-1', $name, 'mocean_widget', $widget_ops, array('number' => -1));
        if (is_admin()) {
            wp_register_widget_control('widget_moceanadvwidget-1', $name, 'mocean_widget_control', $control_ops, array('number' => -1));
        }
    }
    if (is_admin()) {
        add_action('admin_menu', 'mocean_admin_menu');
    }

    add_action('wp_head', 'mocean_head');

    add_action('wp_ajax_trackClick', 'mocean_track_click');
    add_action('wp_ajax_nopriv_trackClick', 'mocean_track_click');
    add_action('wp_ajax_trackError', 'mocean_track_error');
    add_action('wp_ajax_nopriv_trackError', 'mocean_track_error');
}


/**
 * installs mocean plugin
 */
function mocean_install() {
    global $wpdb;
    global $mocean_db_version;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $sql = "CREATE TABLE wp_mocean_click (
  id int(11) NOT NULL AUTO_INCREMENT,
  adv_id int(11) NOT NULL,
  ip varchar(15) NOT NULL,
  time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id));";
    dbDelta($sql);


    $sql = "CREATE TABLE wp_mocean_error (
  id int(11) NOT NULL AUTO_INCREMENT,
  error varchar(45) NOT NULL,
  adv_id int(11) NOT NULL,
  ip varchar(15) NOT NULL,
  time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id));";
    dbDelta($sql);

    add_option("mocean_version", $mocean_version);
    add_option("mocean_db_version", $mocean_db_version);
}

add_action('plugins_loaded', 'mocean_init');
register_activation_hook(__FILE__, 'mocean_install');
?>
