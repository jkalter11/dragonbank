$ = jQuery.noConflict();

// Global variables.
var per_page_global         = 100,  // Amount of codes per page.
    starting_point_global   = 0,    // The starting page number.
    paginpage_global        = 1,    // The page number
    block_block_global      = "u10";// The page id.

$(document).ready(function() {

    $('[data-toggle=offcanvas]').click(function() {
      $('.row-offcanvas').toggleClass('active');
    });
  
    $( ".datepicker" ).datepicker( { dateFormat: "yy-mm-dd" } );
	
	if( $("#entity-search").val() )
	{
		searchDate();
	}
	
	$("#entity-search").on("change", function(){
		searchDate();
	});

	if ($('select#company').length)
	{
		$('select#company').change(function()
		{
			$('select#regionaldirector').html('<option value="0">Please select</option>');
			$('select#advisor').html('<option value="0">Please select</option>');

			$('#regionaldirector-control').fadeOut();
			$('#advisor-control').fadeOut();
			var companyID = $(this).val();

			if (companyID != 0)
			{
				$.get("../ajax/ajax_regionaldirectors", { company: companyID }, function (result) {


					if (result.status == true)
					{
						$('select#regionaldirector').html('<option value="0">Please select</option>');

						$.each(result.directors, function()
						{
							//console.log(this.firstname);
							$('select#regionaldirector').append('<option value="' + this.id + '">' +  this.user_full_name +'</option>');
						});

						$('#regionaldirector-control').fadeIn();
					}

				}, "json");
			}
		});

		$('select#regionaldirector').change(function()
		{
			$('select#advisor').html('<option value="0">Please select</option>');

			$('#advisor-control').fadeOut();
			var directorID = $(this).val();
			
			if (directorID != 0)
			{
				$.get("../ajax/ajax_advisors", { director: directorID }, function (result) {


					if (result.status == true)
					{
						$('select#advisor').html('<option value="0">Please select</option>');

						$.each(result.advisors, function ()
						{
							//console.log(this.firstname);
							$('select#advisor').append('<option value="' + this.id + '">' + this.user_full_name +'</option>');
						});

						$('#advisor-control').fadeIn();
					}

				}, "json");
			}
		});
	}


	if ($('select#company_id').length)
	{
		$('select#company_id').change(function()
		{
			$('select#director_id').html('<option value="0">---</option>');
			$('select#advisor_id').html('<option value="0">---</option>');
			var companyID = $(this).val();

			if (companyID != 0)
			{
				$.get("/ajax/ajax_regionaldirectors", { company: companyID }, function(result) 
				{
					if (result.status == true)
					{
						$('select#director_id').html('<option value="0">---</option>');

						$.each(result.directors, function()
						{
							$('select#director_id').append('<option value="' + this.id + '">' +  this.user_full_name +'</option>');
						});
					}

				}, "json");
			}
			else
			{
				$('select#director_id').html('<option value="0">---</option>');
			}

			displayCodes(companyID, $('#director_id').val(), $('#advisor_id').val());
		});

		$('select#director_id').change(function()
		{
			$('select#advisor_id').html('<option value="0">---</option>');
			var directorID = $(this).val();
			
			if (directorID != 0)
			{
				$.get("/ajax/ajax_advisors", { director: directorID }, function(result)
				{
					if (result.status == true)
					{
						$('select#advisor_id').html('<option value="0">---</option>');

						$.each(result.advisors, function ()
						{
							$('select#advisor_id').append('<option value="' + this.id + '">' + this.user_full_name +'</option>');
						});
					}

				}, "json");
			}
			else
			{
				$('select#advisor_id').html('<option value="0">---</option>');
			}

			displayCodes($('#company_id').val(), directorID, $('#advisor_id').val());
		});

		$('select#advisor_id').change(function()
		{
			displayCodes($('#company_id').val(), $('#director_id').val(), $('#advisor_id').val());
		});

	}
});

function displayCodes(companyID, directorID, advisorID)
{
	$.get("/ajax/advisor_codes", {companyid: companyID, directorid: directorID, advisorid: advisorID}, function(result)
	{
		var body = $("#table-striped-body");

		if(result.status == true)
		{
			// Remove all options.
			body.find('tr').remove().end();

			if (result.codes.length)
			{
			
				$.each(result.codes, function()
				{
					var exp = "N/A";
					
					if (this.export_date)
					{
						exp = this.export_date;
					}
					
					var name = "<td>" + this.codename + "</td>";
					var date = "<td>" + this.date + "</td>";
					var expd = "<td>" + exp + "</td>";

					body.append("<tr>" + name + date + expd + "</tr>");

					
				});
			}
			else
			{
				body.append('<tr><td colspan="3">No codes.</td></tr>');
			}

			return true;
		}
		else
		{
			console.log(result);
		}

	}, "json").fail(function(data)
	{
		console.log("Failed");
		return false;
	});
}




