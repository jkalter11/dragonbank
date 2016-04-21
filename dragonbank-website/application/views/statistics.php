<script type="text/javascript">
	window.onload = function () {
		var chart_LineChartWithMarkers = new cfx.Chart();
		LineChartWithMarkers(chart_LineChartWithMarkers);
		chart_LineChartWithMarkers.create(document.getElementById("container_LineChartWithMarkers"));
		$("#container_LineChartWithMarkers").data("function",LineChartWithMarkers);

		var chart_container = $(".chart_container");
		var html = chart_container.data("chart");

		if (typeof(html)  === "undefined") {
			$("#currentChart").html("");
			var chart = new cfx.Chart();
			var f = chart_container.data("function");
			f(chart);
			chart.create("currentChart");
			chart_container.data("chart",$("#currentChart").html());
		}
		else {
			$("#currentChart").html(html);
		}

		$("#main").css({display: "none"});









		var chart_LineChartWithMarkers2 = new cfx.Chart();
		LineChartWithMarkers2(chart_LineChartWithMarkers2);
		chart_LineChartWithMarkers2.create(document.getElementById("container_LineChartWithMarkers2"));
		$("#container_LineChartWithMarkers2").data("function2",LineChartWithMarkers2);

		var chart_container2 = $(".chart_container2");
		var html2 = chart_container2.data("chart2");

		if (typeof(html2)  === "undefined") {
			$("#currentChart2").html("");
			var chart2 = new cfx.Chart();
			var f2 = chart_container2.data("function2");
			f2(chart2);
			chart2.create("currentChart2");
			chart_container2.data("chart2",$("#currentChart2").html());
		}
		else {
			$("#currentChart2").html(html2);
		}

		$("#main2").css({display: "none"});

	}

	function LineChartWithMarkers(chart1)
	{
		// RELEVANT CODE
		chart1.setGallery(cfx.Gallery.Lines);
		// END RELEVANT CODE
		PopulateStatistics(chart1);
		var titles = chart1.getTitles();
		var title = new cfx.TitleDockable();
		title.setText("Yearly Historical Logins");
		titles.add(title);
	}

	function PopulateStatistics(chart1) {
		var items = [
			<?php foreach($hist_logs as $k => &$v)
			{
				echo "{";
				foreach( $v as $key => &$val )
				{
					echo "'".$key."': $val,";
				}
				echo "'Month': '".$k."'
				},";
			}

			 ?>
		];
		chart1.setDataSource(items);
	}




	function LineChartWithMarkers2(chart1)
	{
		// RELEVANT CODE
		chart1.setGallery(cfx.Gallery.Lines);
		// END RELEVANT CODE
		PopulateStatistics2(chart1);
		var titles = chart1.getTitles();
		var title = new cfx.TitleDockable();
		title.setText("Yearly Historical Registrations");
		titles.add(title);
	}

	function PopulateStatistics2(chart1) {
		var items = [
			<?php foreach($hist_regs as $k => &$v)
			{
				echo "{";
				foreach( $v as $key => &$val )
				{
					echo "'".$key."': $val,";
				}
				echo "'Month': '".$k."'
				},";
			}

			 ?>
		];
		chart1.setDataSource(items);
	}
</script>
<div class="jumbotron">
	<h2>Statistics</h2>
	<table style="width: 110%;">
		<tr>
			<td valign="top" style="vertical-align: top; width: 52%;" >
				<div class="simple_stat">
					<div class="simple_stat_left">
						<h3>Total Parents: <span>{parents}</span></span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Total Kids:<span> {kids}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Number of Boys:<span> {boys}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Number of Girls:<span> {girls}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Average Age of Children:<span> {avg_age}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Total Weekly Allowances:<span> {weekly}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Total Monthly Allowances:<span> {monthly}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Total Number of Logins:<span> {logins}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Average Logins per Account:<span> {avg_logins}</span></h3>
					</div>
					<div class="simple_stat_left">
						<h3>Average Time Logged In: <span>{avg_time}</span></h3>
					</div>
				</div>
			</td>
			<td valign="top" style="padding-left:10px; vertical-align: top">
				<div class="simple_stat">
					<div class="simple_stat_right">
						<h3>Total Spend Amount:<span> ${spend}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Total Save Amount:<span> ${save}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Total Give Amount:<span> ${give}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Average Spend Amount:<span> ${avg_spend}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Average Save Amount:<span> ${avg_save}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Average Give Amount:<span> ${avg_give}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Average Allowance Paid:<span> ${avg_all}</span></h3>
					</div>
					<div class="simple_stat_right">
						<h3>Total Money In Banks:<span> ${deposits}</span></h3>
					</div>
				</div>
			</td>
		</tr>
	</table>

	<div id="main">
		<div class="chart_container" id="container_LineChartWithMarkers" ></div>
	</div>
	<div id="currentChart"></div>
	<div id="main2">
		<div class="chart_container2" id="container_LineChartWithMarkers2" ></div>
	</div>
	<div id="currentChart2"></div>
</div><!--/row-->