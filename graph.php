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

/*
 * This file is used to make the graph
 *
 * @package    block
 * @subpackage graph_stats
 * @copyright  2011 Éric Bugnet with help of Jean Fruitet
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot.'/lib/graphlib.php');
global $CFG, $DB;

// Get parameters.
$courseid = optional_param('course_id', 1, PARAM_INT);
// Number of days in graph.
$daysnb = $CFG->daysnb;
// Color of first graph.
$color1 = $CFG->color1;
// Color of second graph.
$color2 = $CFG->color2;

$days = array();
$logs = array();
$logsmulti = array();

// Let's get the datas.
$a = 0;

if ($courseid > 1) {
    for ($i = $daysnb; $i > -1; $i--) { // Days count.
        $params = array(
            'time1' => mktime(0, 0, 0, date("m") , date("d") - $i, date("Y")),
            'time2' => mktime(0, 0, 0, date("m") , date("d") - ($i - 1), date("Y")),
            'courseid' => $courseid );
        $sql = "SELECT COUNT(DISTINCT(userid)) as countid FROM {log}
                WHERE time > :time1 AND time < :time2 AND action = 'view' AND course = :courseid";
                $countgraphmulti = $DB->get_record_sql($sql, $params);
        $days[$a] = '';
                $logsmulti[$a] = $countgraphmulti->countid;
                $a = $a + 1;
    }
} else {
    for ($i = $daysnb; $i > -1; $i--) { // Days count.
        $params = array(
            'time1' => mktime(0, 0, 0, date("m") , date("d") - $i, date("Y")),
            'time2' => mktime(0, 0, 0, date("m") , date("d") - ($i - 1), date("Y")),
            'courseid' => $courseid );
        $sql = "SELECT COUNT(DISTINCT(userid)) as countid FROM {log} WHERE time > :time1 AND time < :time2 AND action = 'login'";
                $countgraph = $DB->get_record_sql($sql, $params);
        $days[$a] = '';
        $logs[$a] = $countgraph->countid;
        if ($CFG->multi == 1) {
            $params = array(
                'time1' => mktime(0, 0, 0, date("m") , date("d") - $i, date("Y")),
                'time2' => mktime(0, 0, 0, date("m") , date("d") - ($i - 1), date("Y")),
                'courseid' => $courseid );
            $sql = "SELECT COUNT(userid) as countid FROM {log} WHERE time > :time1 AND time < :time2 AND action = 'login'";
                        $countgraphmulti = $DB->get_record_sql($sql, $params);
                        $logsmulti[$a] = $countgraphmulti->countid;
        }
        $a = $a + 1;
    }
}

// Draw Graph.
$graph = new graph($CFG->graphwidth , $CFG->graphheight);
$graph->parameter['title'] = false;
$graph->x_data = $days;
$graph->y_data['logs'] = $logs;
$graph->y_data['logsmulti'] = $logsmulti;
if ($courseid > 1) {
        $graph->y_order = array('logsmulti');
} else {
        $graph->y_order = array('logsmulti', 'logs');
}
if ($CFG->style == 'area') {
    $graph->y_format['logsmulti'] = array('colour' => $color1, 'area' => 'fill');
    $graph->y_format['logs'] = array('colour' => $color2, 'area' => 'fill');
} else {
    $graph->y_format['logsmulti'] = array('colour' => $color1, 'bar' => 'fill', 'bar_size' => 0.6);
    $graph->y_format['logs'] = array('colour' => $color2, 'line' => 'line');
}
$graph->parameter['bar_spacing'] = 0;
$graph->parameter['y_label_left'] = '';
$graph->parameter['label_size'] = '1';
$graph->parameter['x_axis_angle'] = 90;
$graph->parameter['x_label_angle'] = 0;
$graph->parameter['tick_length'] = 0;
$graph->parameter['outer_background'] = $CFG->outer_background;
$graph->parameter['inner_background'] = $CFG->inner_background;
$graph->parameter['inner_border'] = $CFG->inner_border;
$graph->parameter['axis_colour'] = $CFG->axis_colour;
$graph->parameter['shadow'] = 'none';
$graph->draw_stack();