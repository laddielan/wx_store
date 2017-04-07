//全局变量
//checkNum, Number, 记录购物车中被选中的条目数
var checkNum = 0;

//DOM操作的一些基本函数

//删除节点
function removeElement(eleNode){
	var parNode = eleNode.parentNode;
	if(parNode){
		parNode.removeChild(eleNode);
	}
}

//防止书籍数量框输入非数字——把非数字去除
function inputFunc(event){
	this_obj = event.target?event.target:window.event.target;
	var pattern = /[^0-9]/g;
	if(pattern.test(this_obj.value)){
		this_obj.value = 1;
	}
}

function addEventNumBtn(){
	var numPars = document.getElementsByClassName("edit-wrap");
	for(var i=0;i<numPars.length;i++){
		var numBtn = numPars[i].getElementsByClassName("page-text-number")[0];
		var ie = !!window.ActiveXObject;
		if(ie){
			numBtn.onpropertychange = inputFunc; 
		}
		else if(window.addEventListener) {
			numBtn.addEventListener("blur",inputFunc,false);
		}
		else if(window.attachEvent){
			numBtn.attachEvent("blur",inputFunc,false);
		}
		
	}
	
}
function setPxPerRem(){
    var cssEl = document.createElement('style');
    document.documentElement.firstElementChild.appendChild(cssEl);
    var dpr = 1;
        //把viewport分成10份的rem，html标签的font-size设置为1rem的大小;
    var pxPerRem = document.documentElement.clientWidth * dpr / 10;
    cssEl.innerHTML = 'html{font-size:' + pxPerRem + 'px!important;}';
}

//从路径找出文件名
function srcToFileName(src){
	var srcarr = src.split("/");
	var filename = srcarr[srcarr.length-1];
	return filename;
}

function updateTotalPrice(){

	var items = document.getElementById("shopcart-content").getElementsByTagName("li");
	var totalPrice = 0;
	for(var i=1;i<items.length;i++){
		var imgsrc = items[i].getElementsByClassName("icon-check-wrap")[0].getElementsByTagName("img")[0].src;
		var imgsrcarr = imgsrc.split("/");
		imgsrc = imgsrcarr[imgsrcarr.length-1];
		if("icon_checked.png" == imgsrc){
			var price = items[i].getElementsByTagName("a")[0].getElementsByClassName("shopcart-price")[0].getElementsByTagName("span")[0].innerHTML;
			var num = items[i].getElementsByTagName("a")[0].getElementsByClassName("shopcart-num")[0].getElementsByTagName("span")[0].innerHTML;
			totalPrice += parseFloat(price)*parseInt(num); 
		}
	}

	var totalSpan = document.getElementsByTagName("footer")[0].getElementsByClassName("shopcart-price")[0].getElementsByTagName("span")[0];

	totalSpan.innerHTML = totalPrice.toFixed(2);
}

function switchBuyBtn(){
	var buybtn = document.getElementById("buy");
	if(checkNum>0){
		buybtn.value = "结算("+checkNum+")";
		buybtn.style.background= "#F66";
		buybtn.style.color = "white";
		buybtn.disabled = "";
	}
	else{
		buybtn.value = "结算";
		buybtn.style.background= "#ccc";
		buybtn.style.color = "black";
		buybtn.disabled = "disabled";
	}
}
function switchCheck(){

	var items = document.getElementById("shopcart-content").getElementsByTagName("li");

	//给各项书籍的选中按钮加点击事件
	for(var i=1;i<items.length;i++){
		var checkDiv = items[i].getElementsByTagName("div");
		checkDiv[0].onclick = function(){
			var img = this.getElementsByTagName("img");
			var imgsrc = srcToFileName(img[0].src);
			if(imgsrc == "icon_to_check.png"){
				img[0].src = "images/icon_checked.png";
				checkNum++;
				switchBuyBtn();
			}
			else{
				img[0].src = "images/icon_to_check.png";
				var checkAllDiv = items[0].getElementsByTagName("div")[0].getElementsByTagName("img")[0];
				checkAllDiv.src = "images/icon_to_check.png";
				checkNum--;
				switchBuyBtn();
			}
			updateTotalPrice();
		}
	}

	var checkAllDiv = items[0].getElementsByTagName("div")[0];
	checkAllDiv.onclick = function(){
		var img = this.getElementsByTagName("img");
		var imgsrc = srcToFileName(img[0].src);
		if(imgsrc == "icon_to_check.png"){
			img[0].src = "images/icon_checked.png";
			var checkItemImgs = document.getElementById("shopcart-content").getElementsByClassName("icon-check");
			for(var j=0;j<checkItemImgs.length;j++){
				checkItemImgs[j].src = "images/icon_checked.png";
			}
			checkNum = items.length-1;
			switchBuyBtn();
		}
		else{
			img[0].src = "images/icon_to_check.png";
			var checkItemImgs = document.getElementById("shopcart-content").getElementsByClassName("icon-check");
			for(var j=0;j<checkItemImgs.length;j++){
				checkItemImgs[j].src = "images/icon_to_check.png";
			}
			checkNum = 0;
			switchBuyBtn();
		}
		updateTotalPrice();
	} 
}



