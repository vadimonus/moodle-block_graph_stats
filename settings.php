<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file is used to setting the block allover the site
 *
 * @package    block
 * @subpackage graph_stats
 * @copyright  2011 Éric Bugnet with help of Jean Fruitet
 * @copyright  2014 Wesley Ellis, Code Improvements.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$settings->add(new admin_setting_configtext(
            'daysnb',
            get_string('daysnb', 'block_graph_stats'),
            get_string('daysnb_help', 'block_graph_stats'),
            '30',
            PARAM_INT
        ));

$settings->add(new admin_setting_configtext(
            'graphheight',
            get_string('graphheight', 'block_graph_stats'),
            get_string('graphheight_help', 'block_graph_stats'),
            '200',
            PARAM_INT
        ));

$style = array(
    'area' => get_string('area', 'block_graph_stats'),
    'classic' => get_string('classic', 'block_graph_stats')
);

$settings->add(new admin_setting_configselect(
            'style',
            get_string('style', 'block_graph_stats'),
            get_string('style_help', 'block_graph_stats'),
            'area',
            $style
        ));

$settings->add(new admin_setting_configcheckbox(
            'multi',
            get_string('multi', 'block_graph_stats'),
            get_string('multi_help', 'block_graph_stats'),
            '1'
        ));

$name = 'outer_background';
$title = get_string('outer_background', 'block_graph_stats');
$description = get_string('outer_background_help', 'block_graph_stats');
$default = '#ffffff';
$previewconfig = null;
$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

$name = 'border_width';
$title = get_string('border_width', 'block_graph_stats');
$description = get_string('border_width_help', 'block_graph_stats');
$default = '0';
$settings->add(new admin_setting_configtext($name, $title, $description, $default));

$name = 'inner_border';
$title = get_string('inner_border', 'block_graph_stats');
$description = get_string('inner_border_help', 'block_graph_stats');
$default = '#C0C0C0';
$previewconfig = null;
$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

$name = 'axis_colour';
$title = get_string('axis_colour', 'block_graph_stats');
$description = get_string('axis_colour_help', 'block_graph_stats');
$default = '#C0C0C0';
$previewconfig = null;
$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

$name = 'color1';
$title = get_string('color1', 'block_graph_stats');
$description = get_string('color1_help', 'block_graph_stats');
$default = '#0000FF';
$previewconfig = null;
$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

$name = 'color2';
$title = get_string('color2', 'block_graph_stats');
$description = get_string('color2_help', 'block_graph_stats');
$default = '#00FF00';
$previewconfig = null;
$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));