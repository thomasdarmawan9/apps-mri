</div>


</body>

    <!--   Core JS Files   -->

	<script src="assets/themplate/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/themplate/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/themplate/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/themplate/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/themplate/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/themplate/js/demo.js"></script>

	<?php if (!empty($_GET['event']) and ($_GET['event']=='beranda')){ ?>
	<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Selamat datang para warrior, semoga aplikasi ini bisa membantu para warriors."

            },{
                type: 'info',
                timer: 4000
            });

    	});
	</script>
	<?php } ?>

</html>
