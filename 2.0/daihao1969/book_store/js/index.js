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

function wkf_reminder(){
    var searchBtn = document.getElementById("search_book_submit");
    var click_count = 0;
    searchBtn.onclick = function(){
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
    wkf_reminder();
}


//微信原生控件js
/*
$(function(){
    var $searchBar = $('#searchBar'),
        $searchResult = $('#searchResult'),
        $searchText = $('#searchText'),
        $searchInput = $('#searchInput'),
        $searchClear = $('#searchClear'),
        $searchCancel = $('#searchCancel');

    function hideSearchResult(){
        $searchResult.hide();
        $searchInput.val('');
    }
    function cancelSearch(){
        hideSearchResult();
        $searchBar.removeClass('weui-search-bar_focusing');
        $searchText.show();
    }

    $searchText.on('click', function(){
        $searchBar.addClass('weui-search-bar_focusing');
        $searchInput.focus();
    });
    $searchInput
        .on('blur', function () {
            if(!this.value.length) cancelSearch();
        })
        .on('input', function(){
            if(this.value.length) {
                $searchResult.show();
            } else {
                $searchResult.hide();
            }
        })
    ;
    $searchClear.on('click', function(){
        hideSearchResult();
        $searchInput.focus();
    });
    $searchCancel.on('click', function(){
        cancelSearch();
        $searchInput.blur();
    });
});

*/