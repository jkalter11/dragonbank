window.onload = function () {	
var chart_LineChartWithMarkers = new cfx.Chart();
	LineChartWithMarkers(chart_LineChartWithMarkers);	
	chart_LineChartWithMarkers.create(document.getElementById("container_LineChartWithMarkers"));
	$("#container_LineChartWithMarkers").data("function",LineChartWithMarkers);
	if ($("#container_LineChartWithMarkers").parent().attr("thumb_type") == "crop") {
		Positioning(chart_LineChartWithMarkers,"","",$("#container_LineChartWithMarkers"),$("#container_LineChartWithMarkers").parent());
	}
	else {
		fix_thumb(chart_LineChartWithMarkers);	
	}
	var chart_DashedLines = new cfx.Chart();
	DashedLines(chart_DashedLines);	
	chart_DashedLines.create(document.getElementById("container_DashedLines"));
	$("#container_DashedLines").data("function",DashedLines);
	if ($("#container_DashedLines").parent().attr("thumb_type") == "crop") {
		Positioning(chart_DashedLines,"","",$("#container_DashedLines"),$("#container_DashedLines").parent());
	}
	else {
		fix_thumb(chart_DashedLines);	
	}
	var chart_LinesWithNegativeValues = new cfx.Chart();
	LinesWithNegativeValues(chart_LinesWithNegativeValues);	
	chart_LinesWithNegativeValues.create(document.getElementById("container_LinesWithNegativeValues"));
	$("#container_LinesWithNegativeValues").data("function",LinesWithNegativeValues);
	if ($("#container_LinesWithNegativeValues").parent().attr("thumb_type") == "crop") {
		Positioning(chart_LinesWithNegativeValues,"","",$("#container_LinesWithNegativeValues"),$("#container_LinesWithNegativeValues").parent());
	}
	else {
		fix_thumb(chart_LinesWithNegativeValues);	
	}
	var chart_MultipleMarkerStyles = new cfx.Chart();
	MultipleMarkerStyles(chart_MultipleMarkerStyles);	
	chart_MultipleMarkerStyles.create(document.getElementById("container_MultipleMarkerStyles"));
	$("#container_MultipleMarkerStyles").data("function",MultipleMarkerStyles);
	if ($("#container_MultipleMarkerStyles").parent().attr("thumb_type") == "crop") {
		Positioning(chart_MultipleMarkerStyles,"","",$("#container_MultipleMarkerStyles"),$("#container_MultipleMarkerStyles").parent());
	}
	else {
		fix_thumb(chart_MultipleMarkerStyles);	
	}
	var chart_CurveChart = new cfx.Chart();
	CurveChart(chart_CurveChart);	
	chart_CurveChart.create(document.getElementById("container_CurveChart"));
	$("#container_CurveChart").data("function",CurveChart);
	if ($("#container_CurveChart").parent().attr("thumb_type") == "crop") {
		Positioning(chart_CurveChart,"","",$("#container_CurveChart"),$("#container_CurveChart").parent());
	}
	else {
		fix_thumb(chart_CurveChart);	
	}
	var chart_StepChart = new cfx.Chart();
	StepChart(chart_StepChart);	
	chart_StepChart.create(document.getElementById("container_StepChart"));
	$("#container_StepChart").data("function",StepChart);
	if ($("#container_StepChart").parent().attr("thumb_type") == "crop") {
		Positioning(chart_StepChart,"","",$("#container_StepChart"),$("#container_StepChart").parent());
	}
	else {
		fix_thumb(chart_StepChart);	
	}
	var chart_RibbonCharts = new cfx.Chart();
	RibbonCharts(chart_RibbonCharts);	
	chart_RibbonCharts.create(document.getElementById("container_RibbonCharts"));
	$("#container_RibbonCharts").data("function",RibbonCharts);
	if ($("#container_RibbonCharts").parent().attr("thumb_type") == "crop") {
		Positioning(chart_RibbonCharts,"","",$("#container_RibbonCharts"),$("#container_RibbonCharts").parent());
	}
	else {
		fix_thumb(chart_RibbonCharts);	
	}
	var chart_Step3D = new cfx.Chart();
	Step3D(chart_Step3D);	
	chart_Step3D.create(document.getElementById("container_Step3D"));
	$("#container_Step3D").data("function",Step3D);
	if ($("#container_Step3D").parent().attr("thumb_type") == "crop") {
		Positioning(chart_Step3D,"","",$("#container_Step3D"),$("#container_Step3D").parent());
	}
	else {
		fix_thumb(chart_Step3D);	
	}
	var chart_ObliqueRibbon = new cfx.Chart();
	ObliqueRibbon(chart_ObliqueRibbon);	
	chart_ObliqueRibbon.create(document.getElementById("container_ObliqueRibbon"));
	$("#container_ObliqueRibbon").data("function",ObliqueRibbon);
	if ($("#container_ObliqueRibbon").parent().attr("thumb_type") == "crop") {
		Positioning(chart_ObliqueRibbon,"","",$("#container_ObliqueRibbon"),$("#container_ObliqueRibbon").parent());
	}
	else {
		fix_thumb(chart_ObliqueRibbon);	
	}	

	$("#main a").click(function(){
		var chart_container = $(this).find(".chart_container");
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
	});
}

