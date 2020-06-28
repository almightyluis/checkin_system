


function show(){
	$("#picture_modal").modal("show");

var folder = "/updated_php_project/static/img/col_color/";

$.ajax({
    url : folder,
    success: function (data) {
        $(data).find("a").attr("href", function (i, val) {
            if( val.match(/\.(jpe?g|png|gif)$/) ) { 
                $("body").append( "<img src='"+ folder + val +"'>" );
                console.log(data);
                console.log("Found images");
            } 
        });
    }
});

}
function close(){
	$("#picture_modal").modal("close");
}

