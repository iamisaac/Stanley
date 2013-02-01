$('#addPost').click(function(){
	
	
	
	$.ajax({
		url: './ajax/addpost.php',
		type: 'POST',
		data: {body: $('#post').val(), cat: $('#cat').val()},
		success:function(res)
		{

			var obj = jQuery.parseJSON(res);
			
			if(typeof obj == 'object')
			{
				
				if(obj.stat == 'OK')
				{
					
					$('#post').val('');
					$('#postMain').prepend('<div id="love'+obj.pid+'"></div>');
					$('#love'+obj.pid).css('display', 'none').append(obj.div).slideDown('fast');
				}
				
					
			}
			
		}
	});
	
});

function addcomment(e, num)
{
	if(e.keyCode == 13)
	{
		
		var body = $('#commentBody'+num).val();
		
		if(body.length > 2)
		{		
			$.ajax({
				
				url: './ajax/addcomment.php',
				type: 'post',
				data: {pid: num, body: body},
				success: function(res)
				{
					
					var obj = jQuery.parseJSON(res);
					
					
					if(typeof obj == 'object')
					{
						if(obj.stat == 'OK')
						{
																						
							$('#commentBody'+num).val("");
							$('#newComment'+num).append('<div id="smile'+obj.cid+'"></div>');
							$('#smile'+obj.cid).css('display', 'none').append(obj.div).slideDown('slow');
							
							
						}
						
					}
					
				}
				
			});
		}
	}


}

function deletePost(pid, cat)
{
	$.ajax({
		url: './ajax/deletepost.php',
		type: 'post',
		data: {pid: pid, cat: cat},
		success: function(res)
		{
			
			var obj = jQuery.parseJSON(res);
			
			if(typeof obj == 'object')
			{
				if(obj.stat == 'OK')
				{
					
					$('#post'+pid).fadeOut('slow');
				}
			}
		}
	});

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