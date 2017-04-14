
function countTotalMoney(){

	var books = document.getElementById("books_content").getElementsByTagName("li");
	var totalmoney = 0;
	for(var i=0;i<books.length;i++){
		var priceSpan = books[i].getElementsByClassName("book-num-wrap")[0].getElementsByTagName("span")[0];
		var numSpan = books[i].getElementsByClassName("book-num-wrap")[0].getElementsByTagName("span")[1];
		totalmoney += (priceSpan.innerHTML * numSpan.innerHTML);		
	}
	var total_money_obj = document.getElementById("total_money");
	var b_total_money_obj = document.getElementById("b_total_money");
	var freight = document.getElementById("freight");

	//计算是否需要运费
	if(totalmoney>=68){
		freight.innerHTML = "0";
	}
	else{
		totalmoney +=8;
		freight.innerHTML = "8";
	}

	total_money_obj.innerHTML = totalmoney.toFixed(2);
	b_total_money_obj.innerHTML = totalmoney.toFixed(2);

}

function submitOrder(){
	var lis = document.getElementById("books_content").getElementsByTagName("li");
	if(!document.getElementById("addressid")){
		alert("请先添加地址");
		return false;
	}
	var addressid = document.getElementById("addressid").value;
	var itemsid = null;
	for (var i = 0; i <lis.length; i++) {
		if(null == itemsid){
			itemsid = lis[i].getElementsByTagName("input")[0].value;
		}
		else{
			itemsid = itemsid + "," + lis[i].getElementsByTagName("input")[0].value;
		}		
	}

	var postBody = "action="+"addOrder"+"&"+"addressid="+addressid+"&"+"itemsid="+itemsid;
    var url = "./lib/operate_db.php";
    var xmlHttp = createxmlHttp();
    xmlHttp.open("post",url,true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');  
    xmlHttp.send(postBody); 
	
    xmlHttp.onreadystatechange = function(){
    	if(xmlHttp.readyState==4){
	        if(xmlHttp.status == 200){       
	           window.location.href="ordertopay.php?orderid="+xmlHttp.responseText;
	           //console.log(xmlHttp.responseText);
	        }
	        else{
	            alert("由于网络原因，保存失败");
	        }
	       
	    } 
    } 
}

function submitBtn(){
	var submitBtn = document.getElementById("submit_pay");

	submitBtn.onclick = function(){
		submitOrder();		
	}
}

function updateAdrs(){
	var check_lis = document.getElementById("adrs_popup").getElementsByTagName("li");
	var addressid = document.getElementById("addressid");
	for(var i=0;i<check_lis.length;i++){
		var id_input = check_lis[i].getElementsByTagName("input")[0];
		if(id_input.value == addressid.value){
			var adrs_name = document.getElementById("adrs_name");
			var adrs_phone = document.getElementById("adrs_phone");
			var adrs_content = document.getElementById("adrs_content");
			var this_adrs = check_lis[i].getElementsByClassName("adrs-content-wrap")[0].getElementsByTagName("span");
			adrs_name.innerHTML = this_adrs[0].innerHTML;
			adrs_phone.innerHTML = this_adrs[1].innerHTML;
			adrs_content.innerHTML = this_adrs[2].innerHTML;
		}
	}
}
function adrsCheck(){
	var check_lis = document.getElementById("adrs_popup").getElementsByTagName("li");

	for(var i=0;i<check_lis.length;i++){
		check_lis[i].onclick = (function(i){
			return function(){
				var addressid = document.getElementById("addressid");
				addressid.value = check_lis[i].getElementsByTagName("input")[0].value;
				for(var j=0;j<check_lis.length;j++){
					if(i==j){
						check_lis[j].getElementsByTagName("img")[0].src = "./images/icon_checked.png";
					}
					else{
						check_lis[j].getElementsByTagName("img")[0].src = "./images/icon_to_check.png";
					}				
				}
			};
		})(i);
	}
}
function editAdrsBtn(){
	var edit_adrs = document.getElementById("edit_adrs");
	if(!edit_adrs){
		return false;
	}
	edit_adrs.onclick = function(){
		var popup_adrs = document.getElementById("adrs_popup");
		if(popup_adrs){
			popup_adrs.style.display = "block";

			//禁止冒泡事件
			var popup_ul = popup_adrs.getElementsByTagName("ul")[0];
			popup_ul.onclick = function(){
				var e=window.event?window.event:event; 
		        if(e.stopPropagation){  
		            e.stopPropagation();
		        }else{  
		            e.cancelBubble = true;  
		        }  
			};
			//将当前选中地址勾选
			var check_lis = document.getElementById("adrs_popup").getElementsByTagName("li");
			var addressid = document.getElementById("addressid");
			for(var i=0;i<check_lis.length;i++){
				var i_li_adrs = check_lis[i].getElementsByTagName("input")[0];
				if(i_li_adrs.value == addressid.value){
					var i_img = check_lis[i].getElementsByTagName("img")[0];
					i_img.src = "./images/icon_checked.png";
				}
			}

			//给每项地址加上选中事件
			adrsCheck();

			//点击地址外的地方隐藏弹窗
			var body = document.getElementsByTagName("body")[0];
	        body.setAttribute("class","hidden");
			popup_adrs.onclick = function(){  
		        popup_adrs.style.display = "none";
		        updateAdrs();
		        var body = document.getElementsByTagName("body")[0];
		        body.setAttribute("class","auto");  
	    	}; 
		}
		else{
		//没有地址

		}
		
	}
}

window.onload = function(){
	setPxPerRem();
	countTotalMoney();
	submitBtn();
	editAdrsBtn();	
};