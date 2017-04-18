//全局变量
//checkNum, Number, 记录购物车中被选中的条目数
var checkNum = 0;

//前端页面内容动态显示方法
//DOM操作的一些基本函数

/**
 *
 前端页面内容动态显示方法。
 DOM操作的一些基本函数。
 删除节点。
 *
 @method removeElement
 *
 @param 
 *
 @return 
 */
function removeElement(eleNode){
	var parNode = eleNode.parentNode;
	if(parNode){
		parNode.removeChild(eleNode);
	}
}

/**
 *
 前端页面内容动态显示方法。
 DOM操作的一些基本函数。
 防止书籍数量框输入非数字——把非数字去除。
 *
 @method inputFunc
 *
 @param 
 *
 @return 
 */
function inputFunc(event){
	this_obj = event.target?event.target:window.event.target;
	var pattern = /[^0-9]/g;
	if(pattern.test(this_obj.value)){
		this_obj.value = 1;
	}
}

/**
 *
 UI显示模块。
 DOM操作的一些基本函数。
 防止书籍数量框输入非数字—，在数字框失去焦点后检测，如果有非数字，调用inputFunc把非数字去除。
 *
 @method addEventNumBtn
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 DOM操作的一些基本函数。
 从路径找出文件名。
 *
 @method srcToFileName
 *
 @param String src
 *
 @return String filename 
 */

function srcToFileName(src){
	var srcarr = src.split("/");
	var filename = srcarr[srcarr.length-1];
	return filename;
}

/**
 *
 UI显示模块。
 更新总金额。
 *
 @method updateTotalPrice
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 改变"结算"按钮的样式：没有选中商品时不可点击，有选中商品时可以点击并且样式改变。
 *
 @method switchBuyBtn
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 改变商品选中时的样式：没有选中商品时圆圈为空心圆，选中时为另一种样式。
 *
 @method switchCheck
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 给编辑状态的“-”和“+”按钮添加点击事件。
 *
 @method editNumBtnFunc
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 根据编辑结果的更新书籍数目。
 *
 @method updateBookNum
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 编辑按钮控制书籍条目的编辑状态。
 *
 @method switchEditCart
 *
 @param 
 *
 @return 
 */
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

/**
 *
 UI显示模块。
 根据设备屏幕尺寸设置每rem的px数，使页面显示兼容不同的设备。
 *
 @method setPxPerRem
 *
 @param 
 *
 @return 
 */
setPxPerRem();

/**
 *
 UI显示模块。
 在页面内容加载完成后调用前端页面内容动态显示方法。
 *
 @method 
 *
 @param 
 *
 @return 
 */
window.onload = function(){	
	if(document.getElementById("shopcart-content")){
		switchCheck();
		switchEditCart();
		addEventNumBtn();

		var buybtn = document.getElementById("buy");
		buybtn.onclick = function(){
			submitShopcart();
		}
	}	
}

/**
 *
 数据更新模块。
 *
 删除购物车里的商品。
 使用Ajax将需删除的商品在数据库的购物车里的itemid提交到operate_db.php。
 *
 @method editDeleteDB
 *
 @param Object xmlHttp,String itemId
 *
 @return 
 */
function editDeleteDB(xmlHttp,itemId){
	var url = "./lib/operate_db.php?action=deleteShopcart&itemId="+escape(itemId);
	// Open a connection to the server
	xmlHttp.open("GET",url,true);
		// Send the request
  	xmlHttp.send(null);  
}

/**
 *
 数据更新模块。
 *
 更新购物车里的商品的数量。
 使用Ajax将需删除的商品在数据库的购物车里的itemid和新的数量提交到operate_db.php。
 *
 @method updateDB
 *
 @param Object xmlHttp,String itemId,Number booknum
 *
 @return 
 */
function updateDB(xmlHttp,itemId,bookNum){
	var url = "./lib/operate_db.php?action=updateShopcart&itemId="+escape(itemId)+"&bookNum="+escape(bookNum);
	// Open a connection to the server
	xmlHttp.open("GET",url,true);
		// Send the request
  	xmlHttp.send(null);
  
}

/**
 *
 订单提交模块。
 *
 提交购物车。
 将选中的要生成订单的商品的itemid连接成字符串存储在cookie里，然后跳转到order.php页面将其读出并生成订单。
 *
 @method submitShopcart
 *
 @param 
 *
 @return 
 */
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
