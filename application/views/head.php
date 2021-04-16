<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Warriors Application</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/themplate/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/themplate/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/themplate/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/themplate/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/themplate/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    <?php if((!empty($_GET['event'])) and ($_GET['event']=='beranda')) { ?>
    <link class="main-stylesheet" href="assets/css/dashboard.css" rel="stylesheet" type="text/css"/>
    <?php } ?>
    
    
    	<link href='assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='assets/fullcalendar/lib/moment.min.js'></script>
	<script src='assets/fullcalendar/lib/jquery.min.js'></script>
	<script src='assets/fullcalendar/fullcalendar.min.js'></script>
	<script>
	$(document).ready(function(){
	    $(".close").click(function(){
	        $("#myAlert").alert("close");
	    });
	});
	</script>
	<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2016-09-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2016-09-01'
				},
				{
					title: 'Long Event',
					start: '2016-09-07',
					end: '2016-09-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-09-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-09-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2016-09-11',
					end: '2016-09-13'
				},
				{
					title: 'Meeting',
					start: '2016-09-12T10:30:00',
					end: '2016-09-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2016-09-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2016-09-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2016-09-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2016-09-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2016-09-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-09-28'
				}
			]
		});
		
	});

</script>
	
	<style>


	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	h2 {
	    font-size: 20px;
	    font-weight: bold;
	    color: gray;
	}


	body{
		overflow-y: hidden;
	}
	</style>
    
</head>
<body>