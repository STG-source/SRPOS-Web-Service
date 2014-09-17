<!DOCTYPE html>
<html lang="th">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<title>Report</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Chart.js -->
	<script src="js/Chart.min.js"></script>
	
	<!-- jQuery UI -->
	<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
	<script src="jquery-ui/jquery-ui.min.js"></script>
	<!-- nProgress -->
	<script src='nprogress/nprogress.js'></script>
	<link rel='stylesheet' href='nprogress/nprogress.css'/>
	<!-- Last CSS -->
	<link href="dashboard.css" rel="stylesheet">
</head>
<body>
<!--
<div class="container" style="background:#eee;">
	<div class="col-md-4">
		<div>
		</div>
		<div>
			<a href="#">Sales Summary</a>
			<a href="#">Sold Items</a>
			<a href="#">Hourly Sales</a>
		</div>
	</div>
	<div class="col-md-8">
		Report View
		<div id="report-sales_summary">
			<div class="graph">
				<canvas id="canvas-graph-amount_vs_balance"></canvas>
			</div>
			<div class="graph">
				<canvas id="canvas-graph-qty_vs_bill"></canvas>
			</div>
			<div class="graph">
				<canvas id="canvas-graph-amount_per_ticket"></canvas>
			</div>
			<div class="graph">
				<canvas id="canvas-graph-quantity_per_ticket"></canvas>
			</div>
		</div>
		<div id="report-sold_items" style="display:none;">
		</div>
	</div>
</div>
-->
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Dashboard</h1>
				<div id="whileLoading">
					<div class="progress">
					  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
						100%
					  </div>
					</div>
				</div>
				<div id="showPeriod"><h2>Monthly Report : <span class="preriod"></span></h2></div>
				<div id="showReport">
					<div id="report-sales_summary" class="report" style="display:none;">
						<div>
							<h2>Overview</h2>
							<div id="overview">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Bill (Ticket)</th>
											<th>Sales Amount</th>
											<th>Discount</th>
											<th>Sales Balance</th>
											<th>Sales Quantity</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="sBill">0</td>
											<td class="sAmount">0</td>
											<td class="sDiscount">0</td>
											<td class="sBalance">0</td>
											<td class="sQuantity">0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="graph">
							<h2>Sales Amount Vs Sales Balance</h2>
							<canvas id="canvas-graph-amount_vs_balance"></canvas>
							<div class="center-block">
								<span class="glyphicon glyphicon-stop" style="color:rgba(65,152,175,0.5);">&nbsp;</span>Sales Amount
								<span class="glyphicon glyphicon-stop" style="color:rgba(145,195,213,0.5);">&nbsp;</span>Sales Balance
							</div>
						</div>
						<div class="graph">
							<h2>Sales Qty Vs Bill(Ticket)</h2>
							<canvas id="canvas-graph-qty_vs_bill"></canvas>
							<div class="center-block">
								<span class="glyphicon glyphicon-stop" style="color:rgba(219,132,61,0.5);">&nbsp;</span>Sales Qty
								<span class="glyphicon glyphicon-stop" style="color:rgba(249,181,144,0.5);">&nbsp;</span>Bill(Ticket)
							</div>
						</div>
						<div class="graph">
							<h2>Sales Amount Per Ticket (SA/Ticket)</h2>
							<canvas id="canvas-graph-amount_per_ticket"></canvas>
							<div class="center-block">
								<span class="glyphicon glyphicon-stop" style="color:rgba(151,187,205,0.7);">&nbsp;</span>SA/Ticket - WeekDay
								<span class="glyphicon glyphicon-stop" style="color:rgba(151,0,0,0.7);">&nbsp;</span>SA/Ticket - WeekEnd
								<span class="glyphicon glyphicon-stop" style="color:rgba(170,170,170,0.7);">&nbsp;</span>SA/Ticket - Linear
							</div>
						</div>
						<div class="graph">
							<h2>Sales Quantity Per Ticket (SQ/Ticket)</h2>
							<canvas id="canvas-graph-quantity_per_ticket"></canvas>
							<div class="center-block">
								<span class="glyphicon glyphicon-stop" style="color:rgba(151,187,205,0.7);">&nbsp;</span>SQ/Ticket - WeekDay
								<span class="glyphicon glyphicon-stop" style="color:rgba(151,0,0,0.7);">&nbsp;</span>SQ/Ticket - WeekEnd
								<span class="glyphicon glyphicon-stop" style="color:rgba(170,170,170,0.7);">&nbsp;</span>SQ/Ticket - Linear
							</div>
						</div>
						<div id="graphTop10">
							<h2></h2>
							<canvas id="canvas-graph-quantity_per_ticket"></canvas>
						</div>
						
					</div>
					<div id="report-sold_items" class="report" style="display:none;">
						<div>
							<h2>Sold Items</h2>
							<div class="display"></div>
						</div>
					</div>
					<div id="report-hourlysales" class="report" style="display:none;">
						<div>
							<h2>Hourly Sales</h2>
							<div class="display"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-md-2 sidebar">
				<div class="row">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputDateStart" class="col-sm-3 control-label">Start Date</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="dateStart" placeholder="Start Date">
							</div>
						</div>
						<div class="form-group">
							<label for="inputDateEnd" class="col-sm-3 control-label">End Date</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="dateEnd" placeholder="End Date">
							</div>
						</div>
					</form>
				</div>
					<ul class="nav nav-sidebar" id="navSideBar">
						<li class="active"><a href="#" class="btn_overview">Overview</a></li>
						<li><a href="#" class="btn_solditems">Sold Items</a></li>
						<li><a href="#" class="btn_hourlysales">Hourly Sales</a></li>
					</ul>
				<div class="row other">
					ui v0.2 core v0.7
				</div>
			</div>
