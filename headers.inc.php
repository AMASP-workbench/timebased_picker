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

$mod_headers = timebased_picker\classes\TimebasedPicker::getInstance()->resolveFrontenendHeaderFiles();

$mod_headers["frontend"]["css"][] = [
    "media" => "all",
    "file"  => "modules/timebased_picker/css/additional.css"
];
