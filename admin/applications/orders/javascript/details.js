$(document).ready(function (){
	$('#tabs').tabs();
	var getVars = getUrlVars();
	$('#resendEmail').click(function(){
		$.ajax({
			url: js_app_link('app=orders&appPage=details&action=resendEmail'),
			cache: false,
			dataType: 'json',
			data: 'oID='+getVars['oID']+'&isEstimate='+getVars['isEstimate'],
			type: 'post',
			success: function (data){
				if(data.success == true){
					alert('Confirmation email resent');
				}
			}
		});
		return false;
	});
});