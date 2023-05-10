<?php

/**
 *
 *  @category       modules
 *  @package        timebased_picker ( formerly: jmstv_picker )
 *  @author         Ruud Eisinga, Evaki, Dietrich Roland Pehlke (last)';
 *  @license        http://www.gnu.org/licenses/gpl.html
 *  @requirements   PHP >= 7.3
 *
 */

/**
 *	prevent this file from being accessed directly
 */
if(!defined('WB_PATH'))
{
    header('Location: ../../index.php');
    die();
}

global $s_view;

$database = LEPTON_database::getInstance();
$section_id = LEPTON_core::getGlobal("section_id");

$table_mod = TABLE_PREFIX.'mod_timebased_picker';

$section_info = [];
$database->execute_query(
    "SELECT `target_section_id`,`head_section_id`,`inactive_section_id`,`time_start`,`time_end`,`time_zone`,`weekdays` 
        FROM `".$table_mod."` 
        WHERE `section_id` ='".$section_id."'",
    true,
    $section_info,
    false
);

if (empty($section_info) || ($database->is_error()))
{
	echo $database->get_error();
	return 0;
}

$new_section_id = $section_info['target_section_id'];

$old_timezone = date_default_timezone_get();

date_default_timezone_set( $section_info['time_zone'] );  

$time = date("H");
$weekday = date("w");

$is_active = true;

$allowed_days = explode(",", $section_info['weekdays']);

if (!in_array($weekday, $allowed_days)) {
	
	/**
	 *	Over midnight? Then we take a look for the prev. day ...
	 *	E.g.: section is allowed on Saturday from 23.00 o'clock up to 6.00 o'clock in the 
	 *	next morning - but the sunday is not allowed - we still keep the flag active.
	 *
	 */
    if ($section_info['time_end'] < $section_info['time_start'])
    {
		// over midnight
		if ($weekday == 0)
		{
		    $weekday = 7;
		}
		
		if ((!in_array( --$weekday, $allowed_days)) || ($section_info['time_end'] <= $time)) {
			$is_active = false;
		}		
	} else {
		$is_active = false;
	}
	
} else {
    if ($section_info['time_end'] < $section_info['time_start'])
    {
        if (($time >= $section_info['time_end']) && ($time < $section_info['time_start']))
		{
		    $is_active = false;
		}
	} else {
        if (($time < $section_info['time_start']) || ($time >= $section_info['time_end']))
		{
		    $is_active = false;
		}
	}
}

// require_once __DIR__."/classes/TimebasedPicker.php";

if (!isset($s_view))
{
	$s_view = new \timebased_picker\classes\TimebasedPicker( $database );
}

if (false === $is_active) {
	
	$s_view->print_section( $section_info['inactive_section_id'] );
	
} else {

	$s_view->print_section( $section_info['head_section_id'] );
	$s_view->print_section( $section_info['target_section_id'] );

}

date_default_timezone_set( $old_timezone );

