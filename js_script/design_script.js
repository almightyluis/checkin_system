

document.getElementById("men_1").addEventListener("click", function() {
	var SIZE = 4;
	var iter = 1;
	console.log("Hit");

	for(i =0 ; i < SIZE;  i++){
		var id = (i + 1).toString();
		var value = "/updated_php_project/static/img/col_haricut/men_fade_"+i+".jpg";
		document.getElementById(id).src = "/updated_php_project/static/img/col_haricut/men_fade_"+i+".jpg";
		console.log(value);
		console.log(id);
	}
	$("#picture_modal").modal('show');

});




function w(){
	console.log("Cl");

}

function close(){
	$("#picture_modal").modal("close");
}





