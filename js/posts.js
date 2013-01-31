$('#addPost').click(function(){
	
	$.ajax({
		url: './ajax/addpost.php',
		type: 'POST',
		data: {body: $('#post').val(), cat: $('#cat').val()},
		success:function(res)
		{
			alert(res);
			
			var obj = jQuery.parseJSON(res);
			var div = null;
			
			if(typeof obj == 'object')
			{
				
				if(obj.stat == 'OK')
				{
					$('#postMain').append(div);
				}
				
					
			}
			
		}
	});
	
});

function addcomment(e, num)
{
	if(e.keyCode == 13)
	{
		
		var body = $('#commentBody').val();
		
		if(body.length > 2)
		{		
			$.ajax({
				
				url: './ajax/addcomment.php',
				type: 'post',
				data: {pid:num, body: body},
				success: function(res)
				{
					
					
					alert(res);
					
					var obj == jQuery.parseJSON(res);
					var div == null;
					
					if(typeof obj == 'object')
					{
						if(obj.stat == 'OK')
						{
							
							
							
						}
						
					}
					
				}
				
			});
		}
	}


}

Dropbox.choose(options);

options = {
  linkType: "preview",
  success: function(files) {
                
	  alert(files);
				
                $.ajax({
	             	url: './ajax/addfiles.php',
	             	type: 'POST',
	             	data: {files: files},
	             	success: function(res)
	                {
	                	
	                }
                });
                
            },
  cancel:  function() {
  
            }
};