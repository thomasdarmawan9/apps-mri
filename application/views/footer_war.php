
</div>
<!-- SCRIPTS -->
<!-- JQuery -->
<!-- <script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/jquery-3.2.1.min.js"></script> -->
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/popper.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/mdb.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?= base_url(); ?>inc/mdb/js/bootstrap.min.js"></script>

<!--Mo.min.js
<script type="text/javascript" src="<?= base_url(); ?>inc/mojs/mo.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>inc/mojs/custom.js"></script>-->

<!-- Custom Scroller Js CDN -->
<script src="<?= base_url(); ?>inc/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$("#sidebar").mCustomScrollbar({
			theme: "minimal"
		});

		$('#sidebarCollapse').on('click', function () {
			$('#sidebar, #content, .logo').toggleClass('active');
			$('.collapse.in').toggleClass('in');
			$('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});
		
		$(function () {
			$('[data-toggle="popover"]').popover()
		});

		$(document).ajaxStart(function(){
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function(){
			$("#wait").css("display", "none");
		});
		
		$('.page-content').addClass('viewMobile');

	});
</script>

<script type="text/javascript">
	var success = "<?= $this->session->flashdata('success');?>";
	var error = "<?= $this->session->flashdata('error');?>";
	var info = "<?= $this->session->flashdata('info');?>";
	
	if(success != ''){
		swal('Success', success, 'success');
	}
	if(error != ''){
		swal('Error', error, 'error');
	}
	if(info != ''){
		swal('Info', info, 'info');
	}
</script>



</body>
</html>