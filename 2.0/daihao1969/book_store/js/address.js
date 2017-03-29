
function editBtnEvent(){
	var saveBtn = document.getElementById("edit-save-btn");
	var closeBtn = document.getElementById("edit-close-btn");

	closeBtn.onclick = function(){
		var pageEdit = document.getElementById("page-edit");
		pageEdit.style.display = "none";
	}
}
window.onload = function(){
	setPxPerRem();
	

	var addNemAdrsBtn = document.getElementById("add-new-adrs");
	addNemAdrsBtn.onclick = function(){
		var pageEdit = document.getElementById("page-edit");
		pageEdit.style.display = "block";
		editBtnEvent();
	}
}