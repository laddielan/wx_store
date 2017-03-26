

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

window.onload = function(){
	switchCheck();
}