<style type="text/css">
.border-left-div {
    border-left: 2px solid #333;
}
</style>

<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery-ui/jquery-ui.theme.min.css" />
<div class="row mb-3">
    <div class="col-md-12">
        <ul class="list-group inline" id="list-tab" role="tablist" style="flex-direction:row;list-style-type:none;">
            <li>
                <a class="list-group-item list-group-item-action active" href="#regular" role="tab" data-toggle="tab"
                    aria-controls="regular" aria-selected="true">Regular Class</a>
            </li>
            <li>
                <a class="list-group-item list-group-item-action" href="#adult" role="tab" data-toggle="tab"
                    aria-controls="adult" aria-selected="false">Adult Class</a>
            </li>
        </ul>
    </div>
</div>
<div class="tab-content">
    <div class="tab-pane fade show active" id="regular" role="tabpanel" aria-labelledby="home-regular">
        <div class="row">
            <?php 
				foreach($regular as $row){
			?>
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-body" id="<?= 'regular-'.$row['id']?>">
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="tab-pane fade show" id="adult" role="tabpanel" aria-labelledby="home-adult">
        <div class="row">
            <?php 
				foreach($adult as $row){
			?>
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-body" id="<?= 'adult-'.$row['id']?>">
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url();?>inc/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>inc/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?= base_url();?>inc/highcharts/exporting.js"></script>
<script type="text/javascript" src="<?= base_url();?>inc/highcharts/export-data.js"></script>

<script>
$(document).ready(function() {
    $(document).ajaxStart(function() {
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function() {
        $("#wait").css("display", "none");
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('#table1').DataTable({
        'scrollX': true,
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ]
    });

    <?php 
		$total_branch = count($branch);
		foreach($stat_regular as $row){
	?>
    Highcharts.chart('<?= "regular-".$row["program_id"]?>', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<?= $row["program"]?>'
        },
        xAxis: {
            categories: [
                <?php 
	           		foreach($status as $row1){
	           			echo "'".$row1."',";
	           		}
		           ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} student</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
            enabled: false
        },
        series: [
            <?php 
		    	for($i = 0; $i < $total_branch; $i++){
			    	echo "{";
			    	echo "name: '".$row[$i]['name']."',";
			    	echo "data:[";
			    	foreach($row[$i]['data'] as $row2){
	        			echo intval($row2['value']).",";
	        		}
			    	echo "],";
			    	echo "},";
		    	}
		    ?>
        ]
    });
    <?php } ?>

	<?php 
		foreach($stat_adult as $row){
	?>
    Highcharts.chart('<?= "adult-".$row["program_id"]?>', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<?= $row["program"]?>'
        },
        xAxis: {
            categories: [
                <?php 
	           		foreach($status as $row1){
	           			echo "'".$row1."',";
	           		}
		           ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} student</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
            enabled: false
        },
        series: [
            <?php 
		    	for($i = 0; $i < $total_branch; $i++){
			    	echo "{";
			    	echo "name: '".$row[$i]['name']."',";
			    	echo "data:[";
			    	foreach($row[$i]['data'] as $row2){
	        			echo intval($row2['value']).",";
	        		}
			    	echo "],";
			    	echo "},";
		    	}
		    ?>
        ]
    });
    <?php } ?>

//     Highcharts.chart('chart_all', {
//         chart: {
//             type: 'column'
//         },
//         title: {
//             text: 'Data Status Student Semua Cabang'
//         },
//         xAxis: {
//             categories: [
//                 <?php 
// 	           		foreach($all as $row){
// 	           			echo "'".$row['label']."',";
// 	           		}
// 		           ?>
//             ],
//             crosshair: true
//         },
//         yAxis: {
//             min: 0,
//             title: {
//                 text: 'Jumlah'
//             }
//         },
//         tooltip: {
//             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
//                 '<td style="padding:0"><b>{point.y:.1f} student</b></td></tr>',
//             footerFormat: '</table>',
//             shared: true,
//             useHTML: true
//         },
//         plotOptions: {
//             column: {
//                 pointPadding: 0.2,
//                 borderWidth: 0
//             }
//         },
//         credits: {
//             enabled: false
//         },
//         series: [{
//             name: 'Status',
//             colorByPoint: true,
//             data: [
//                 <?php 
	        			
// 		        		foreach($all as $row){
// 		        			echo intval($row['value']).",";
// 		        		}
// 		        	?>

//             ]
//         }]
//     });


});


function reload_page() {
    window.location.reload();
}
</script>