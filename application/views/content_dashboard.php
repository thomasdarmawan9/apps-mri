<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/atlantis/assets/css/atlantis.min.css">
<style>
    #gradient_panel_dashboard {
		background-image: linear-gradient(to bottom right, #202940, white);
	}
</style>
<?php if (!empty($this->session->flashdata('ultah'))){ ?>

        <?php if(!empty($photo)){ ?>
        <link rel="stylesheet" href="<?= base_url('inc/owlcarousel/dist/assets/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('inc/owlcarousel/dist/assets/owl.theme.default.min.css') ?>">
        
         <style>
             
             #owl-demo .item{
              margin: 3px;
            }
            #owl-demo .item img{
              display: block;
              width: 100%;
              height: auto;
            }
            .owl-next, .owl-prev{
                font-size:15pt !important;
                color:white;
            }
            
            .img-show{
                border-radius: 100px;
            }

         </style>
         
         <script src="<?= base_url('inc/owlcarousel/dist/owl.carousel.min.js'); ?> "></script>
        <script type="text/javascript">
        
            $(document).ready(function(){
              $(".owl-carousel").owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:2
                        },
                        1000:{
                            items:3
                        }
                    }
                });
              $('#photoModal').modal('show');
              $('#photoModal').addClass('animated jello delay-5s');
            });
    
        </script>
        
        <!-- Modal Instagram -->
        <div class="modal fade" id="photoinstaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #3897f0;color: white;">
                        <h5 class="modal-title" id="exampleModalLabel">Warrior Story</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container text-center my-3">
                            
                            <div class="owl-carousel">
                                <?php foreach ($instagram as $p){ ?>
                                    <div>
                                            <blockquote class="instagram-media w-100" data-instgrm-permalink="<?= $p->link_warrior_story; ?>" data-instgrm-version="9" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                         			            <div style="padding:8px;">
                         			                <div class="w-100" style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;">
                         			                    <div class="w-100" style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;">
                         			                        
                         			                    </div>
                         			                </div>
                         			            </div>
                         			        </blockquote> <script async defer src="//www.instagram.com/embed.js"></script>
                                    </div>
                                <?php } ?>
                              
                            </div>
        
            
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-primary">
                        <a href="<?= base_url('user/instagram'); ?>"><button type="button" class="btn btn-light" style="color: black !important;background: white !important;">Warrior Story <i class="far fa-hand-point-right"></i></button></a>
                    </div>
                    
                </div>
            </div>
        </div><!-- Modal Photo -->
        
    <?php } //End Photo ?>
        
        <!-- Modal photo -->
        <div class="modal fade"  id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Your Picture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: url(<?= base_url('inc/image/bg-photo.jpg'); ?>);
            background-size: 100%;">
                        <div class="container text-center my-3">
                            
                            <div class="owl-carousel">
                                <?php foreach ($photo as $p){ ?>
                                    <div> <img class="img-thumbnail img-show img-fluid z-depth-1-half rounded-circle" src="<?= base_url('inc/image/warriors/pp/'.$p->picture); ?>">
                                    <label class="badge badge-danger"><?= ucfirst($p->username); ?></span></div>
                                <?php } ?>
                              
                            </div>
        
            
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-primary">
                        <a href="<?= base_url('account'); ?>"><button type="button" class="btn btn-light" style="color: black !important;background: white !important;">Change Now <i class="far fa-hand-point-right"></i></button></a>
                    </div>
                    
                </div>
            </div>
        </div><!-- Modal Photo  -->
    
    
    <?php if(!empty($birthdate)){ ?>
    
    
        <script type="text/javascript">
    
            $(document).ready(function(){
              $('#ultahModal').modal('show');
            });

        </script>

        <!--Modal: Ultah-->
        <div class="modal fade" id="ultahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
                <!--Content-->
                <div class="modal-content">
        
                    <!--Header-->
                    <div class="modal-header">
                        <?php foreach($birthdate as $b){ 
                            if(!empty($b->picture)){ ?>
                            <img src="https://apps.mri.co.id/inc/image/warriors/pp/<?= $b->picture; ?>" alt="avatar" class="img-thumbnail rounded-circle img-responsive">
                        <?php }else{ ?>
                            <img src="http://via.placeholder.com/130x130?text=no+picture" alt="avatar" class="img-thumbnail rounded-circle img-responsive">
                        <?php } } ?>
                    </div>
                    <!--Body-->
                    <div class="modal-body text-center mb-1">
        
                        <h5 class="mt-1 mb-2"><?php foreach($birthdate as $b){ echo ucfirst($b->username).' '; } ?></h5>
        
                        <?php $i=0; foreach($birthdate as $b){
                            $id[$i] = $b->id;
                            $i++;
                        } 
                        
                        if (in_array($this->session->userdata('id'), $id, TRUE)) { ?>
                              
                            <div class="md-form ml-0 mr-0 mb-2">
                                Happy Birthday to you <i class="far fa-smile"></i>
                            </div>
                              
                        <?php }else{ ?>
                          
                            <div class="md-form ml-0 mr-0 mb-2">
                                Hello guys, our friend <b><?php foreach($birthdate as $b){ echo ucfirst($b->username).' '; } ?></b>is now being a birthday. Don't forget to say happy birthday to him. <i class="far fa-smile"></i>
                            </div>
                          
                        <?php } ?>
    
                        
        
                    </div>
        
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!--Modal: Login with Avatar Form-->

    
    <?php } //End Ultah ?>
        
        
    
    



