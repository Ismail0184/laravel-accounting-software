		$(".tdayex").on('change', function(e){
			var tdayex=e.target.value; 
				//alert(tdayex);
				$.getJSON('tdayex/' + tdayex, function(data){
            });
			})
		
		$("#tdate").on('change', function(e){             
		var tdayex=e.target.value; 
		alert(tdayex);
		  $.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "display",             
			dataType: "html",   //expect html to be returned                
			success: function(response){                    
				$("#responsecontainer").html(response); 
				//alert(response);
			}
	
		});
