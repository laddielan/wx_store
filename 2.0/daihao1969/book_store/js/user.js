function setPxPerRem(){
    var cssEl = document.createElement('style');
    document.documentElement.firstElementChild.appendChild(cssEl);
    var dpr = 1;
        //把viewport分成10份的rem，html标签的font-size设置为1rem的大小;
    var pxPerRem = document.documentElement.clientWidth * dpr / 10;
    cssEl.innerHTML = 'html{font-size:' + pxPerRem + 'px!important;}';
}

setPxPerRem();


function switchCheck(){

	var items = document.getElementById("shopcart-content").getElementsByTagName("li");

	//给各项书籍的选中按钮加点击事件
	for(var i=1;i<items.length;i++){
		var checkDiv = items[i].getElementsByTagName("div");
		checkDiv[0].onclick = function(){
			var img = this.getElementsByTagName("img");
			var imgsrc = img[0].src;
			var imgsrcarr = imgsrc.split("/");
			imgsrc = imgsrcarr[imgsrcarr.length-1];
			if(imgsrc == "icon_to_check.png"){
				img[0].src = "images/icon_checked.png";
			}
			else{
				img[0].src = "images/icon_to_check.png";
				var checkAllDiv = items[0].getElementsByTagName("div")[0].getElementsByTagName("img")[0];
				checkAllDiv.src = "images/icon_to_check.png";
			}
		}
	}

	var checkAllDiv = items[0].getElementsByTagName("div")[0];
	checkAllDiv.onclick = function(){
			var img = this.getElementsByTagName("img");
			var imgsrc = img[0].src;
			var imgsrcarr = imgsrc.split("/");
			imgsrc = imgsrcarr[imgsrcarr.length-1];
			if(imgsrc == "icon_to_check.png"){
				img[0].src = "images/icon_checked.png";
				var checkItemImgs = document.getElementById("shopcart-content").getElementsByClassName("icon-check");
				for(var j=0;j<checkItemImgs.length;j++){
					checkItemImgs[j].src = "images/icon_checked.png";
				}
			}
			else{
				img[0].src = "images/icon_to_check.png";
				var checkItemImgs = document.getElementById("shopcart-content").getElementsByClassName("icon-check");
				for(var j=0;j<checkItemImgs.length;j++){
					checkItemImgs[j].src = "images/icon_to_check.png";
				}
			}
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

//根据编辑结果的更新书籍数目
function updateBookNum(){
	var parlis = document.getElementById("shopcart-content").getElementsByTagName("li");
	for(var i=1;i<parlis.length;i++){
		var numPar = parlis[i].getElementsByClassName("shopcart-num")[0];

		var numNode0 = numPar.getElementsByTagName("span")[0];
		var numNode1 = parlis[i].getElementsByClassName("page-text-number")[0];
		if(numNode1.value!== numNode0.innerHTML){
			numNode0.innerHTML = numNode1.value;
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
		}
		else{
			for(var i=1;i<parlis.length;i++){
				var editDiv = parlis[i].getElementsByClassName("edit-wrap");
				editDiv[0].style.display = "block";
				editNumBtnFunc();
			}
			editBtn.value = "完成";
			showFlag = false;
		}
	}
}



window.onload = function(){
	switchCheck();
	switchEditCart();
}