<?php } ?>

 
 <!-- BEGIN PAGE CONTAINER-->
  <div class="">
  <div class="">
	<div class="content">
		<div class="panel-header" id="gradient_panel_dashboard">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold"><i>Merry Riana Learning Center Application</i></h2>
						<h5 class="text-white op-7 mb-2"><i>Welcome Back, <?php echo ucfirst($this->session->userdata('username')) ?></i></h5>
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5" style="padding-right:1rem; padding-left: 1rem">
			<div class="row row-card-no-pd mt--2" style="padding-top:0px;padding-bottom:0px">
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-round" style="min-width:0px">
						<div class="card-body ">
							<div class="row">
								<div class="col-3">
									<div class="icon-big text-center">
										<i class="fa fa-user "></i>
									</div>
								</div>
								<div class="col-9 col-stats">
									<div class="numbers">
										<p class="card-category">Student MRLC</p>
										<h5 class="card-title"><b><?php echo $student_active + $student_upgrade + $student_grdsn ?> Student</b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-round" style="min-width:0px">
						<div class="card-body ">
							<div class="row">
								<div class="col-3">
									<div class="icon-big text-center">
                                    <i class="fas fa-angle-double-up"></i>
									</div>
								</div>
								<div class="col-9 col-stats">
									<div class="numbers">
										<p class="card-category">Need to Upgrade</p>
										<h5 class="card-title"><b><?php echo $student_upgrade ?> Student</b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-round" style="min-width:0px">
						<div class="card-body">
							<div class="row">
								<div class="col-3">
									<div class="icon-big text-center">
                                    <i class="fas fa-graduation-cap"></i>
									</div>
								</div>
								<div class="col-9 col-stats">
									<div class="numbers">
										<p class="card-category">Graduate Soon</p>
										<h5 class="card-title"><b><?php echo $student_grdsn ?> Student </b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="card card-stats card-round" style="min-width:0px">
						<div class="card-body">
							<div class="row">
								<div class="col-3">
									<div class="icon-big text-center">
                                    <i class="fas fa-list-alt"></i>
									</div>
								</div>
								<div class="col-9 col-stats">
									<div class="numbers">
										<p class="card-category">Total (Cut-Off)</p>
										<h5 class="card-title"><b><?php echo $student_active - $student_upgrade - $student_grdsn ?> Student</b></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<div class="card-head">
								<div class="card-title">
									<b>SCHEDULE MRLC</b>
									<button id="btn_schedule" class="btn btn-info float-right"><i class="fa fa-plus"></i></button>
								</div>
							</div>

						</div>
						<div class="card-body" style="min-height: 200px">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card">
						<div class="card-header">
							<div class=" card-title mb-0" id="label_list">
								<center><b>LIST SCHEDULE</b></center>
							</div>
						</div>
						<div class="card-body">
							<div class="" id="timeline1">
								<div class="chart-container scroll" id="scroll1">
									<ol class="activity-feed" id="scroll">
										<?php if (!empty($list_schedule)) {
											foreach ($list_schedule as $row) {
										?>
												<li class="feed-item feed-item-warning" id="activity-feed">
													<time class="date" id="list_date0"><?php echo date('d M', strtotime($row->date_event)) ?> - <?php echo ucfirst($row->username) ?></time>
													<span class="text" id="list_event0"><a href="#"><?php echo $row->event ?></a> </span>

												</li>
										<?php }
										} else {
											echo "<center><p class='mx-auto d-block' style='color: gray; margin-top: 115px'>Schedule Not Found</p></center>";
										} ?>
									</ol>
								</div>
							</div>
							<div class="d-none" id="timeline2">
								<div class="chart-container scroll">
									<ol class="activity-feed" id="scroll2">
										<li class="" id="activity-feed2"></li>
									</ol>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-header">
							<div class="card-title fw-mediumbold text-center"><b>BRANCH LEADER</b></div>
						</div>
						<div class="card-body" style="height: 441px;">
							<div class="card-list scroll_bl">
								<?php if (!empty($branch_leader)) {
									foreach ($branch_leader as $row) {
								?>

										<div class="item-list">
											<div class="avatar">
												<?php
												if (!empty($row->picture)) {
													$foto = base_url() . 'assets/image/warriors/pp/' . $row->picture;
												} else {
													$foto = base_url() . 'assets/image/user.png';
												}
												?>
												<img src="<?= $foto ?>" alt="..." class="avatar-img rounded-circle">
											</div>
											<div class="info-user ml-3">
												<div class="username" style="color: #fff"><b><?php echo ucfirst($row->username) ?></b></div>
												<div class="status" style="color: #4fc3f7"><b><?php echo ucfirst($row->branch_name) ?></b></div>
											</div>
										</div>
								<?php }
								} else {
									echo "<center><p class='mx-auto d-block' style='color: gray; margin-top: 115px'>Data Not Found</p></center>";
								}
								?>

							</div>
						</div>
					</div>
				</div>
                
				<div class="col-md-8">
					<div class="card" style="min-height: 516px">
						<div class="card-header">
							<div class="card-title text-center"><b>IMPORTANT INFORMATION</b></div>
						</div>

						<form action="<?= base_url('dashboard/submit_information') ?>" method="post" id="form_data" class="form-horizontal" style="width:100%">
							<div class="card-body ">
								<textarea type="text" class="form-control" name="infomation" id="information" placeholder="Type Your Information" value="<?php echo $inf->information ?>" style="resize: yes" rows="3"><?php echo $inf->information ?></textarea>
								<input type="text" id="id" name="id" value="<?php echo $inf->id ?>" hidden>
								<button type="submit" class="btn btn-success btn-block mt-5" id="btn-submit"><b> PUBLISH</b></button>
							</div>
						</form>

					</div>
				</div>
			</div> -->


		</div>
	</div>

