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
    const TABLENAME = TABLE_PREFIX."mod_timebased_picker";
    
    const FRONTEND_HEADERS = [
        'frontend'  => [
            'css' => [],
            'js'  => []
        ]];
        
    const FRONTEND_FOOTERS = [
        'frontend'  => [
            'js'  => []
        ]];
        
    /**
     *  Own instance of this class
     *  @access public
     */
    static public $instance = NULL;
    
    /**
     *  Required by parent class.
     */
    public function initialize()
    {
        // required by parent
    }	
	
	/**
	 *  Makes a "wild" echo output of the given section to the browser.
	 *  
	 *  @param int $aSection_id A valid section id. Pass|Call by reference!
	 *
	 */
	public function print_section( int &$aSection_id=0 )
	{
		
		global $section_id;
		global $page_id;
		
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

    /**
     *  Get the frontend css and js files of the involved modules.
     *
     *  @return array   The complete list for the $mod_header's 
     */
    static function resolveFrontenendHeaderFiles() : array
    {
        global $mod_headers;
        
        $aReturnValues = self::FRONTEND_HEADERS;
        
        if(!defined("PAGE_ID"))
        {
            return $aReturnValues;
        }
        
        $database = \LEPTON_database::getInstance();
        
        $aAllModules = [];
        
        $database->execute_query(
            "SELECT m.`page_id`, m.`section_id`, m.`target_section_id`, m.`head_section_id`, m.`inactive_section_id` 
                FROM `".(self::TABLENAME)."` as m 
                WHERE m.`page_id`=".PAGE_ID,
            true,
            $aAllModules,
            true
        );

        $aLookUpFields = ['target_section_id', 'head_section_id', 'inactive_section_id'];
        
        $aLoaded = [];
        
        foreach($aAllModules as &$ref)
        {
            foreach($aLookUpFields as $iTempPlace)
            {
                if($ref[ $iTempPlace ] == 0)
                {
                    continue;
                } else {
                    $module = $database->get_one("SELECT `module` FROM `".TABLE_PREFIX."sections` where `section_id` = ".$ref[ $iTempPlace ]);
                    
                    if( ( NULL !== $module ) && ( !in_array($module, $aLoaded ) ) )
                    {
                        $aLoaded[] = $module;
                        
                        $sTempPath = LEPTON_PATH."/modules/".$module."/headers.inc.php";
                        if(file_exists( $sTempPath ))
                        {
                            $mod_headers = [];
                            require $sTempPath;
                            
                            if(isset($mod_headers['frontend']['css']))
                            {
                                foreach($mod_headers['frontend']['css'] as $aTemp)
                                {
                                    $aReturnValues['frontend']['css'][] = $aTemp;
                                }
                            }
                            
                            if(isset($mod_headers['frontend']['js']))
                            {
                                foreach($mod_headers['frontend']['js'] as $aTemp)
                                {
                                    $aReturnValues['frontend']['js'][] = $aTemp;
                                }
                            }
                        }
                    }
                }
            }        
        }
        
        return $aReturnValues;
    }
    
    /**
     *  Get the frontend css and js files of the involved modules.
     *
     *  @return array   The complete list for the $mod_footers's 
     */
    static function resolveFrontenendFooterFiles() : array
    {
        global $mod_footers;
        
        $aReturnValues = self::FRONTEND_FOOTERS;
        
        if(!defined("PAGE_ID"))
        {
            return $aReturnValues;
        }
        
        $database = \LEPTON_database::getInstance();
        
        $aAllModules = [];
        
        $database->execute_query(
            "SELECT m.`page_id`, m.`section_id`, m.`target_section_id`, m.`head_section_id`, m.`inactive_section_id` 
                FROM `".(self::TABLENAME)."` as m 
                WHERE m.`page_id`=".PAGE_ID,
            true,
            $aAllModules,
            true
        );

        $aLookUpFields = ['target_section_id', 'head_section_id', 'inactive_section_id'];
        
        $aLoaded = [];
        
        foreach($aAllModules as &$ref)
        {
            foreach($aLookUpFields as $iTempPlace)
            {
                if($ref[ $iTempPlace ] == 0)
                {
                    continue;
                } else {
                    $module = $database->get_one("SELECT `module` FROM `".TABLE_PREFIX."sections` where `section_id` = ".$ref[ $iTempPlace ]);
                    
                    if( ( NULL !== $module ) && ( !in_array($module, $aLoaded ) ) )
                    {
                        $aLoaded[] = $module;
                        
                        $sTempPath = LEPTON_PATH."/modules/".$module."/footers.inc.php";
                        if(file_exists( $sTempPath ))
                        {
                            $mod_footers = [];

                            require $sTempPath;
                            
                            // Keep in mind that there are no css files resolved in footers!
                            
                            if(isset($mod_footers['frontend']['js']))
                            {
                                foreach($mod_footers['frontend']['js'] as $aTemp)
                                {
                                    $aReturnValues['frontend']['js'][] = $aTemp;
                                }
                            }
                        }
                    }
                }
            }        
        }
        
        return $aReturnValues;
    }
}
