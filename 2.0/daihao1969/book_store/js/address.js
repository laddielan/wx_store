
function editBtnEvent(){
	var saveBtn = document.getElementById("edit-save-btn");
	var closeBtn = document.getElementById("edit-close-btn");

	closeBtn.onclick = function(){
		var pageEdit = document.getElementById("page-edit");
		pageEdit.style.display = "none";
	}
}

function submitNewAdrs(){

    var contact = document.getElementById("contact");
    var telephone = document.getElementById("telephone");
    var province = document.getElementById("selProvince");
    var city = document.getElementById("selCity");
    var district = document.getElementById("selDistrict");
    var detail = document.getElementById("detailAdrs");
    var err_flag = 0;
    if(contact.value.length<2||contact>25){
        alert("收货人不符合规范（长度大于两个字符少于25个字符，1个汉字算2个字符）");
        return false;
    }

    var pattern = /[^0-9]/g;
    if(pattern.test(telephone.value)){
        alert("联系电话不符合规范（电话应该为纯数字）");
        return false;
    }

    if(province.value==0||city.value==0||district==0){
        alert("请选择完整的地址信息");
        return false;
    }

    if(detail.value == ""){
        alert("请填写具体地址");
        return false;
    }
    
    console.log("校验完毕");
    return true;
   // var xmlHttp = createxmlHttp();
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