function searchDate()
{

    var per_page    = per_page_global;
    var start       = starting_point_global;
    var paginpage   = paginpage_global;
    var block       = block_block_global;
	var list 	    = $("#entity-search").val();
	var to 		    = $("#end").val();
	var from 	    = $("#start").val();
	var body	    = $("#table-striped-body");
	var pagin	    = $("#pagination_wrapper");
	var codes	    = 0;
	var pages	    = 1;
	var expCode     = "export_codes?list_id=";
	var menus	    = 15;	// Number of links per page.

	$.get("../ajax/ajax_codes", { codelistname: list, startdate: from, enddate: to, limit: per_page, lstart: start }, function( result ){
		
		if( result.status == true )
		{
			// Remove all options.
			body.find('tr').remove().end();
			
			codes 	= result.pages;
			pages 	= Math.ceil( codes / per_page );
			loops 	= Math.ceil( pages / menus );
			var i 	= 0;
			
			$.each(result.codes, function(){
				
				if( ! this.codename )
				{
					return true;
				}
				
				++i;
				
				var exp = "N/A";
				
				if( this.export_date )
				{
					exp = this.export_date;
				}
				
				var name = "<td>" + this.codename + "</td>";
				var date = "<td>" + this.date + "</td>";
				var expd = "<td>" + exp + "</td>";

				if( i <= per_page )
				{
					body.append( $("<tr id='tr" + i + "'>" + name + date + expd + "</tr>") );
				}
				else
				{
					body.append( $("<tr id='tr" + i + "' style='display: none;'>" + name + date + expd + "</tr>") );
				}
				
			});
			
			var s = "";

			for( var j = 0; j < loops; j++)
			{
				if( block == ("ul"+j) )
				{
					s += "<div id='ul"+j+"' style='display:block;'><ul class='pagination' ><li class='disabled' id='liprev"+j+"'><a href='#prev' onclick='prevLink("+j+");'>&laquo;</a></li>";
				}
				else
				{
					s += "<div id='ul"+j+"' style='display:none;'><ul class='pagination'><li id='liprev"+j+"'><a href='#prev' onclick='prevLink("+j+");'>&laquo;</a></li>";
				}

				var star 	= menus * j;
				var end 	= menus * (j + 1);

				if( end >= pages )
				{
					end = pages;
				}
				
				for( var i = star; i < end; i++ )
				{
					var n = i + 1;
					if( n == paginpage )
					{
						s += "<li class='active' id='li"+i+"'><a href='#" + i + "' onclick='togglePage(this, "+n+", "+per_page+")'>" + n + "</a></li>";
					}
					else
					{
						s += "<li id='li"+i+"'><a href='#" + i + "' onclick='togglePage(this, "+n+", "+per_page+")'>" + n + "</a></li>";
					}
				}
				
				if( j == ( loops - 1 ) )
				{
					s += "<li class='disabled' id='linext"+j+"'><a href='#next' onclick='nextLink("+j+", "+(loops-1)+");'>&raquo;</a></li></ul></div>";
				}
				else
				{
					s += "<li id='linext"+j+"'><a href='#next' onclick='nextLink("+j+", "+(loops-1)+");'>&raquo;</a></li></ul></div>";
				}
			}
			
			pagin.html(s);
			var limit   = "";
            var lstart  = "";

			if( to )
			{
				to = "&end=\'" + to + "\'";
			}
			else
			{
				to = "&end=";
			}

			if( from )
			{
				from = "&start=\'" + from + "\'";
			}
			else
			{
				from = "&start=";
			}

            if( per_page )
            {
                limit = "&limit=\'" + per_page + "\'";
            }
            else
            {
                limit = "&limit=";
            }

            if( start )
            {
                lstart = "&lstart=\'" + start + "\'";
            }
            else
            {
                lstart = "&lstart=";
            }
			
			// Adds the list id as a get request.
			expCode += result.list_id + from + to + limit + lstart;
			
			$("#exportCodes").attr("href", expCode);
			
			return true;
		}
		else
		{
			console.log(result);
		}

	}, "json").fail(function(data){
		console.log("Failed");
		
		return false;
	});
}

function togglePage( block, page, per_page )
{
	var body	= $("#table-striped-body");
	var pagin	= $("#pagination_wrapper");
	
	var blockid = $(block).parent().parent().parent().attr('id');
	
	if( page == 1 )
	{
		last = 0;
	}
	else
	{
		last = ( page - 1 ) * per_page;
	}

	var first = last - per_page;

    /**
     * Set all the globals in order for searchDate to set the correct values.
     */
    per_page_global         = per_page;
    starting_point_global   = last;
    paginpage_global        = page;
    block_block_global      = blockid;
	
	searchDate( per_page, last, page, blockid );
}

function prevLink( n )
{
	if( n == 0 )
		return;
		
	$("#ul"+n).css("display", "none");

	pr = n - 1;
	
	$("#ul"+pr).css("display", "block");
}

function nextLink( n, p )
{
	if( n == p )
		return;
	
	$("#ul"+n).css("display", "none");
	
	nt = n + 1
	
	$("#ul"+nt).css("display", "block");
}

function getHistory( cid )
{
	var body = $("#history-body"+cid);
	
	$.get("/ajax/ajax_history", { history_child_id: cid }, function( result ){
		console.log(result);
		if( result.status == true )
		{
			
			// Remove all options.
			body.find('tr').remove().end();
			
			var i = 0;
			
			$.each(result.history, function(){
				
				var money = "";
				
				if( this.debit > this.credit )
				{
					money = "<span style='color: red'>" + this.debit + "</span>";
				}
				else
				{
					money = "<span>" + this.credit + "</span>";
				}

				body.append( $("<tr><td>" + this.date + "</td> <td>" + this.transaction + "</td><td>" + money + "</td><td>" + this.balance + "</td><td>" + this.desc + "</td></tr>") );

			});
		}
		else
		{
			console.log(result.status);
		}
	}, "json");
}