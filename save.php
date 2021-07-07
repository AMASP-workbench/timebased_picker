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
 
require_once('../../config.php');

/**
 *	Include WB admin wrapper script
 *	Tells script to update when this page was last updated
 */
$update_when_modified = true;
require(WB_PATH.'/modules/admin.php');

if ( false === $admin->get_permission('start') ) 
{
    header('Location: ../../index.php');
    die();
}

/**
 *	Update fields
 */
if(isset($_POST['target_section_id_'.$section_id])) {

	$table_mod = TABLE_PREFIX.'mod_timebased_picker';
	
	$fields = array(
		'target_section_id'		=> $admin->add_slashes($_POST['target_section_id_'.$section_id]),
		'head_section_id'		=> $admin->add_slashes($_POST['head_section_id_'.$section_id]),
		'inactive_section_id'	=> $admin->add_slashes($_POST['inactive_section_id_'.$section_id]),
		'weekdays'	=> (isset($_POST['weekdays'])) ? implode(",", $_POST['weekdays'] ) : "",
		'time_start'		=> $admin->add_slashes($_POST['time_start']),
		'time_end' 			=> $admin->add_slashes($_POST['time_end']),
		'time_zone'			=> $admin->add_slashes($_POST['time_zone'])
	);
	
	$query = "UPDATE `".$table_mod."` SET ";
	foreach($fields as $key => $value)
	{
	    $query .= "`".$key."`='".$value."',";
	}
	$query = substr( $query, 0, -1)." WHERE section_id =".$section_id;
	
	$database->query( $query );
}

/**
 *	Check if there is a database error, otherwise say successful
 */
if($database->is_error()) {
	$admin->print_error($database->get_error(), $js_back);
} else {
	$admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

/**
*	Print admin footer
*/
$admin->print_footer();