</div>
  </div>
  
<!-- MODAL ADD SCHEDULE -->

<div class="modal fade" tabindex="-1" id="modal_add_schedule" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?= base_url('dashboard/submit_schedule') ?>" method="post" id="form_schedule" class="form-horizontal" style="width:100%">
				<div class="modal-header" style="background-color: #ec407a">
					<h4 class="modal-title" id="myModalLabel" style="color: #fff"><b>SCHEDULE MRLC</b></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Event</label>
						<div class="col-sm-8">
							<input name="event" id="event" class="form-control" type="text" placeholder="Event" required="" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Date</label>
						<div class="col-sm-8">
							<input name="date_event" id="date_event" class="form-control datepicker" type="text" placeholder="Date" required="" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-sm-4">Location</label>
						<div class="col-sm-8">
							<select class="form-control" name="lokasi" id="lokasi" required="">
								<option value="">-Pilih Salah Satu-</option>
								<option value="hb">Home Base</option>
								<option value="Puri">Puri Indah</option>
								<option value="BSD">BSD</option>
								<option value="KG">Kelapa Gading</option>
								<option value="PH">Permata Hijau</option>
								<option value="Palem">Taman Palem</option>
								<option value="BW">Banjar Wijaya</option>
								<option value="SBY">Surabaya</option>
								<option value="others">Others</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="others_lokasi">
						<label class="col-form-label col-sm-4">Others</label>
						<div class="col-sm-8">
							<input name="location" id="location" class="form-control" placeholder="e.g. Ibis Style Hotel">
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-block" style="background-color: #ec407a"><b>Submit</b></button>
				</div>
			</form>
		</div>

	</div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-ui/jquery-ui.theme.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/fullcalendar/fullcalendar.min.css" />
