$ = jQuery.noConflict();

$(function() {
	$( ".datepicker" ).datepicker(  { dateFormat: "yy-mm-dd", changeYear: true } );
});

$(document).ready( function(){

	/*
	$("#signup2-edit").submit(function(){
		$("#signup2-edit #submit").attr('disabled', true);
		$("#signup2-edit #submit").text("Please wait...");
		$("#signup2-edit #submit").after("<div class='glare'></div>");

		return true;
	});

	$("#signup3-edit").submit(function(){
		$("#signup3-edit #submit").attr('disabled', true);
		$("#signup3-edit #submit").text("Please wait...");
		$("#signup3-edit #submit").after("<div class='glare'></div>");

		return true;
	});
*/

	if( $(".select-child-div").length > 0 )
	{
		//disableChildInputs();
		//initFirstChildDiv();
	}
	
	if( $("#show-benefits").length > 0 )
	{
		$('#show-benefits').popover({
			html: true,
			placement: 'top',
			content: function() 
			{
				return $('#step2-pop').html();
			}

		}).click(function (e) { e.preventDefault(); });
		// $("#show-benefits").on("click", function(){
		// 	$("#dialog").dialog({modal:true, width: 500});
		// 	event.preventDefault();
		// });
	}


	
	if( $("#paid").length > 0 )
	{
		//if( $("#allowance_frequency").val() == "MONTH" )
		//{
			toggle_allowance_payday();
		//}

		$("#allowance_frequency").on("change", function(){
			toggle_allowance_payday();
		});
	}
	
	if( $(".paid").length > 0 )
	{
		toggle_allowance_payday_multi( 0 );
	}


	if ($('#toast').length)
	{
		$('#toast').fadeIn(500);
		
		$('#toast-close').click(function() 
		{
			$('#toast ul li').stop();
			$('#toast').stop().fadeOut(300);
		});

		if ($('#toast-data').children('li').length > 1) 
		{
			blend($('#toast-data li:first'));
		}
	}

	if ($('#for-schools-btn').length > 0)
	{
		$('#for-schools-btn, #for-families-btn, #for-advisors-btn').popover().click(function (e) { e.preventDefault(); });
	}
	
	
	
});

function blend(i) {
	i.fadeIn().delay(5000).fadeOut(function() 
	{
		if (i.next().length > 0) {
			blend(i.next());
		}
		else 
		{
			blend(i.siblings(':first'));
		}
	}); 
}



function initFirstChildDiv()
{
	$('.select-child-panel-div:first-child').show();
	$(".select-child-div").each(function(){
		$(this).css('display', 'block');
		$(this).find('input').prop({disabled: false});

		// Only do it once.
		return false;
	});
}

function disableChildInputs()
{
	$(".select-child-div, .select-child-panel-div").each(function(){
		$(this).css('display', 'none');
		$(this).find("input").prop({disabled: true});
	});
}

function showChildDiv( v )
{	
	disableChildInputs();
	
	$("#child"+v).css('display', 'block');
	$("#child-panel"+v).css('display', 'block');
	$("#sub-nav"+v).css('display', 'block');
	$("#child"+v).find('input').prop({disabled: false});
	$("#sub-nav"+v).find('input').prop({disabled: false});
	
	toggle_allowance_payday_multi(v);
}

function toggle_allowance_payday()
{
	if( $("#allowance_frequency").val() == "MONTH" )
	{
		$("#paid-weekly").css('display', 'none');
		$("#paid-weekly").find("select").prop({disabled: true});

		$("#paid-monthly").css('display', 'block');
		$("#paid-monthly").find("select").removeAttr('disabled');
	}
	else
	{
		$("#paid-weekly").css('display', 'block');
		$("#paid-weekly").find("select").removeAttr('disabled');

		$("#paid-monthly").css('display', 'none');
		$("#paid-monthly").find("select").prop({disabled: true});
	}
}

function toggle_allowance_payday_multi( id )
{
	if( $("#allowance_frequency"+id).val() == "MONTH" )
	{
		$("#paid-weekly"+id).css('display', 'none');
		$("#paid-weekly"+id).find("select").prop({disabled: true});
		
		$("#paid-monthly"+id).css('display', 'block');
		$("#paid-monthly"+id).find("select").removeAttr('disabled');
	}
	else
	{
		$("#paid-weekly"+id).css('display', 'block');
		$("#paid-weekly"+id).find("select").removeAttr('disabled');
		
		$("#paid-monthly"+id).css('display', 'none');
		$("#paid-monthly"+id).find("select").prop({disabled: true});
	}
}