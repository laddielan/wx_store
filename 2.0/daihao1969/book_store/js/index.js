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

window.onload = function(){
	setInterval(slide,3000);
	window.onscroll = function(){
		var top = document.body.scrollTop>0?document.body.scrollTop:document.documentElement.scrollTop;
		var toTop = document.getElementById("toTop");
		if(top>300){				
			toTop.style.display = "block";
		}
		else{
			toTop.style.display = "none";
		}

	}
}