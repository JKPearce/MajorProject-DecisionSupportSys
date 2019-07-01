var counter = 1;

$(document).ready(function(){
    $("#addrow").click(function(){

    	var row = '<div class="row" id="' + counter + '">'+
		'<input name="field[]" class="col-2" id="option" type="text">' +
		'<select name="input[]" class="col-2" id="datatype">' +
		'<option value="text">Text</option>' +
		'<option value="number">Number</option>'+
		'</div>';

        $("#inputboxes").append(row);

        counter++;
    });
     $("#removerow").click(function(){
     	counter--;
     	$("#"+ counter).remove();
     	
     });

     $("#submit").click(function(){
     	if($.trim($(".col-2").val()).length == 0){
     		alert("Please dont leave empty boxes");
     		return false;
     	}else{
     		
     		return true;
     	}
     });
});