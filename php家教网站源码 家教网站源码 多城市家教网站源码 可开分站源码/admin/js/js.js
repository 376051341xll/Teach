// JavaScript Document
$(document).ready(function(){
	//selectAll 
	//orderSelect
	//deleteSelect
	var selectAll = $("#selectAll");
	selectAll.click(function(){
		var id = $(":checkbox");
		id.attr("checked", true);						 
	}); // end 
	
	var orderSelect = $("#orderSelect");
	orderSelect.click(function(){
		var id = $(":checkbox");
		id.each(function(e){
			if($(this).attr("checked") == true)
			{
				$(this).attr("checked", false);
			}else{
				$(this).attr("checked", true);
			}
		});
	});//end
	
	
	var showtr = $(".showtr");
	var hidetr = $(".hidetr");
	showtr.hover(function(){
		$(this).css("background-color","#FC9");		  
	}, function(){
		$(this).css("background-color","#fff");		
	});

	showtr.each(function(e){
		$(this).click(function(){
			//alert(e);
			hidetr.eq(e).slideToggle(100);							
		});					 
	});//end each

});