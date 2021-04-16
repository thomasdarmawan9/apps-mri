	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Add Warrior to Task</h3>
		</div>
		<div class="card-body">
			<h5>
				Event &nbsp;&emsp;&emsp;: <label class="badge badge-info"><?= $results->event; ?></label><br>
				<!-- Lokasi &emsp;&emsp;: <label class="badge badge-info"><?= $results->location; ?></label><br> -->
				Tanggal &emsp;: <label class="badge badge-info"><?= date("d-M-Y", strtotime($results->date)); ?></label>
			</h5>
			
			<div class="alert alert-primary" style="letter-spacing:0px;">
				<button class="close" data-dismiss="alert"></button>
				Info: Untuk menambahkan Task Allocation Warriors tanpa mengurangi hutang event.
			</div>
			<form action="<?= base_url('support/task/tambah_war_task')?>" method="post">

				<div class="form-group">
					<input type="hidden" value="<?= $results->id;?>" name="id" required>
					<label class="form-label">Name</label>
					<span class="help">e.g. "andy"</span>
					<div class="input-with-icon  right">                                       
						<i class=""></i>
						<select id="geteventwar" name="getname[]" class="form-control" multiple="multiple" required>
							<option value=""></option>
							<?php foreach($hasil as $gn){ ?>
							<?php if($gn->username<>'admin'){ ?>
							<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
							<?php } ?>
							<?php } ?>
						</select>                                 
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah Warriors</button>
				</div>
			</form>
		</div>


	</div>
	<!-- AKHIR TAMBAH NORMAL -->
	<hr>

	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Add Warrior to Pay Task</h3>
		</div>
		<div class="card-body">
			<div class="alert alert-info" style="letter-spacing:0px;">
				<button class="close" data-dismiss="alert"></button>
				Info: Untuk mengurangi hutang Task Allocation Warriors dengan +1.
			</div>

			<form action="<?= base_url('support/task/pay_war_task')?>" method="post">
				<div class="form-group">
					<input type="hidden" value="<?= $results->id?>" name="id" required>
					<label class="form-label">Name</label>
					<span class="help">e.g. "andy"</span>
					<div class="input-with-icon  right">                                       
						<i class=""></i>
						<select id="getpayeventwar" name="getname[]" class="form-control" multiple="multiple" required>
							<option value=""></option>
							<?php foreach($hasil as $gn){ ?>
							<?php if($gn->username<>'admin'){ ?>
							<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
							<?php } ?>
							<?php } ?>
						</select>                                 
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-warning" id="showtambah"><i class="fa fa-plus"></i> Bayar Hutang Event</button>
				</div>
			</form>

		</div>


	</div>
	<!-- AKHIR BAYAR TASK -->

	<link rel="stylesheet" href="<?= base_url(); ?>inc/bootstrap-select2/select2.min.css"/>
	<script type="text/javascript" src="<?= base_url();?>inc/bootstrap-select2/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#geteventwar, #getpayeventwar").select2({
				placeholder: "Please Select"
			});
		});	
	</script>