<script>
var dataGraphSummery;
window.top10chart = [];
$(document).ready(function(){
	/* init chart config */
	Chart.defaults.global.responsive = true;
	Chart.defaults.global.maintainAspectRatio = true;
	Chart.defaults.global.showScale = true;
	
	/* Datepicker Select a Date Range*/
	$( "#dateStart" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "-1w",
		changeMonth: true,
		firstDay: 1,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#dateEnd" ).datepicker( "option", "minDate", selectedDate );
			if(!$( "#dateEnd" ).val())
				$( "#dateEnd" ).datepicker( "option", "defaultDate", selectedDate );
		}
	});
	$( "#dateEnd" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		firstDay: 1,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#dateStart" ).datepicker( "option", "maxDate", selectedDate );
			if(!$( "#dateStart" ).val())
				$( "#dateStart" ).datepicker( "option", "defaultDate", selectedDate );
		}
	});
	/* navSideBar */
	$( ".btn_overview" ).click(function(){
		$('#navSideBar li').removeClass('active');
		$(this).parent().addClass('active');
		$('.report').hide();
		$('#report-sales_summary').show();
		monthReportPeriod();
		NProgress.start();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				//Download progress
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = (evt.loaded / evt.total) * 100;
						//Do something with download progress
						NProgress.inc();
						//console.log(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			type: "POST",
			url: "load_summary.php",
			data: { startDate: $("#dateStart").val(), endDate: $("#dateEnd").val() },
			dataType: "jsonp"
		}).done(function( msg ) {
			NProgress.done();
			//console.log('-- SUMMARY --');
			dataGraphSummery = msg;
			generateGraphSummery();
		});
	});
	
	$( ".btn_solditems" ).click(function(){
		$('#navSideBar li').removeClass('active');
		$(this).parent().addClass('active');
		$('.report').hide();
		$('#report-sold_items').show();
		monthReportPeriod();
		NProgress.start();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				//Download progress
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = (evt.loaded / evt.total) * 100;
						//Do something with download progress
						NProgress.inc();
						//console.log(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			type: "POST",
			url: "load_solditem.php",
			data: { startDate: $("#dateStart").val(), endDate: $("#dateEnd").val() },
			dataType: "html"
		}).done(function( msg ) {
			NProgress.done();
			$("#report-sold_items .display").html(msg);
		});
	});
	
	$( ".btn_hourlysales" ).click(function(){
		$('#navSideBar li').removeClass('active');
		$(this).parent().addClass('active');
		$('.report').hide();
		$('#report-hourlysales').show();
		monthReportPeriod();
		NProgress.start();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				//Download progress
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = (evt.loaded / evt.total) * 100;
						//Do something with download progress
						NProgress.inc();
						//console.log(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			type: "POST",
			url: "load_hourlysales.php",
			data: { startDate: $("#dateStart").val(), endDate: $("#dateEnd").val() },
			dataType: "html"
		}).done(function( msg ) {
			NProgress.done();
			$("#report-hourlysales .display").html(msg);
		});
	});
	
});
function monthReportPeriod(){
	var startDateText = $.datepicker.formatDate( "dd MM", $.datepicker.parseDate( "yy-mm-dd", $("#dateStart").val() ) );
	var endDateText = $.datepicker.formatDate( "dd MM", $.datepicker.parseDate( "yy-mm-dd", $("#dateEnd").val() ) );
	var startDateText = $.datepicker.formatDate( "dd MM", $.datepicker.parseDate( "yy-mm-dd", $("#dateStart").val() ) );
	var dayDiff = (($.datepicker.parseDate( "yy-mm-dd", $("#dateEnd").val() ) - $.datepicker.parseDate( "yy-mm-dd", $("#dateStart").val() ))/ (1000 * 60 * 60 * 24))+1;
	$('.preriod').html( startDateText + " - " + endDateText + "(" + dayDiff + " Days)");
	$('#showPeriod').show();
}
function generateGraphSummery(){
	$( "#overview .sBill" ).html(dataGraphSummery.overview.bill);
	$( "#overview .sAmount" ).html(dataGraphSummery.overview.amount);
	$( "#overview .sDiscount" ).html(dataGraphSummery.overview.discount);
	$( "#overview .sBalance" ).html(dataGraphSummery.overview.balance);
	$( "#overview .sQuantity" ).html(dataGraphSummery.overview.qty);
	
	var DATAamount_vs_balance = {
		labels : dataGraphSummery.weekData.labels,
		datasets : [
			{
				label: "Sales Amount",
				//fillColor : "rgba(220,220,220,0.2)",
				fillColor : "rgba(65,152,175,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				highlightFill: "rgba(65,152,175,0.8)",
				highlightStroke: "rgba(220,220,220,1)",
				data : dataGraphSummery.weekData.amount
			},
			{
				label: "Sales Balance",
				//fillColor : "rgba(151,187,205,0.2)",
				fillColor : "rgba(145,195,213,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				highlightFill: "rgba(145,195,213,0.8)",
				highlightStroke: "rgba(220,220,220,1)",
				data : dataGraphSummery.weekData.balance
			}
		]
	}
	var DATAqty_vs_bill = {
		labels : dataGraphSummery.weekData.labels,
		datasets : [
			{
				label: "Sales Qty",
				//fillColor : "rgba(220,220,220,0.2)",
				fillColor : "rgba(219,132,61,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				//highlightFill: "rgba(220,220,220,0.75)",
				highlightFill : "rgba(219,132,61,0.8)",
				highlightStroke: "rgba(220,220,220,1)",
				data : dataGraphSummery.weekData.qty
			},
			{
				label: "Bill(Ticket)",
				//fillColor : "rgba(151,187,205,0.2)",
				fillColor : "rgba(249,181,144,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				//highlightFill: "rgba(151,187,205,0.75)",
				highlightFill : "rgba(249,181,144,0.8)",
				highlightStroke: "rgba(220,220,220,1)",
				data : dataGraphSummery.weekData.bill
			}
		]
	}
	var DATAamount_per_ticket = {
		labels : dataGraphSummery.weekData.labels,
		datasets : [
			{
				label: "SA/Ticket - WeekDay",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data : dataGraphSummery.weekData.saPticketWeekDay
			},
			{
				label: "SA/Ticket - WeekEnd",
				fillColor: "rgba(151,0,0,0.2)",
				strokeColor: "rgba(151,0,0,1)",
				pointColor: "rgba(151,0,0,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,0,0,1)",
				data : dataGraphSummery.weekData.saPticketWeekEnd
			},
			{
				label: "SA/Ticket - Linear",
				fillColor: "rgba(170,170,170,0.2)",
				strokeColor: "rgba(170,170,170,1)",
				pointColor: "rgba(170,170,170,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(170,170,170,1)",
				data : dataGraphSummery.weekData.saPticketLinear
			}
		]
	}
	var DATAqty_per_ticket = {
		labels : dataGraphSummery.weekData.labels,
		datasets : [
			{
				label: "SA/Ticket - WeekDay",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data : dataGraphSummery.weekData.sqPticketWeekDay
			},
			{
				label: "SA/Ticket - WeekEnd",
				fillColor: "rgba(151,0,0,0.2)",
				strokeColor: "rgba(151,0,0,1)",
				pointColor: "rgba(151,0,0,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,0,0,1)",
				data : dataGraphSummery.weekData.sqPticketWeekEnd
			},
			{
				label: "SA/Ticket - Linear",
				fillColor: "rgba(170,170,170,0.2)",
				strokeColor: "rgba(170,170,170,1)",
				pointColor: "rgba(170,170,170,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(170,170,170,1)",
				data : dataGraphSummery.weekData.sqPticketLinear
			}
		]
	}
	/* start draw graph */
	var ctx = document.getElementById("canvas-graph-amount_vs_balance").getContext("2d");
	if(window.amount_vs_balance)
		window.amount_vs_balance.destroy();
	window.amount_vs_balance = new Chart(ctx).Bar(DATAamount_vs_balance,{
		barShowStroke: true
	});
	var ctx = document.getElementById("canvas-graph-qty_vs_bill").getContext("2d");
	if(window.qty_vs_bill)
		window.qty_vs_bill.destroy();
	window.qty_vs_bill = new Chart(ctx).Bar(DATAqty_vs_bill,{});
	var ctx = document.getElementById("canvas-graph-amount_per_ticket").getContext("2d");
	if(window.amount_per_ticket)
		window.amount_per_ticket.destroy();
	window.amount_per_ticket = new Chart(ctx).Line(DATAamount_per_ticket,{
		bezierCurve : false,
		datasetFill : false});
	var ctx = document.getElementById("canvas-graph-quantity_per_ticket").getContext("2d");
	if(window.qty_per_ticket)
		window.qty_per_ticket.destroy();
	window.qty_per_ticket = new Chart(ctx).Line(DATAqty_per_ticket,{
		bezierCurve : false,
		datasetFill : false});
	/* top10 graph */
	if(window.top10chart){
		for(var i = 0;i < window.top10chart.length;i++) {
			window.top10chart.pop().destroy();
		}
	}
	$("#graphTop10").html('<div class="row"></div>');
	for(var i = 0;i < dataGraphSummery.top10.length;i++) {
		$("#graphTop10 .row").append('<div class="col-md-6"><h2>Top10 '+dataGraphSummery.top10[i].label+'</h2><canvas id="canvas-pie-top10-'+i+'"></canvas></div>');
		//console.log(dataGraphSummery.top10[i]);
		var dataTopSet = [];
		var colorSet = ["#4572a7","#aa4643","#89a54e","#71588f","#4198af","#db843d","#93a9cf","#d19392","#b9cd96","#a99bbd"];
		for(var j = 0;j < dataGraphSummery.top10[i].list.length;j++){
			var tempObj = {
				value: dataGraphSummery.top10[i].list[j].total,
				color: colorSet[j],
				highlight: colorSet[j],
				label: dataGraphSummery.top10[i].list[j].name
			}
			dataTopSet.push(tempObj);
		}
		//console.log(dataTopSet);
		var ctx = document.getElementById("canvas-pie-top10-"+i).getContext("2d");
		var tempPieChart = new Chart(ctx).Pie(dataTopSet,{
			tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>\%"
		});
		window.top10chart.push(tempPieChart);
	}
}
</script>
	</body>
</html>
