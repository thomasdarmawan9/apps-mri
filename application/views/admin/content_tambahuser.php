<div class="card">
	<div class="card-header">
		<h3 class="card-title">Tambah User</h3>
	</div>
	<div class="card-body">

		<form method="post" action="<?= base_url('admin/user/submit_add')?>">

			<div class="form-group">
				<label class="form-label">Nama</label>
				<div class="input-with-icon  right">                                       
					<i class=""></i>
					<input name="nama" id="nama" class="form-control" type="text" placeholder="e.g. Andy Ajhis R" required="">                                 
				</div>
			</div>
			<div class="form-group">
				<label class="form-label">Username</label>
				<div class="input-with-icon  right">                                       
					<i class=""></i>
					<input name="username" id="username" class="form-control" type="text" placeholder="e.g. andy" required="">                                 
				</div>
			</div>
			<div class="form-group">
				<label class="form-label">Email</label>
				<div class="input-with-icon  right">                                       
					<i class=""></i>
					<input name="email" id="email" class="form-control" type="email" placeholder="e.g. andy@mri.co.id" required="">                                 
				</div>
			</div>
			<div class="form-group">
				<label class="form-label">Jenis Cuti</label>
				<div class="input-with-icon  right">                                       
					<select class="form-control" name="jenis" required="">
						<option value="">Pilih Jenis</option>
						<option value="bulanan">Bulanan</option>
						<option value="tahunan">Tahunan</option>
					</select>                                
				</div>
			</div>  

			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<label class="form-label">Cuti Izin</label>
						<input name="cutiizin" id="jamlembur" class="form-control" type="number" min="0" required>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="form-label">Cuti Sakit</label>
						<input name="cutisakit" id="jamlembur" class="form-control" type="number" min="0" required>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="form-label">Lembur</label>
						<input name="lembur" id="jamlembur" class="form-control" type="number" step="0.5" required>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="form-label"></label>
						<div class="custom-control custom-checkbox">
							<!-- <br><br> -->
							<input id="checkbox3" value="1" name="plus" type="checkbox" class="custom-control-input">
							<label for="checkbox3" class="custom-control-label"> + 1/2 Jam (<b>Plus</b> <i>Setengah jam</i>)</label>
						</div>
					</div>
				</div>


			</div>

			<div class="form-actions">  
				<div class="pull-right">
					<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
					<a href="<?= base_url('admin/user')?>"><button type="button" class="btn btn-blue-grey">Cancel</button></a>
				</div>
			</div>		
		</form>
	</div>
</div>


