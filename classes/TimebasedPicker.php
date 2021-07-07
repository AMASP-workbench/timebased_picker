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

namespace timebased_picker\classes;

class TimebasedPicker extends \LEPTON_abstract
{

    static public $instance = NULL;
    
    public function initialize()
    {
        // required by parent
    }	
	
	public function print_section( &$aSection_id=0 )
	{
		
		global $section_id;
		
		global $database;
		global $wb;
		global $TEXT;
		global $HEADING;
		
		\LEPTON_database::getinstance()->execute_query(
		    "SELECT `section_id`,`module` 
		        FROM `".TABLE_PREFIX."sections` 
		        WHERE `section_id` = '".$aSection_id."'",
		    true,
		    $section,
		    false
		);

        $sBasePath = LEPTON_PATH.'/modules/';
        
		if(!empty($section))
		{
			$old_section_id = $section_id;
			$section_id = $section['section_id']; 
			$module = $section['module'];
			
			/**
			 *	Looking for frontend.css
			 *
			 */
			$temp_path = $sBasePath.$module.'/frontend.css';
			if (file_exists($temp_path)) {
				echo "\n\n<link rel=\"stylesheet\" type=\"text/css\" href='".$sBasePath.$module."/frontend.css' />\n";
			}
			
			/**
			 *	Looking for frontend.js
			 *
			 */
			$temp_path = $sBasePath.$module.'/frontend.js';
			if (file_exists($temp_path)) {
				echo "\n<script src=\"".$sBasePath.$module."/frontend.js\" type=\"text/javascript\"></script>\n";
			}
	
			require $sBasePath.$module.'/view.php';

			$section_id = $old_section_id;
		}
	}

}
