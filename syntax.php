<?php 
/**
 * DokuWiki Plugin headernofloat (Syntax Component) 
 * 
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_headernofloat extends DokuWiki_Syntax_Plugin {

		var $levels = array( '######'=>1,
                         '#####'=>2,
                         '####'=>3,
                         '###'=>4,
                         '##'=>5);
		
		function getPType() {return 'normal';	}
        // header specific
        function getType() { return 'substition'; }
 
        // headings shouldn't be parsed..
        function accepts($mode) { return false; }
 
        function connectTo( $mode ) {
                $this->Lexer->addSpecialPattern( '^[ \t]*#{2,6}[^\n]+#{2,6}[ \t]*(?=\n)', $mode, 'plugin_headernofloat' );
        }
 
        // Doku_Parser_Mode 60
        // header (numbered headers) 45
        function getSort() { return 59; }
 
        function handle( $match, $state, $pos, &$handler )
        {
			// get level and title
			$title = trim($match);
			$level = 7 - strspn($title,'#');
			if($level < 1) $level = 1;
			$title = trim($title,'#');
			$title = trim($title);

			$opts["sectionstatus"] = false;
			if ($handler->status['section']) {
				$opts["sectionstatus"] = true;
				
			}
			$handler->status['section'] = true;
			
			$opts["text"] = $title;
			$opts["level"] = $level;
			$opts["pos"] = $pos;
			return $opts;
        }
 
        function render( $mode, &$renderer, $data )
        {			
			$title = $text = $data["text"];
			$level= $data["level"];
			$pos = $data["pos"];
			$sectionstatus = $data["sectionstatus"];
			if($mode == 'metadata')return false;
			if($sectionstatus == true) $renderer->section_close();
			
			if($mode=="xhtml") {
				$renderer->doc .= ("<div class='nofloat'>");
				$renderer->header($title, $level, $pos);
				$renderer->doc .=("</div>");
			} else if($mode=='odt'){
				$renderer->header($title, $level, $pos);
			}
			else {
				$renderer->doc .=$renderer->_xmlEntities($title);
			}
			$renderer->section_open($level);
	
			return true;
        }
 
}