function Positioning(chart,x,y,chartDiv,thmbDiv) {
        var topPos = 0, leftPos = 0;
        var maxWidth = chartDiv.width();
        var maxHeight = chartDiv.height();
        var viewBoxY = parseInt(thmbDiv.height());
        var viewBoxX = parseInt(thmbDiv.width());
        if (parseInt(y) >= 0) {
            topPos = (parseInt(y) - viewBoxY / 2) * -1;
            leftPos = (parseInt(x) - viewBoxX / 2) * -1;
        }
        if (topPos > 0) topPos = 0;
        if (topPos < (maxHeight - viewBoxY) * -1) topPos = (maxHeight - viewBoxY) * -1;
        if (leftPos > 0) leftPos = 0;
        if (leftPos < (maxWidth - viewBoxX) * -1) leftPos = (maxWidth - viewBoxX) * -1;
        var styleStr = "margin-top:" + topPos + "px; margin-left:" + leftPos + "px;";
        chartDiv.find("svg").attr('style', styleStr);
		chart.getToolTips().setEnabled(false);		
}

function fix_thumb(chart){
    chart.getAllSeries().setMarkerSize(2);
    chart.setBorder(null);
    chart.getPlotAreaMargin().setTop(5);
    chart.getPlotAreaMargin().setBottom(1);
    chart.getPlotAreaMargin().setRight(1);
    chart.getPlotAreaMargin().setLeft(1);
    chart.getAxisY().setVisible(false);
    chart.getAxisX().setVisible(false);
    chart.setAxesStyle(cfx.AxesStyle.None);
    chart.setBackground(null);
    chart.getToolTips().setEnabled(false);
	chart.getLegendBox().setVisible(false);
	chart.setExtraStyle(((chart.getExtraStyle()) | (cfx.ChartStyles.HideZLabels)));
}

