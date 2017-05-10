  var cssEl = document.createElement('style');
    document.documentElement.firstElementChild.appendChild(cssEl);

    function setPxPerRem(){
        var dpr = 1;
        //把viewport分成10份的rem，html标签的font-size设置为1rem的大小;
        var pxPerRem = document.documentElement.clientWidth * dpr / 10;
        cssEl.innerHTML = 'html{font-size:' + pxPerRem + 'px!important;}';
    }
    setPxPerRem();


var slideLis = document.getElementById("slideEles").getElementsByTagName("li");
var slideFlags = document.getElementById("slideFlags").getElementsByTagName("li");
var slideNoFlag = 0;
function slide(){
	slideNoFlag++;
	slideNoFlag = slideNoFlag%slideLis.length;

	for(var i=0;i<slideLis.length;i++){
		slideLis[i].style.display = "none";
		slideFlags[i].style.backgroundImage = "url(./images/circle-off.png)";
	}
	slideLis[slideNoFlag].style.display = "block";
	slideFlags[slideNoFlag].style.backgroundImage = "url(./images/circle.png)";
}

function switchClass(parentId){
	var switchEles = document.getElementById(parentId).getElementsByTagName("input");			
	for(var i=0;i<switchEles.length;i++){			
		switchEles[i].className = "un-selected-option";
	}

	var object=window.event.srcElement;
	object.className = "selected-option";
}

function exeSwitchClass(){
	
	var parentIds = new Array("page_guige");

	for(var i=0;i<parentIds.length;i++){

		var childBtns = document.getElementById(parentIds[i]).getElementsByTagName("input");
		for(var j=0;j<childBtns.length;j++){

			childBtns[j].onclick = (function(arg){
			
				return function() {switchClass(parentIds[arg])};
			})(i);
		}
	}
}


function addPageControl(flag){
	var page = document.getElementById("page_add_shopcart");
	var btn = document.getElementById("page-next-act-btn-add");
	var btnNow = document.getElementById("page-next-act-btn-add-now");
	if(flag){
		page.style.display = "block";
		btn.style.display = "block";
		btnNow.style.display = "none";
	}
	else{
		page.style.display = "none";
		btn.style.display = "none";
	}
}

function buyPageControl(flag){
	var page = document.getElementById("page_add_shopcart");
	var btn = document.getElementById("page-next-act-btn-add-now");
	var btnAdd = document.getElementById("page-next-act-btn-add");
	if(flag){
		page.style.display = "block";
		btn.style.display = "block";
		btnAdd.style.display = "none";
	}
	else{
		page.style.display = "none";
		btn.style.display = "none";
	}
}
function replaceNotNumber(){
	var this_obj = document.getElementById("page_text_num");
	var pattern = /[^0-9]/g;
	if(pattern.test(this_obj.value)){
		this_obj.value = 1;
	}
}
function changeNumber(flag){
	var numObj = document.getElementById("page_text_num");
	if(flag){
		numObj.value++;
	}
	else{
		if(numObj.value>1){
			numObj.value--;
		}			
	}
}

