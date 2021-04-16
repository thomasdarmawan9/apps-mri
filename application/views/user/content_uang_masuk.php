 

<?php if($this->session->flashdata('cekinput')<>null ){ ?>
<?php if($this->session->flashdata('cekinput') == 'success'){ ?>
<script>
	function modal(){
		swal("Berhasil Ditambahkan", "Proses pengecekan sudah terinput untuk finance", "success");
	};
	window.onload = modal;
</script>
<?php }else{ ?>
<script>
	function modal(){
		swal("Gagal ditambahkan", "Proses pengecekan gagal terinput", "error");
	};
	window.onload = modal;
</script>
<?php } ?>
<?php } ?>

<!-- <div class="grid simple">
	<div class="grid-title no-border">
		<h4>Form Cek</h4>
		<div class="tools"> <a href="javascript:;" class="expand"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
	</div>
	<div class="grid-body no-border" style="display: block; overflow: hidden;"> <br>
		<h3>Cek<span class="semi-bold"> Uang Masuk</span></h3>
		<div class="color-bands green"></div>
		<div class="color-bands purple"></div>
		<div class="color-bands red"></div>
		<div class="color-bands blue"></div>

		<form action="display/cek_uang_masuk" method="post">
			<div class="col-md-8">
				<div class="form-group">
					<label class="form-label">Jenis Income</label>
					<span class="help">e.g. "Pembayaran Buku"</span>
					<div class="controls">
						<select class="financecek" name="ji" required="" style="width:100%;">
							<option value="">Pilih Jenis Income</option>
							<optgroup label="INCOME_Life_Academy">
								<option value="Sesi Perkenalan">Sesi Perkenalan</option>
								<option value="DP Life Academy">DP Life Academy</option>
								<option value="Pelunasan DP Life Academy">Pelunasan DP Life Academy</option>
								<option value="Lunas OTS Life Academy">Lunas OTS Life Academy</option>
								<option value="Re-Attendance Life Academy">Re-Attendance Life Academy</option>
							</optgroup>
							<optgroup label="INCOME_Puri_Indah">
								<option value="PS - Modul Puri Indah">PS - Modul Puri Indah</option>
								<option value="PS - Lifetime Puri Indah">PS - Lifetime Puri Indah</option>
								<option value="SM - Registration Fee Puri Indah">SM - Registration Fee Puri Indah</option>
								<option value="SM - Modul Puri Indah">SM - Modul Puri Indah</option>
								<option value="SM - Full Program Puri Indah">SM - Full Program Puri Indah</option>
							</optgroup>
							<optgroup label="INCOME_BSD">
								<option value="PS - Modul BSD">PS - Modul BSD</option>
								<option value="PS - Lifetime BSD">PS - Lifetime BSD</option>
								<option value="SM - Registration Fee BSD">SM - Registration Fee BSD</option>
								<option value="SM - Modul BSD">SM - Modul BSD</option>
								<option value="SM - Full Program BSD">SM - Full Program BSD</option>
							</optgroup>
							<optgroup label="INCOME_KG">
								<option value="PS - Modul KG">PS - Modul KG</option>
								<option value="PS - Lifetime KG">PS - Lifetime KG</option>
								<option value="SM - Registration Fee KG">SM - Registration Fee KG</option>
								<option value="SM - Modul KG">SM - Modul KG</option>
								<option value="SM - Full Program KG">SM - Full Program KG</option>
							</optgroup>
							<optgroup label="INCOME_Seminar">
								<option value="Seminar MR - DP">Seminar MR - DP</option>
								<option value="Seminar MR - Pelunasan DP">Seminar MR - Pelunasan DP</option>
								<option value="Seminar MR - Lunas">Seminar MR - Lunas</option>
								<option value="Seminar AT">Seminar AT</option>
								<option value="Sponsorship">Sponsorship</option>
								<option value="Brand Ambassador">Brand Ambassador</option>
								<option value="Others Income Seminar">Others Income Seminar</option>
							</optgroup>
							<optgroup label="INCOME_IIC">
								<option value="Platinum">Platinum</option>
								<option value="Gold">Gold</option>
								<option value="General 1">General 1</option>
								<option value="General 3">General 3</option>
								<option value="General 5">General 5</option>
								<option value="External Trainer Backend">External Trainer Backend</option>
							</optgroup>
							<optgroup label="INCOME_LM">
								<option value="SP LM">SP LM</option>
								<option value="DP LM">DP LM</option>
								<option value="Pelunasan DP LM">Pelunasan DP LM</option>
								<option value="Lunas OTS LM">Lunas OTS LM</option>
								<option value="Re-Attendance LM">Re-Attendance LM</option>
							</optgroup>
							<optgroup label="INCOME_TTT">
								<option value="SP TTT">SP TTT</option>
								<option value="DP TTT">DP TTT</option>
								<option value="Pelunasan DP TTT">Pelunasan DP TTT</option>
								<option value="Lunas OTS TTT">Lunas OTS TTT</option>
								<option value="Re-Attendance TTT">Re-Attendance TTT</option>
							</optgroup>
							<optgroup label="INCOME_ILM">
								<option value="SP ILM">SP ILM</option>
								<option value="DP ILM">DP ILM</option>
								<option value="Pelunasan DP ILM">Pelunasan DP ILM</option>
								<option value="Lunas OTS ILM">Lunas OTS ILM</option>
								<option value="Re-Attendance ILM">Re-Attendance ILM</option>
							</optgroup>
							<optgroup label="INCOME_Channel">
								<option value="Products - Online">Products - Online</option>
								<option value="Products - On-Site">Products - On-Site</option>
								<option value="Royalty">Royalty</option>
								<option value="Photobooth">Photobooth</option>
								<option value="Promo">Promo</option>
								<option value="Media Income">Media Income</option>
								<option value="IP & TMRS">IP & TMRS</option>
								<option value="MRCA Income">MRCA Income</option>
								<option value="Others Income Channel">Others Income Channel</option>
							</optgroup>

						</select>

					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Ke Rekening</label>
					<span class="help">e.g. "BCA MRI, 253 253 1111"</span>
					<div class="controls">
						<select class="form-control" name="norek" required>
							<option value="">Pilih no rekening...</option>
							<option value="BCA MRI, 253 253 1111">BCA MRI, 253 253 1111</option>
							<option value="BCA MRE, 253 828 1111">BCA MRE, 253 828 1111</option>
							<option value="BCA Riana, 253 008 3333">BCA Riana, 253 008 3333</option>
						</select>

					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Bank Pengirim</label>
					<span class="help">e.g. "BCA"</span>
					<div class="controls">
						<input class="form-control" type="text" name="bp" required="">
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Atas Nama Pengirim</label>
					<span class="help">e.g. "Andy Ajhis Ramadhan"</span>
					<div class="controls">
						<input class="form-control" type="text" name="np" required="">
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Tanggal Transfer</label>
					<span class="help">e.g. "2017-04-29"</span>
					<div class="controls">
						<input class="form-control" type="date" name="tgl" required="">
					</div>
				</div>

				<div class="form-group">
					<label class="form-label">Jumlah</label>
					<span class="help">e.g. "Jumlah Pembayaran"</span>
					<div class="controls">
						<input class="form-control" type="number" name="jp" required="">
					</div>
				</div>




				<div class="form-actions">  
					<div class="pull-right">
						<button type="submit" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
						<button type="reset" class="btn btn-white btn-cons">Cancel</button>
					</div>
				</div>
			</div>
		</form>

		<div class="col-md-4">
			<div class="alert alert-block alert-info fade in">
				<h3>Informasi <span class="semi-bold">(Mei 2017)</span></h3>

				<p>Mulai sekarang utk pengiriman transfer dari pihak luar ketentuan-nya sbb : <br><br>

					- Utk semua transaksi LA dapat ditransfer ke <br>
					Bank : BCA <br>
					No.Rekening : 253 253 1111<br>
					An.PT Merry Riana Indonesia<br>
					<br>

					- Utk semua transaksi RC, Channel, Workshop, Event (kecuali IIC & Seminar) dapat ditransfer ke <br>
					Bank : BCA <br>
					No.Rekening : 253 828 1111<br>
					An.PT Merry Riana Edukasi<br>
					<br>

					- Utk semua transaksi Online, IIC & Seminar dpt ditransfer ke <br>
					Bank : BCA <br>
					No. Rekening : 253 008 3333 <br>
					An. Riana OR Alva Christopher T <br>


				</p>
			</div> 
		</div>


	</div>
