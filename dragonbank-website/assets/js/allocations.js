$ = jQuery.noConflict();

$(document).ready(function(){
	if( $('#init_deposit').length != 0 )
	{
		
		init_balance( $("#init_deposit").val(), $(".init_deposit") );
		
		$("input[name=allocation]").change(function(){
			init_balance( $("#init_deposit").val(), $(".init_deposit") );
		});
		
		$("#spend").keyup(function(){
			init_balance( $("#init_deposit").val(), $(".init_deposit") );
		});
		
		$("#save").keyup(function(){
			init_balance( $("#init_deposit").val(), $(".init_deposit") );
		});
		
		$("#give").keyup(function(){
			init_balance( $("#init_deposit").val(), $(".init_deposit") );
		});
	}
	
	if( $("#money").length != 0 )
	{
		money = $('#money').val();
		toSet = $('.xx');
		
		init_balance( money, toSet );
		
		$("#money").keyup(function(){
			init_balance( $('#money').val(), toSet );
		});
	}
	
	$("#submit").on("click", function(){
		validateValues();
	});
	
	$("#child_submit").on("click", function(){
		validateValues();
	});
	
	$(".custom").on('focus', function(){
		$("#den4").prop('checked', true);
	});

	if ($('#bank-allocations').length > 0)
	{
		changeAllocation($('#bank-allocations').val());
	}
	
	$("#bank-allocations").change(function(elem){
		changeAllocation( elem.target.value );
	});
})

function init_balance( money, elem )
{
	var allocations = getAllocation();
	setDensBalance( allocations, money, elem );
}

function bank_transactions()
{
	money = $('#money').val();
	toSet = $('.xx');
	
	init_balance( money, toSet );
}

function getAllocation()
{
	array = [];
	
	// signup3 form
	$('input[name=allocation]:checked').parent().parent().nextAll().children().each(function(){
		array.push(parseFloat( $(this).val() ).toFixed(2));
	});
	
	// profile edits
	$('input[name="child_info[allocation_type]"]:checked:enabled').parent().parent().nextAll().children().each(function(){
		array.push(parseFloat( $(this).val() ).toFixed(2));
	});
	
	// Deposits/withdrawls.
	$('input[name="perc[]"]').each(function(){
		array.push(parseFloat( $(this).val() ).toFixed(2));
	});

	return array;
}

function setDensBalance( allocations, money, elem )
{
	if( ! money ) 
		return;
	
	var money 	= money * 0.01;
	var i 		= 0;
	
	elem.each(function(){
	
		if( allocations[ i ] == "NaN" )
		{
			allocations[ i ] = 0.00;
		}
		
		$total = parseFloat( allocations[ i++ ] * money ).toFixed(2);
		$(this).html( "$" + $total );
	});
}

function changeAllocation( array )
{
	alloc = window.JSON.parse(array);
	var i = 0;
	
	$('.perc-block span').each( function(){
		$(this).html( parseFloat(alloc[ i++ ]).toFixed(2) );
	});
	
	i = 0;
	
	$('input[name="perc[]"]').each(function(){
		$(this).val( alloc[ i++ ] );
	});
	
	bank_transactions();
}

function validateValues()
{
	var vals = getAllocation();
	
	var result = 0;
	
	for(var i = 0; i < vals.length; i++)
	{
		result += parseFloat( vals[ i ] );
	}
	
	if( parseFloat( result ).toFixed(2) == 100.00 )
	{
		return true;
	}
	
	event.preventDefault();
	
	$("label.red").html("Allocation must equal 100.00<br/>current allocation: " + parseFloat(result).toFixed(2) );
	
	return false;
}