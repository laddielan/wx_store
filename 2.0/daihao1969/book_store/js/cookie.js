//检验cookie是否存在
function checkCookie(){
	
}


//设置cookie
function setCookie(c_name, value, expiredays){

	var exdate = new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie = c_name + "=" +escape(value) +";expires="+exdate.toGMTString();
  document.cookie = "name=lan;expires="+exdate.toGMTString();
 
}

//获取cookie
function getCookie(c_name)
{

	if (document.cookie.length>0){
  		var c_start=document.cookie.indexOf(c_name + "=");
  		if (c_start!=-1){ 
   			c_start=c_start + c_name.length+1; 
    		var c_end=document.cookie.indexOf(";",c_start);
	    	if (c_end==-1) {
	    		c_end=document.cookie.length;
	    	}
    		return unescape(document.cookie.substring(c_start,c_end));
    	} 
    	else{
    		console.log("c_start=-1");
    	}
  }
  else{
  	console.log("No cookie~");
  }
	return "";
}

//删除cookie
function delCookie(name)
{
  var exp = new Date();
  exp.setTime(exp.getTime() - 1);
  var cval=getCookie(name);
  if(cval!=null){
    document.cookie= name + "="+cval+";expires="+exp.toGMTString();
  }
  
}


