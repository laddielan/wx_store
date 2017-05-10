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
	var we_pay_btn = document.getElementById("we_pay");
	var pay_block = document.getElementById("pay_block");
	var to_pay_btn = document.getElementById("to_pay");
	we_pay_btn.onclick = function(){
		var e=window.event?window.event:event; 
        if(e.stopPropagation){  
            e.stopPropagation();
        }else{  
            e.cancelBubble = true;  
        }  
				
	};

//点击"去支付"按钮显示微信支付弹窗，点击其他部分关闭弹窗。
    pay_block.onclick = function(){  
        pay_block.style.display = "none";
        var body = document.getElementsByTagName("body")[0];
        body.setAttribute("class","auto");  
    }; 

    to_pay_btn.onclick = function(){
    	pay_block.style.display = "block";
        var body = document.getElementsByTagName("body")[0];
        body.setAttribute("class","hidden");
    }  
}