<script src="<?= base_url(); ?>assets/fullcalendar/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		String.prototype.capitalize = function() {
			return this.charAt(0).toUpperCase() + this.slice(1);
		}

		var calendar = $('#calendar').fullCalendar({
			editable: true,
			height: 300,
			header: {
				left: 'prev,next',
				center: 'title',
				right: false
			},
			events: "<?php echo base_url(); ?>dashboard/load",
			displayEventTime: false,
			selectable: true,
			selectHelper: true,
			editable: true,

			eventClick: function(event) {

				var date = event.date;

				$('#list_date1').empty();
				$('#list_event1').empty();
				$('#activity-feed2').empty();

				$.ajax({
					url: "<?php echo base_url(); ?>dashboard/list_on_update",
					type: "POST",
					dataType: "json",
					data: {
						date: date
					},
					success: function(result) {
						$('#timeline1').addClass('d-none');
						$('#timeline2').removeClass();
						$('#list_date0').empty().removeClass();
						$('#list_event0').empty().removeClass();
						$.each(result, function(index, element) {

							var monthNames = [
								"Jan", "Feb", "Mar",
								"Apr", "May", "Jun", "Jul",
								"Aug", "Sept", "Oct",
								"Nov", "Dec"
							];

							var d = new Date(element.date_event);
							var curr_date = d.getDate();
							var curr_month = d.getMonth(); //Months are zero based
							var curr_year = d.getFullYear();
							var date = curr_date + " " + monthNames[curr_month]

							$('#scroll2').find('#activity-feed2').append('\
								<li class="feed-item feed-item-warning" style="margin: 0px 0px -50px 0px">\
									<time class="date " id="list_date1">' + date + ' ' + '-' + ' ' + (element.username).capitalize() + '</time>\
									<span class="text" id="list_event1"><a href="#">' + element.event + '</a></span>\
								</li>\
								<br><br>\
								')

							console.log(result[index].join);
						});

					}
				})
			}

		});

		show_others_lokasi();
	});


	$('#btn_schedule').click(function() {
		$('#form_schedule').trigger("reset");
		$('#modal_add_schedule').modal('show');
	});

	// show location
	$('#lokasi').change(function() {
		show_others_lokasi();
	});

	function show_others_lokasi() {
		var lokasi = $('#lokasi').val();
		if (lokasi == 'others') {
			$('#others_lokasi').show('slide', {
				direction: 'up'
			}, 500);
		} else {
			$('#others_lokasi').hide('slide', {
				direction: 'up'
			}, 500);
		}
	}
	// end show location

	$(".datepicker").datepicker({
		changeYear: true,
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
	});




	function reload_page() {
		window.location.reload();
	}
</script>



