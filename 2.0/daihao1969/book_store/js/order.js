
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
	total_money_obj.innerHTML = totalmoney.toFixed(2);
	b_total_money_obj.innerHTML = totalmoney.toFixed(2);
}

function submitOrder(){
	var lis = document.getElementById("books_content").getElementsByTagName("li");
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
	            var pay_block = document.getElementById("pay_block");
	            var responsediv = document.getElementById("responsetext");
				pay_block.style.display = "block";
				responsediv.innerHTML = xmlHttp.responseText;
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

window.onload = function(){
	setPxPerRem();
	countTotalMoney();
	submitBtn();
}