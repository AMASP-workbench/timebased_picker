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
 *  prevent this file from being accessed directly
 */
if(!defined('LEPTON_PATH'))
{
    header('Location: ../../index.php');
    die();
}

if (!function_exists("build_pagelist2")) {
    function build_pagelist2( $parent, $this_page, &$links)
    {
        $table_p = TABLE_PREFIX."pages";
        $table_s = TABLE_PREFIX."sections";
        
        $query_section_id = [];
        LEPTON_database::getInstance()->execute_query(
            "SELECT s.section_id, s.module, s.name, p.link, p.page_title, p.page_id, p.level 
                FROM ".$table_s." s 
                JOIN ".$table_p." p 
                ON (s.page_id = p.page_id) 
                WHERE p.parent = ".$parent." 
                ORDER BY p.position, s.position",
            true,
            $query_section_id,
            true
        );

        foreach($query_section_id as $res)
        {
            if ($res['page_id'] != $this_page)
            {
                $links[$res['section_id']] = $res['section_id'].'|'.str_repeat("  -  ",$res['level']).$res['page_title'].'    -    section: '.$res['module']." :: ".$res['name'];
            } else {
                $links[$res['section_id']] = '|'.str_repeat("  -  ",$res['level']).$res['page_title'].'    -    section:'.$res['module']." :: ".$res['name'];
            }
            
            build_pagelist2( $res['page_id'], $this_page, $links);
        }

    }
}
