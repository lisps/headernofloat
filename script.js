/**
 * DokuWiki Plugin headernofloat (JavaScript Component) 
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  lisps
 */

jQuery(function(){
e = jQuery('div.nofloat');

if(e.length==0) return;

for (ii = 0; ii < e.length;ii++) {
	ediv = e[ii].childNodes;
	
	for(kk = 0; kk<ediv.length; kk++) {
		if( ediv[kk].tagName=='H1' ||
			ediv[kk].tagName=='H2' ||
			ediv[kk].tagName=='H3' ||
			ediv[kk].tagName=='H4' ||
			ediv[kk].tagName=='H5') {

			e[ii].className += " " + ediv[kk].className;
			
		}
		if(ediv[kk].tagName == "DIV") {
			page= jQuery('div.page, div.pagepage');
			page[0].insertBefore(ediv[kk],e[ii]);
		}
	}
	
}

});