@extends('layouts.app')

@section('content')
    {{-- @dd(Auth::user()->roles) --}}
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<hr>
                    <div class="card-body">
                        <section class="content">
                            <div class="container-fluid">

                                <!-- Info boxes -->
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info elevation-1"><i
                                                    class="fas fa-users"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text"> Today visits</span>
                                                <span class="info-box-number">
                                                    {{ $today }}

                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                              
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-success elevation-1"><i
                                                    class="fas fa-graduation-cap"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text"> Total encounters </span>
                                                <span class="info-box-number">{{   $totalEncounters }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-danger elevation-1"><i
                                                    class="fas fa-user-tie"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text"> Health worker
                                                    <span class="info-box-number"> {{ $clinic_users }} </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info elevation-1"><i
                                                    class="fas fa-book"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text"> Closed cases</span>
                                                <span class="info-box-number">
                                                    {{ $closed  }}

                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->

                                    <!-- fix for small devices only -->
                                    <div class="clearfix hidden-md-up"></div>
                                          
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <hr>
                              
                                        <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
                                        <!-- /.info-box -->
                                    </div>
                                      <hr>
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <hr>
                              
                                        <div id="chartContainer3" style="height: 300px; width: 100%;"></div>
                                        <!-- /.info-box -->
                                    </div>


                              

                                          <!-- /.col -->
                                     

                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                          
                                <!-- /.row -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('assets/js/canvasjs.min.js') }}"></script>

    <script>
        window.onload = function () {
            // Assuming $dataPoints contains data for each month, and months are represented as numbers (1 to 12)
            var chart = new CanvasJS.Chart("chartContainer", {
            
                theme: "light2", //dark2
                exportEnabled: true,
                exportFileName: "Line Chart",
                animationEnabled: true,
                title: {
                    text: "Number of Visitors by Month (Current Year)",
                    fontSize: 14,
                },
            
                axisY: {
                    title: "Number of Visitors",
                    valueFormatString: "#0",
                    suffix: ""
                },
                axisX: {
                   // title: "Year of months",
                    interval: 1,
                    intervalType: "month",
                    valueFormatString: "MMMM",
                    labelFormatter: function (e) {
                        // Convert month number to month name
                        var monthNames = [
                            "January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        return monthNames[e.value - 1]; // Months are zero-indexed
                    }
                },
                data: [{
                    type: "spline",
                    markerSize: 5,
                    yValueFormatString: "#0",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
    


    var chart2 = new CanvasJS.Chart("chartContainer2", {
 

    theme: "light2", //dark2
    exportEnabled: true,
    exportFileName: "Pie Chart",
	animationEnabled: true,
	title:{
		text: "Patient by Gender Distribution",
        fontSize: 14, // Set the desired font size for the main title
        horizontalAlign: "left"
	},


    data: [{
        type: "pie",
        startAngle: 25,
        toolTipContent: "<b>{label}</b>: {y}%",
        showInLegend: true,
        legendText: "{label}",
        indexLabelFontSize: 16,
        indexLabel: "{label} - {y}%",
        dataPoints: [
            { y: <?php echo $malePercentage; ?>, label: "Male" },
            { y: <?php echo $femalePercentage; ?>, label: "Female" }
            // Add more data points if needed for other genders or categories
        ]
    }]
});




var chart3 = new CanvasJS.Chart("chartContainer3", {
	
    theme: "light2", //dark2
    exportEnabled: true,
    exportFileName: "Doughnut Chart",
	animationEnabled: true,
	title:{
		text: "Classification by Deseas type",
        fontSize: 14, // Set the desired font size for the main title
        horizontalAlign: "left"
	},

	axisY: {
		title: "No of students",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "No of students",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},	
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Emergency",
		legendText: "Emergency",
		showInLegend: true, 
		dataPoints:[
			{ label: "Main", y: 266.21 },
			{ label: "JiT", y: 302.25 },
			{ label: "CAVM", y: 157.20 },
			{ label: "CLG", y: 148.77 },
			{ label: "CNS", y: 101.50 },
			{ label: "CBE", y: 97.8 }
		]
	},
	{
		type: "column",	
		name: "Non-emergency",
		legendText: "Non-emergency",
		axisYType: "secondary",
		showInLegend: true,
		dataPoints:[
			{ label: "Main", y: 10.46 },
			{ label: "JiT", y: 2.27 },
			{ label: "CAVM", y: 3.99 },
			{ label: "CLG", y: 4.45 },
			{ label: "CNS", y: 2.92 },
			{ label: "CNS", y: 3.1 }
		]
	}]
});


function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart3.render();
}



chart.render();
chart2.render();
chart3.render();

}
</script>
    
    
@endsection
