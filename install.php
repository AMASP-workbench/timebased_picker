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

$table = TABLE_PREFIX ."mod_timebased_picker";
$database->query("DROP TABLE IF EXISTS `$table`");

$database->query("
	CREATE TABLE `$table` (
		`section_id`        INT(11)     NOT NULL DEFAULT '0',
		`page_id`           INT(11)     NOT NULL DEFAULT '0',
		`target_section_id` INT(11)     NOT NULL DEFAULT '0',
		`head_section_id`   INT(11)     NOT NULL DEFAULT '0',
		`inactive_section_id` INT(11)   NOT NULL DEFAULT '0',
		`time_start`        varchar(2)  NOT NULL DEFAULT '23',
		`time_end`          varchar(2)  NOT NULL DEFAULT '06',
		`weekdays`          varchar(64) NOT NULL DEFAULT '1,2,3,4,5,6,0',
 		`time_zone`         varchar(128) NOT NULL DEFAULT 'Europe/Berlin',
		PRIMARY KEY (`section_id`)
	)
");

