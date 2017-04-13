window.onload = function(){
	var we_pay_btn = document.getElementById("we_pay");
	var pay_block = document.getElementById("pay_block");
	var to_pay_btn = document.getElementById("to_pay");
	we_pay_btn.onclick = function(){

		console.log("wechat pay~");
		var e=window.event?window.event:event; 
        if(e.stopPropagation){  
            e.stopPropagation();
        }else{  
            e.cancelBubble = true;  
        }  
				
	};

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