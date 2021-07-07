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

$table = TABLE_PREFIX ."mod_timebased_picker";
$database->query("DROP TABLE IF EXISTS ".$table );

