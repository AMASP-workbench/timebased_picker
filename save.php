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

if(!defined("LEPTON_SEC_PATH"))
{
    define("LEPTON_SEC_PATH", "/framework/class.secure.php");
}

if (defined('LEPTON_PATH')) {    
    include LEPTON_PATH.LEPTON_SEC_PATH; 
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while (($level < 10) && (!file_exists($root.LEPTON_SEC_PATH))) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root.LEPTON_SEC_PATH)) { 
        include $root.LEPTON_SEC_PATH; 
    } else {
        trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
    }
}

/**
 *  Include LEPTON admin wrapper script
 *  Tells script to update when this page was last updated
 */
$update_when_modified = true;
require(LEPTON_PATH.'/modules/admin.php');

if ( false === $admin->get_permission('start') ) 
{
    header('Location: ../../index.php');
    die();
}

// [1] prepare
$_POST['target_section_id']     = $_POST['target_section_id_'.$section_id] ?? 0;
$_POST['head_section_id']       = $_POST['head_section_id_'.$section_id] ?? 0;
$_POST['inactive_section_id']   = $_POST['inactive_section_id_'.$section_id] ?? 0;
$_POST['weekdays'] = (isset($_POST['weekdays']) ? implode(",", $_POST['weekdays']) : "");

// [2] set up the "input" test array
$aLookUpKeys = array(
    'target_section_id'     => ["type" => "int",    "default" => 0],
    'head_section_id'       => ["type" => "int",    "default" => 0],
    'inactive_section_id'   => ["type" => "int",    "default" => 0],
    'weekdays'              => ["type" => "string", "default" => ""],
    'time_start'            => ["type" => "string", "default" => 0],
    'time_end'              => ["type" => "string", "default" => 0],
    'time_zone'             => ["type" => "string", "default" => DEFAULT_TIMEZONE_STRING]
);

// [3] - Test the "input"
$aPostedFields = LEPTON_request::getInstance()->testPostValues( $aLookUpKeys );

// [4] -  Get db-instance and execute update
$database = LEPTON_database::getinstance();

$database->build_and_execute(
    "update",
    TABLE_PREFIX.'mod_timebased_picker',
    $aPostedFields,
    "`section_id`=".$section_id
);

// [5] Check if there is a database error, otherwise say successful
if($database->is_error()) {
    $admin->print_error($database->get_error(), $js_back);
} else {
    $admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}
