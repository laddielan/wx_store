
function editBtnEvent(){
	var saveBtn = document.getElementById("edit-save-btn");
	var closeBtn = document.getElementById("edit-close-btn");

	closeBtn.onclick = function(){
		var pageEdit = document.getElementById("page-edit");
		pageEdit.style.display = "none";
	}
}



function submitNewAdrs(){
    var openid = "oOEo4wdha12cmoJ2WFSAWBZ2vPpA";
    var contact = document.getElementById("contact");
    var telephone = document.getElementById("telephone");
    var m_province = document.getElementById("selProvince");
    var m_city = document.getElementById("selCity");
    var m_district = document.getElementById("selDistrict");
    var m_detail = document.getElementById("detailAdrs");
    var err_flag = 0;
    if(contact.value.length<2||contact>25){
        alert("收货人不符合规范（长度大于两个字符少于25个字符，1个汉字算2个字符）");
        return false;
    }

    var pattern = /[^0-9]/g;
    if(pattern.test(telephone.value)||telephone.value==""){
        alert("联系电话不符合规范（电话应该为纯数字）");
        return false;
    }
    else if(telephone.value.length!=11){
         alert("联系电话不符合规范（电话应该为11位数字）");
        return false;
    }

    if(m_province.value==0||m_city.value==0||m_district==0){
        alert("请选择完整的地址信息");
        return false;
    }


    if(m_detail.value == ""){
        alert("请填写具体地址");
        return false;
    }
 


    var a_province = "";
    var a_city = "";
    var a_district = "";
    $.each(province,function(k,p){
        if(p.ProID==m_province.value){
            a_province = p.ProName;
            return false;
        }
    });
    $.each(city,function(k,p){
        if(p.ProID==m_province.value&&p.CityID==m_city.value){
            a_city = p.CityName;
        }
    });
    $.each(District,function(k,p){
        if(p.CityID==m_city.value&&p.Id==m_district.value){
            a_district = p.DisName;
        }
    });

    var postBody = "action="+"addAdrs"+"&"+"openid="+openid+"&"+"phone="+telephone.value+"&"+"province="+a_province+"&"+"city="+a_city+"&"+"district="+a_district+"&"+"address="+m_detail.value+"&"+"name="+contact.value;
    var url = "./lib/operate_db.php";
    var xmlHttp = createxmlHttp();
    xmlHttp.open("post",url,true);
    xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');  
    xmlHttp.send(postBody);

    xmlHttp.onreadystatechange = function(){
         if(xmlHttp.readyState==4){
            if(xmlHttp.status == 200){       
                location.reload(true);  
            }
            else{
                alert("由于网络原因，保存失败");
            }
           
        } 
    } 
   
   
    return true;
  
}


window.onload = function(){
	setPxPerRem();

	var addNemAdrsBtn = document.getElementById("add-new-adrs");
	addNemAdrsBtn.onclick = function(){
		var pageEdit = document.getElementById("page-edit");
		pageEdit.style.display = "block";
		editBtnEvent();
	}

    var saveNewAdrsBtn = document.getElementById("edit-save-btn");
    saveNewAdrsBtn.onclick = function(){
        var flag = submitNewAdrs();
        if(flag){
            var pageEdit = document.getElementById("page-edit");
            pageEdit.style.display = "none";
        }
        
    }

}




$(function () {

    $.each(province, function (k, p) { 
        var option = "<option value='" + p.ProID + "'>" + p.ProName + "</option>";
        $("#selProvince").append(option);
    });
     
    $("#selProvince").change(function () {
        var selValue = $(this).val(); 
        $("#selCity option:gt(0)").remove();
         
        $.each(city, function (k, p) { 
            if (p.ProID == selValue) {
                var option = "<option value='" + p.CityID + "'>" + p.CityName + "</option>";
                $("#selCity").append(option);
            }
        });
         
    });
     
    $("#selCity").change(function () {
        var selValue = $(this).val();
        $("#selDistrict option:gt(0)").remove(); 

        $.each(District, function (k, p) {
            if (p.CityID == selValue) {
                var option = "<option value='" + p.Id + "'>" + p.DisName + "</option>";
                $("#selDistrict").append(option);
            }
        }); 
    }); 
});


