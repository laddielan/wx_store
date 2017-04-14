var cssEl = document.createElement('style');
document.documentElement.firstElementChild.appendChild(cssEl);

function setPxPerRem(){
    var dpr = 1;
    //把viewport分成10份的rem，html标签的font-size设置为1rem的大小;
    var pxPerRem = document.documentElement.clientWidth * dpr / 10;
    cssEl.innerHTML = 'html{font-size:' + pxPerRem + 'px!important;}';
}
    
setPxPerRem();
//创建Ajax对象
function createxmlHttp(){
	/* Create a new XMLHttpRequest object to talk to the Web server */
	var xmlHttp = false;
	/*@cc_on @*/
	/*@if (@_jscript_version >= 5)
	try {
	  xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
	try {
	    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  } catch (e2) {
	    xmlHttp = false;
	  }
	}
	@end @*/

	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
  		xmlHttp = new XMLHttpRequest();
	}

	return xmlHttp;
}