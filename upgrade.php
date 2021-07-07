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

$query = "show fields from `".TABLE_PREFIX."mod_timebased_picker`";

$result = $database->query ( $query );

if ($database->is_error() ) {

	$admin->print_error( $database->get_error() );

} else {
	
	$alter = 1;
	
	while ( $data = $result->fetchRow( MYSQLI_ASSOC ) )
	{
		if ($data['Field'] == "weekdays")
		{
			$alter = 0;
			break;
		}
	}

	if ( $alter != 0 ) {

		$thisQuery = "ALTER TABLE `".TABLE_PREFIX."mod_timebased_picker` ADD `weekdays` varchar(64) NOT NULL DEFAULT '1,2,3,4,5,6,0'";
		$r = $database->query($thisQuery);

		if ( $database->is_error() ) {

			$admin->print_error( $database->get_error() );

		} else {

			$admin->print_success( "Update Table for modul 'Timebased Picker' with success." );
		}
	}
}