function wkf_reminder(){
    var wkf_kf = document.getElementById("wkf_kf");
    var click_count = 0;
    wkf_kf.onclick = function(){
        var wkf_block_wrap = document.getElementById("wkf_block_wrap");
        var wkf_img = document.getElementById("wkf_img");
        var wkf_text = document.getElementById("wkf_text");
        var body = document.getElementsByTagName("body")[0];
        wkf_text.innerHTML = "竟然被你发现了这里，这里还没有开发呢，等我开发了再来哈(*￣3￣)╭";  
        wkf_img.src = "images/wkf_mm.jpg";
        wkf_block_wrap.style.display = "block";
        body.setAttribute("class","hidden");
        setTimeout(function(){
            wkf_text.innerHTML = "o(*////▽////*)q戳我一下";        
        },3000);

        wkf_img.onclick = function(){            
            click_count++;
            switch (click_count){
                case 1: wkf_text.innerHTML = "开心(′▽`〃)再戳一下";  
                        wkf_img.src = "images/wkf_mm1.jpg";
                        break;
                case 2:
                        wkf_text.innerHTML = "φ(≧ω≦*)♪ 再戳一下";  
                        wkf_img.src = "images/wkf_mm2.jpg";
                        break;
                case 3:
                        wkf_text.innerHTML = "o(￣ε￣*) 最后一下!";  
                        wkf_img.src = "images/wkf_mm3.jpg";
                        break;
                case 4:
                        wkf_text.innerHTML = "T^T  再见";  
                        wkf_img.src = "images/wkf_mm4.jpg";
                        setTimeout(function(){
                            wkf_block_wrap.style.display = "none";
                            body.setAttribute("class","auto");
                        },2000);
                        break;
                default:break;                       
            }            
           
        }
    }
}

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

//Ajax加入购物车之后的回调函数

function AddCartCallServer(xmlHttp){

	var bookId = document.getElementById("bookId").value;
	var bookNum = document.getElementById("page_text_num").value;

	if(bookId == null||bookId =="")
		return ;
	var url = "./lib/operate_db.php?action=addShopcart&bookId="+escape(bookId)+"&bookNum="+escape(bookNum);

	// Open a connection to the server
	xmlHttp.open("GET",url,true);

	// Setup a function for the server to run when it's done
	xmlHttp.onreadystatechange =function(){
		console.log(xmlHttp.responseText);
		addPageControl(0);
}

  	// Send the request
  	xmlHttp.send(null);
  	
}
//Ajax立即购买之后的回调函数
function BuyCartCallServer(xmlHttp){

	var bookId = document.getElementById("bookId").value;
	var bookNum = document.getElementById("page_text_num").value;

	if(bookId == null||bookId =="")
		return ;
	var url = "./lib/operate_db.php?action=addShopcart&bookId="+escape(bookId)+"&bookNum="+escape(bookNum);
//	var url = "./lib/operate_db.php";

	// Open a connection to the server
	xmlHttp.open("GET",url,true);

	// Setup a function for the server to run when it's done
	xmlHttp.onreadystatechange =function(){
		addPageControl(0);
		location.href = "shopcart.php";
	}


  	// Send the request
  	xmlHttp.send(null);
  	
}
window.onload = function(){
	setInterval(slide,3000);
	exeSwitchClass();
	var closePage = document.getElementById("page_close_btn");
	var fixedAddShopcart = document.getElementById("fixed_add_shopcart");
	var fixedAddNow = document.getElementById("fixed_add_now");
	var pageTextNum = document.getElementById("page_text_num");
	var pageNumBtnSub = document.getElementById("page_num_btn_sub");
	var pageNumBtnAdd = document.getElementById("page_num_btn_add");
	closePage.onclick = function(){
		addPageControl(0);
		buyPageControl(0)
	}
	fixedAddShopcart.onclick = function(){
		addPageControl(1);
	}
	fixedAddNow.onclick = function(){
		buyPageControl(1);
	}
	pageTextNum.onblur = function(){
			replaceNotNumber();
	}
	pageNumBtnSub.onclick = function(){
		changeNumber(0);
	}
	pageNumBtnAdd.onclick = function(){
		changeNumber(1);
	}
	
	
	//点击加入购物车按钮，提交数据并隐藏遮罩层
	
	var addCartBtn = document.getElementById("addCart");
	var buyCartBtn = document.getElementById("buyCart");
	addCartBtn.onclick = function(){
		var xmlHttp = createxmlHttp();
		AddCartCallServer(xmlHttp);
	}
	buyCartBtn.onclick = function(){
		var xmlHttp = createxmlHttp();		
		BuyCartCallServer(xmlHttp);
	}

	wkf_reminder();
}