</div> -->

<div class="card">
	<div class="card-header">
		<h3 class="card-title">Data Uang Masuk</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive">

			<table class="table w-100" id="table1">
				<thead>
					<tr style="background-color: #0d4e6c;color:#fff;">
						<th>Jenis Income</th>
						<th>Pengirim</th>
						<th>Ke Rek.</th>
						<th>Tanggal</th>
						<th>Jumlah</th>
						<th>Status</th>
						<th>Tanggal Cek</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($results)){ ?>
					<?php foreach ($results as $r){ ?>

					<tr>
						<td><?php echo $r->jenis_income; ?></td>
						<td><?php echo $r->bank_pengirim.' - '.$r->nama_pengirim ; ?></td>
						<td><?php echo $r->ke_rekening ; ?></td>
						<td><?php echo date("d-M-Y", strtotime($r->tgl_kirim)); ?></td>
						<td><?php echo number_format($r->jumlah); ?></td>
						<td><?php if($r->approve == null){ ?> <span class="alert alert-warning">Menunggu Checking Finance...</span> <?php }elseif($r->approve == "ya"){ ?> <span class="alert alert-success">APPROVED</span> <?php }else{ ?> <span class="alert alert-danger">NOT APPROVED</span> <?php } ?></td>
						<td><?php if($r->tgl_approve <> null){ echo date("d-M-Y", strtotime($r->tgl_approve)); }else{ echo '-'; } ?></td>
					</tr>

					<?php } ?>     
					<?php } ?>  		            		         

				</tbody>
			</table>

		</div>
	</div>

</div>

<script type="text/javascript">
	$('#table1').DataTable({
		'scrollX':true,
		'order':false,
		'lengthMenu': [[10, 15, 20, -1], [10, 15, 20, "All"]]
	});
</script>
