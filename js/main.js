$('#logButton').click(function()
{
	
	$("#logButton").addClass("buttonAnim");
	
	$.ajax({
		type: 'POST',
		url: './ajax/login.php',
		data: { email: $('#email').val(), passwd: $('#passwd').val() },
		success: function(res)	
		{

			var obj = jQuery.parseJSON(res);			
			
			if(typeof obj == 'object')					
			{
				
				
				if(obj.stat == 'OK')
				{
					location.reload();
				}
				else
				{
					if(obj.email === 0) $('#email').addClass("err"); else $('#email').removeClass("err");
					if(obj.passwd === 0) $('#passwd').addClass("err"); else $('#passwd').removeClass("err");
					
					$("#logButton").removeClass("buttonAnim");
				}
			
			}						
		}
	});
	
});

$('#logout').click(function()
{
	$.ajax({
		url: './ajax/logout.php',
		success: function(res)
		{
			location.reload();
		}
	});
});

/*

	SEARCH javascript part

*/

$('#search').focus(function()
{
	
	$('#searchArea').slideDown('fast');

});

$('#search').blur(function()
{
	
	$('#searchArea').slideUp('fast');
	
});
