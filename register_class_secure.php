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

$files_to_register = array(
	'save.php'
);

LEPTON_secure::getInstance()->accessFiles( $files_to_register );
