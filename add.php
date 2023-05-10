<?php

/**
 *
 *  @category       modules
 *  @package        timebased_picker (formerly: jmstv_picker)
 *  @author         Ruud Eisinga, Evaki, Dietrich Roland Pehlke (last)'
 *  @license        http://www.gnu.org/licenses/gpl.html
 *  @requirements   PHP >= 8.0
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

//  L* 6 backward compatibility for WB modules
if (class_exists("lib_comp", true))
{
    lib_comp::init("Timebased_picker");
}

$section_id = LEPTON_core::getGlobal("section_id");
$page_id = LEPTON_core::getGlobal("page_id");
$database = LEPTON_database::getInstance();

$table = TABLE_PREFIX ."mod_timebased_picker";
$database->query("INSERT INTO `".$table."` (`page_id`, `section_id`, `target_section_id`) VALUES ('".$page_id."','".$section_id."', '0')");

