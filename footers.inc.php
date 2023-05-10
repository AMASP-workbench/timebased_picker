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

$mod_footers = timebased_picker\classes\TimebasedPicker::getInstance()->resolveFrontenendFooterFiles();

$mod_footers["frontend"]["js"][] = "modules/timebased_picker/js/additional.js";
