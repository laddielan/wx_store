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
}