//给编辑状态的“-”和“+”按钮添加点击事件
function editNumBtnFunc(){
	var parDivs = document.getElementsByClassName("edit-wrap");
	for(var i=0;i<parDivs.length;i++){
		var editDiv = parDivs[i];
		var addBtn = editDiv.getElementsByClassName("page-btn-add")[0];
		var subBtn = editDiv.getElementsByClassName("page-btn-sub")[0];
		var numBtn = editDiv.getElementsByClassName("page-text-number")[0];
		var delBtn = editDiv.getElementsByClassName("edit-delete-btn")[0];
		addBtn.onclick =(function(numBtn){
			return function(){
				numBtn.value++;
			}
		})(numBtn);

		subBtn.onclick = (function(numBtn){
			return function (){
				if(numBtn.value>1){
					numBtn.value--;
				}
			};
		})(numBtn);

		delBtn.onclick = (function(parI){
			return function(){
				var thisli = document.getElementsByClassName("shopcart-item")[parI+1];
				var itemId = thisli.getElementsByTagName("input")[0].value;
				xmlHttp = createxmlHttp();
				editDeleteDB(xmlHttp,itemId);
				removeElement(thisli);
				updateTotalPrice();
			};
		})(i);
	}	
}

function editDeleteDB(xmlHttp,itemId){
	var url = "./lib/operate_db.php?action=deleteShopcart&itemId="+escape(itemId);
	// Open a connection to the server
	xmlHttp.open("GET",url,true);
		// Send the request
  	xmlHttp.send(null);
  
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
function updateDB(xmlHttp,itemId,bookNum){
	var url = "./lib/operate_db.php?action=updateShopcart&itemId="+escape(itemId)+"&bookNum="+escape(bookNum);
	// Open a connection to the server
	xmlHttp.open("GET",url,true);
		// Send the request
  	xmlHttp.send(null);
  
}

//根据编辑结果的更新书籍数目
function updateBookNum(){
	var parlis = document.getElementById("shopcart-content").getElementsByTagName("li");
	xmlHttp = createxmlHttp();
	for(var i=1;i<parlis.length;i++){
		var numPar = parlis[i].getElementsByClassName("shopcart-num")[0];

		var numNode0 = numPar.getElementsByTagName("span")[0];
		var numNode1 = parlis[i].getElementsByClassName("page-text-number")[0];
		if(numNode1.value!== numNode0.innerHTML){
			numNode0.innerHTML = numNode1.value;
			var itemId = parlis[i].getElementsByTagName("input")[0].value;
			updateDB(xmlHttp,itemId,numNode1.value);
		}
	}
}


//"编辑按钮控制书籍条目的编辑状态"
function switchEditCart(){
	var editBtn = document.getElementById("editBtn");
	var showFlag = true;

	editBtn.onclick = function(){
		var parlis = document.getElementById("shopcart-content").getElementsByTagName("li");
		if(false == showFlag){
			for(var i=1;i<parlis.length;i++){
				var editDiv = parlis[i].getElementsByClassName("edit-wrap");
				editDiv[0].style.display = "none";
			}
			updateBookNum();
			editBtn.value = "编辑";
			showFlag = true;
			updateTotalPrice();
		}
		else{
			for(var i=1;i<parlis.length;i++){
				var editDiv = parlis[i].getElementsByClassName("edit-wrap");
				editDiv[0].style.display = "block";			
			}
			editNumBtnFunc();
			editBtn.value = "完成";
			showFlag = false;
			updateTotalPrice();
		}
	}
}


function submitShopcart(){
	var items = document.getElementById("shopcart-content").getElementsByTagName("li");
	var bookids = new Array();
	var booknums = new Array();
	var bookprices = new Array();
	for(var i=1;i<items.length;i++){
		var img = items[i].getElementsByTagName("img")[0];
		var imgsrc = srcToFileName(img.src);
		if(imgsrc == "icon_checked.png"){
			var thisbookid = items[i].getElementsByTagName("input")[0].value;
			var thisbooknum = items[i].getElementsByClassName("shopcart-num")[0].getElementsByTagName("span").innerHTML;
			var thisbookprice = items[i].getElementsByClassName("shopcart-price")[0].getElementsByTagName("span").innerHTML;
			bookids.push(thisbookid);
			booknums.push(thisbooknum);
			bookprices.push(thisbookprice);
		}
	}

	var itemidarr = bookids.join(',');
	var booknumarr = booknums.join(',');
	var bookpricearr = bookprices.join(',');

	setCookie("itemidarr",itemidarr,1);
	location.href = "order.php";
}

window.onload = function(){
	setPxPerRem();
	switchCheck();
	switchEditCart();
	addEventNumBtn();

	var buybtn = document.getElementById("buy");
	buybtn.onclick = function(){
		submitShopcart();
	}
}