function LineChartWithMarkers(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	// END RELEVANT CODE
	PopulateCarProduction(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Vehicles Production by Month");
	titles.add(title);
}
function DashedLines(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	chart1.getAllSeries().setMarkerShape(cfx.MarkerShape.None);
	chart1.getAllSeries().getLine().setStyle(cfx.DashStyle.DashDot);
	// END RELEVANT CODE
	PopulateProductSales(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Wine Sales by Type");
	titles.add(title);
	chart1.getAxisY().getLabelsFormat().setFormat(cfx.AxisFormat.Currency);
}
function LinesWithNegativeValues(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	chart1.getAllSeries().setMarkerShape(cfx.MarkerShape.None);
	// END RELEVANT CODE
	PopulateBirthVariation(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Yearly Birth Variation by Gender");
	titles.add(title);
	chart1.getAxisY().getTitle().setText("Variation (%)");
}
function MultipleMarkerStyles(chart1)
{
	PopulateMiamiClimate(chart1);
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	chart1.getSeries().getItem(0).setMarkerShape(cfx.MarkerShape.Diamond);
	chart1.getSeries().getItem(1).setMarkerShape(cfx.MarkerShape.HorizontalLine);
	chart1.getSeries().getItem(2).setMarkerShape(cfx.MarkerShape.InvertedTriangle);
	chart1.getSeries().getItem(3).setMarkerShape(cfx.MarkerShape.Marble);
	chart1.getSeries().getItem(4).setMarkerShape(cfx.MarkerShape.VerticalLine);
	// END RELEVANT CODE
	chart1.setStyling(false);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Miami Climate Features in 2012");
	titles.add(title);
	chart1.getAxisY().getTitle().setText("Temperature (°F)");
	// Create additional axis for Precipitation feature
	var axisY = new cfx.AxisY();
	axisY.getGrids().getMajor().setTickMark(cfx.TickMark.None);
	axisY.getGrids().getMajor().setVisible(false);
	axisY.getTitle().setText("inches");
	var series = chart1.getSeries().getItem(3);
	axisY.getTitle().setTextColor(series.getColor());
	axisY.setTextColor(series.getColor());
	chart1.getAxesY().add(axisY);
	series.setAxisY(axisY);
	// Create additional axis for Wind Speed feature
	axisY = new cfx.AxisY();
	axisY.getGrids().getMajor().setTickMark(cfx.TickMark.None);
	axisY.getGrids().getMajor().setVisible(false);
	axisY.getTitle().setText("Knots");
	series = chart1.getSeries().getItem(4);
	axisY.getTitle().setTextColor(series.getColor());
	axisY.setTextColor(series.getColor());
	chart1.getAxesY().add(axisY);
	series.setAxisY(axisY);
	// Create additional axis for Relative Humidity feature
	axisY = new cfx.AxisY();
	axisY.getGrids().getMajor().setTickMark(cfx.TickMark.None);
	axisY.getGrids().getMajor().setVisible(false);
	axisY.getTitle().setText("g/m3");
	series = chart1.getSeries().getItem(5);
	axisY.getTitle().setTextColor(series.getColor());
	axisY.setTextColor(series.getColor());
	chart1.getAxesY().add(axisY);
	series.setAxisY(axisY);
}
function CurveChart(chart1)
{
	PopulateCarProduction(chart1,"Sedan,Coupe");
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Curve);
	// END RELEVANT CODE
	chart1.getAllSeries().setMarkerShape(cfx.MarkerShape.None);
	chart1.getLegendBox().setDock(cfx.DockArea.Bottom);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Monthly Vehicle Production Sedan vs. Coupe");
	titles.add(title);
}
function StepChart(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Step);
	chart1.getAllSeries().setMarkerShape(cfx.MarkerShape.None);
	// END RELEVANT CODE
	PopulatePopulationData(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("US Population by Age Range");
	titles.add(title);
	title = new cfx.TitleDockable();
	title.setText("(In Thousands)");
	titles.add(title);
}
function RibbonCharts(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	chart1.getView3D().setEnabled(true);
	// END RELEVANT CODE
	PopulateCarProduction(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Vehicles Production by Month");
	titles.add(title);
}
function Step3D(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Step);
	chart1.getView3D().setEnabled(true);
	// END RELEVANT CODE
	PopulateProductSales(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Wine Sales by Type");
	titles.add(title);
	chart1.getAxisY().getLabelsFormat().setFormat(cfx.AxisFormat.Currency);
}
function ObliqueRibbon(chart1)
{
	// RELEVANT CODE
	chart1.setGallery(cfx.Gallery.Lines);
	chart1.getView3D().setEnabled(true);
	chart1.getView3D().setAngleX(45);
	// END RELEVANT CODE
	PopulateCarProduction(chart1);
	var titles = chart1.getTitles();
	var title = new cfx.TitleDockable();
	title.setText("Vehicles Production by Month");
	titles.add(title);
}

function PopulateCarProduction(chart1) {
        var items = [{
            "Sedan": 1760,
            "Coupe": 535,
            "SUV": 695,
            "Month": "Jan"
        }, {
            "Sedan": 1849,
            "Coupe": 395,
            "SUV": 688,
            "Month": "Feb"
        }, {
            "Sedan": 2831,
            "Coupe": 685,
            "SUV": 1047,
            "Month": "Mar"
        }, {
            "Sedan": 2851,
            "Coupe": 984,
            "SUV": 1652,
            "Month": "Apr"
        }, {
            "Sedan": 2961,
            "Coupe": 1579,
            "SUV": 1889,
            "Month": "May"
        }, {
            "Sedan": 1519,
            "Coupe": 1539,
            "SUV": 1766,
            "Month": "Jun"
        }, {
            "Sedan": 2633,
            "Coupe": 1489,
            "SUV": 1361,
            "Month": "Jul"
        }, {
            "Sedan": 1140,
            "Coupe": 650,
            "SUV": 874,
            "Month": "Aug"
        }, {
            "Sedan": 1626,
            "Coupe": 653,
            "SUV": 693,
            "Month": "Sep"
        }, {
            "Sedan": 1478,
            "Coupe": 2236,
            "SUV": 786,
            "Month": "Oct"
        }, {
            "Sedan": 1306,
            "Coupe": 1937,
            "SUV": 599,
            "Month": "Nov"
        }, {
            "Sedan": 1607,
            "Coupe": 2138,
            "SUV": 678,
            "Month": "Dec"
        }];
    
    
        chart1.setDataSource(items);
    }
    function PopulateProductSales(chart1) {
        var items = [{
            "Month": "Jan",
            "White": 12560,
            "Red": 23400,
            "Sparkling": 34500
        }, {
            "Month": "Feb",
            "White": 13400,
            "Red": 21000,
            "Sparkling": 38900
        }, {
            "Month": "Mar",
            "White": 16700,
            "Red": 17000,
            "Sparkling": 42100
        }, {
            "Month": "Apr",
            "White": 12000,
            "Red": 19020,
            "Sparkling": 43800
        }, {
            "Month": "May",
            "White": 15800,
            "Red": 26500,
            "Sparkling": 37540
        }, {
            "Month": "Jun",
            "White": 9800,
            "Red": 27800,
            "Sparkling": 32580
        }, {
            "Month": "Jul",
            "White": 17800,
            "Red": 29820,
            "Sparkling": 34000
        }, {
            "Month": "Aug",
            "White": 19800,
            "Red": 17800,
            "Sparkling": 38000
        }, {
            "Month": "Sep",
            "White": 23200,
            "Red": 32000,
            "Sparkling": 41300
        }, {
            "Month": "Oct",
            "White": 16700,
            "Red": 26500,
            "Sparkling": 46590
        }, {
            "Month": "Nov",
            "White": 11800,
            "Red": 23000,
            "Sparkling": 48700
        }, {
            "Month": "Dec",
            "White": 13400,
            "Red": 15400,
            "Sparkling": 49100
        }];
    
        chart1.setDataSource(items);
    }
    function PopulateBirthVariation(chart1) {
        var items = [{
            "Year": "2007",
            "Male": 4.5,
            "Female": 4.9
        }, {
            "Year": "2008",
            "Male": -1.8,
            "Female": 1.2
        }, {
            "Year": "2009",
            "Male": 2.3,
            "Female": -2.6
        }, {
            "Year": "2010",
            "Male": 2,
            "Female": 3
        }, {
            "Year": "2011",
            "Male": -0.5,
            "Female": -1.7
        }, {
            "Year": "2012",
            "Male": 3.1,
            "Female": -0.9
        }];
    
        chart1.setDataSource(items);
    }
    function PopulateMiamiClimate(chart1) {
        var items = [{
            "Month": "Jan",
            "Low": 59.6,
            "High": 76.5,
            "Average": 67.2,
            "Precipitation": 1.88,
            "WindSpeed": 9.5,
            "RelativeHumidity": 59
        }, {
            "Month": "Feb",
            "Low": 60.5,
            "High": 77.7,
            "Average": 68.5,
            "Precipitation": 2.07,
            "WindSpeed": 10.1,
            "RelativeHumidity": 71
        }, {
            "Month": "Mar",
            "Low": 64,
            "High": 80.7,
            "Average": 71.7,
            "Precipitation": 2.56,
            "WindSpeed": 10.5,
            "RelativeHumidity": 69.5
        }, {
            "Month": "Apr",
            "Low": 67.6,
            "High": 83.8,
            "Average": 75.2,
            "Precipitation": 3.36,
            "WindSpeed": 10.5,
            "RelativeHumidity": 67.5
        }, {
            "Month": "May",
            "Low": 72,
            "High": 87.2,
            "Average": 78.7,
            "Precipitation": 5.52,
            "WindSpeed": 9.5,
            "RelativeHumidity": 67
        }, {
            "Month": "Jun",
            "Low": 75.2,
            "High": 89.5,
            "Average": 81.4,
            "Precipitation": 8.54,
            "WindSpeed": 8.3,
            "RelativeHumidity": 71
        }, {
            "Month": "Jul",
            "Low": 76.5,
            "High": 90.9,
            "Average": 82.6,
            "Precipitation": 5.79,
            "WindSpeed": 7.9,
            "RelativeHumidity": 74
        }, {
            "Month": "Aug",
            "Low": 76.5,
            "High": 90.6,
            "Average": 82.8,
            "Precipitation": 8.63,
            "WindSpeed": 7.9,
            "RelativeHumidity": 74
        }, {
            "Month": "Sep",
            "Low": 75.7,
            "High": 89,
            "Average": 81.9,
            "Precipitation": 8.38,
            "WindSpeed": 8.2,
            "RelativeHumidity": 76
        }, {
            "Month": "Oct",
            "Low": 72.2,
            "High": 85.4,
            "Average": 78.3,
            "Precipitation": 6.19,
            "WindSpeed": 9.2,
            "RelativeHumidity": 76
        }, {
            "Month": "Nov",
            "Low": 67.5,
            "High": 81.2,
            "Average": 73.6,
            "Precipitation": 3.43,
            "WindSpeed": 9.7,
            "RelativeHumidity": 74
        }, {
            "Month": "Dec",
            "Low": 62.2,
            "High": 77.5,
            "Average": 69.1,
            "Precipitation": 2.18,
            "WindSpeed": 9.2,
            "RelativeHumidity": 73
        }];
    
    
        chart1.setDataSource(items);
    }
    function PopulatePopulationData(chart1) {
        var items = [{
            "Range": "0-4",
            "Male": 10471,
            "Female": 10024
        }, {
            "Range": "5-9",
            "Male": 9954,
            "Female": 9512
        }, {
            "Range": "10-14",
            "Male": 10670,
            "Female": 10167
        }, {
            "Range": "15-19",
            "Male": 10871,
            "Female": 10312
        }, {
            "Range": "20-24",
            "Male": 10719,
            "Female": 10178
        }, {
            "Range": "25-29",
            "Male": 10060,
            "Female": 9744
        }, {
            "Range": "30-34",
            "Male": 10021,
            "Female": 9864
        }, {
            "Range": "35-39",
            "Male": 10479,
            "Female": 10424
        }, {
            "Range": "40-44",
            "Male": 11294,
            "Female": 11454
        }, {
            "Range": "45-49",
            "Male": 11080,
            "Female": 11377
        }, {
            "Range": "50-54",
            "Male": 9772,
            "Female": 10212
        }, {
            "Range": "55-59",
            "Male": 8415,
            "Female": 8944
        }, {
            "Range": "60-64",
            "Male": 6203,
            "Female": 6814
        }, {
            "Range": "65-69",
            "Male": 4712,
            "Female": 5412
        }, {
            "Range": "70-74",
            "Male": 3804,
            "Female": 4697
        }, {
            "Range": "75-79",
            "Male": 3094,
            "Female": 4282
        }, {
            "Range": "80-84",
            "Male": 2117,
            "Female": 3459
        }, {
            "Range": "85-89",
            "Male": 1072,
            "Female": 2135
        }, {
            "Range": "90-94",
            "Male": 397,
            "Female": 1034
        }, {
            "Range": "95-99",
            "Male": 91,
            "Female": 321
        }, {
            "Range": "100+",
            "Male": 12,
            "Female": 58
        }];
    
        chart1.setDataSource(items);
    }