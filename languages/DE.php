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

$module_description = 'Zeitbasierte Sektionsauswahl, z.B. für Sendezeit nach JMStV.';

$MOD_TIMEBASED_PICKER = array(
    'SECTION_NOT_FOUND'     => "Sektion mit der Id %s nicht gefunden!",
    'QUERY_ERROR'           => "<p>Es gab einen Fehler mit dem mySQl query:<br />'%s'</p>",
    'ACTIVE_HEAD_SECTION'   => "Aktiv: Titel Sektion:",
    'INACTIVE-SECTION'      => "Inaktiv: zeige Sektion:",
    'TIME_START'            => "Aktiv von:",
    'TIME_END'              => "Aktiv bis:",
    'TIME_ZONE'             => "Zeitzone:",
    'TIME_HOUR_NAME'        => "Uhr",
    'WEEKDAYS'              => "Wochentage",
    'WEEKDAYS_ABBR'     => [
        '1' => "Mo",
        '2' => "Di",
        '3' => "Mi",
        '4' => "Do",
        '5' => "Fr",
        '6' => "Sa",
        '0' => "So"
        ]
);
