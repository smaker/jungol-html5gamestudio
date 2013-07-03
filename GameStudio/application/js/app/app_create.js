var GSObjects;

$(document).ready(function()
{
	clickEvent();
});

function clickEvent()
{
	$('.accordion-toggle').bind('contextmenu', function(){
		event.preventDefault();
	});
	
	$('#eventModal ul a').click(function(){
		var modalId = '#event_body'+$(this).data('event-id');

		$('.eventBody').addClass('hide');
		$(modalId).removeClass('hide');
		$('#eventModal ul li').removeClass('active');
		$(this).parent().addClass('active');

		event.preventDefault();
	});
}

function _getAllObjects()
{
	$.ajax({
	  dataType: "json",
	  url: defaultUrl + 'app/getAllObjects/',
	  data: { project_id : project_id },
	  success: success
	});
}