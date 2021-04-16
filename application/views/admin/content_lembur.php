 	<div class="card">
 		<div class="card-header">
 			<h3 class="card-title">Overtime</h3>
 		</div>
 		<div class="card-body">
 			<button type="button" class="btn  btn-primary" id="showtambah"><i class="fa fa-plus"></i> Tambah</button> 
 			<button type="button" class="btn  btn-danger" id="showkurang"><i class="fa fa-minus"></i> Kurang</button>  |  
 			<button type="button" class="btn  teal" id="showcutitambah"><i class="fa fa-plus"></i> Tambah Cuti (IZIN)</button> 
 			<button type="button" class="btn  light-blue darken-2" id="showcuti"><i class="fa fa-minus"></i> Cuti (IZIN / SAKIT)</button>
 			<hr>

 			<form method="post" action="<?= base_url('admin/overtime/tambah_lembur')?>" >
 				<div class="" id="tambah" style="display:none;">
 					<div class="panel-heading">
 						<b>Tambah</b> Jam Overtime
 					</div>
 					<div>
 						<div class="grid-body no-border">
 							<div class="row">
 								<div class="col-md-2">
 									<div class="form-group">
 										<label class="form-label">Jumlah</label>
 										<input name="jamlembur" id="jamlembur" class="form-control" type="number" min="0" required>
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form-group">
 										<label class="form-label"></label>
	 									<div class="custom-control custom-checkbox">
	 										<!-- <br><br> -->
	 										<input id="checkbox3" value="1" name="plus" type="checkbox" class="custom-control-input">
	 										<label class="custom-control-label" for="checkbox3"> + 1/2 Jam (<b>Plus</b> <i>Setengah jam</i>)</label>
	 									</div>
	 								</div>
 								</div>
 							</div>


 							<div class="form-group">
 								<label class="form-label">Name</label>
 								<span class="help">e.g. "rizki"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<select id="getname2" name="getname[]" class="form-control" multiple="multiple" style="padding:0;border:0px" required>
 										<option value=""></option>
 										<?php foreach($results as $gn){ ?>
 										<?php if($gn->username<>'admin'){ ?>
 										<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
 										<?php } ?>
 										<?php } ?>
 									</select>                                 
 								</div>
 							</div>

 							<div class="form-group">
 								<label class="form-label">Tanggal</label>
 								<span class="help">e.g. "01/24/2017"</span>
 								<div class="row">
 									<div class="col-md-3">
 										<div class="input-with-icon  right">                                       
 											<i class=""></i>
 											<input name="tgl" id="tgl" class="form-control" type="date" required>                                 
 										</div>
 									</div>
 								</div>
 							</div>
 							<div class="form-group">
 								<label class="form-label">Deskripsi</label>
 								<span class="help">e.g. "Overtime"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<textarea name="deskripsi" id="deskrispi" class="form-control" required></textarea>                              
 								</div>
 							</div>              
 							<div class="form-actions">  
 								<div class="pull-right">
 									<button type="submit" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
 									<button type="button" class="btn btn-blue-grey">Cancel</button>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>
 			</form>

 			<form method="post" action="<?= base_url('admin/overtime/kurang_lembur')?>" >
 				<div class="card-body" id="kurang" style="display:none;">
 					<div class="panel-heading">
 						<b>Kurang</b> Jam Overtime
 					</div>
 					<div class="form-group row">
 						<div class="col-md-2">
 							<div class="form-group">
 								<label class="form-label">Jumlah</label>
 								<input name="jamlembur" id="jamlembur" class="form-control" type="number" min="0" required>
 							</div>
 						</div>
 						<div class="col-md-6">
 							<div class="form-group">
 								<label class="form-label"></label>
	 							<div class="custom-control custom-checkbox">
	 								<input id="checkbox4" value="1" type="checkbox" name="minus" class="custom-control-input">
	 								<label class="custom-control-label" for="checkbox4"> - 1/2 Jam (<b>Minus</b> <i>Setengah jam</i>)</label>
	 							</div>
	 						</div>
 						</div>

 					</div>
 					<div class="form-group">
 						<label class="form-label">Name</label>
 						<span class="help">e.g. "rizki"</span>
 						<div class="input-with-icon  right">                                       
 							<i class=""></i>
 							<select id="getminusname2" name="getminusname[]" class="form-control" multiple="multiple" style="padding:0;border:0px" required>
 								<option value=""></option>
 								<?php foreach($results as $gn){ ?>
 								<?php if($gn->username<>'admin'){ ?>
 								<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
 								<?php } ?>
 								<?php } ?>
 							</select>                                 
 						</div>
 					</div>

 					<div class="form-group">
 						<label class="form-label">Tanggal</label>
 						<span class="help">e.g. "01/24/2017"</span>
 						<div class="row">
 							<div class="col-md-3">
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<input name="tgl" id="tgl" class="form-control" type="date" required>                                 
 								</div>
 							</div>
 						</div>
 					</div>
 					<div class="form-group">
 						<label class="form-label">Deskripsi</label>
 						<span class="help">e.g. "Overtime"</span>
 						<div class="input-with-icon  right">                                       
 							<i class=""></i>
 							<textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>                              
 						</div>
 					</div>              
 					<div class="form-actions">  
 						<div class="pull-right">
 							<button type="submit" class="btn btn-danger btn-cons"><i class="icon-ok"></i> Save</button>
 							<button type="button" class="btn btn-blue-grey">Cancel</button>
 						</div>
 					</div>

 				</div>

 			</form>


 			<form method="post" action="<?= base_url('admin/overtime/kurang_cuti')?>" >
 				<div class="panel panel-warning" id="cuti" style="display:none;">
 					<div class="panel-heading">
 						<b>Kurang</b> Cuti / Hari
 					</div>
 					<div>
 						<div class="grid-body no-border"> <br>

 							<div class="form-group">
 								<div class="custom-control custom-radio custom-control-inline">
 									<input id="sakit" name="cuti" value="sakit" type="radio" class="custom-control-input" required>
 									<label for="sakit" class="custom-control-label">Sakit</label> 
 								</div>
 								<div class="custom-control custom-radio custom-control-inline">
 									<input id="izin" name="cuti" value="izin" type="radio" class="custom-control-input" required>
 									<label for="izin" class="custom-control-label">Izin</label>
 								</div>
 							</div>      
 							<div class="form-group">
 								<label class="form-label">Name</label>
 								<span class="help">e.g. "rizki"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<select id="getcutiname2" name="getname[]" class="form-control" multiple="multiple" style="padding:0;border:0px" required>
 										<option value=""></option>
 										<?php foreach($results as $gn){ ?>
 										<?php if($gn->username<>'admin'){ ?>
 										<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
 										<?php } ?>
 										<?php } ?>
 									</select>                                 
 								</div>
 							</div>

 							<div class="form-group">
 								<label class="form-label">Tanggal</label>
 								<span class="help">e.g. "01/24/2017"</span>
 								<div class="row">
 									<div class="col-md-3">
 										<div class="input-with-icon  right">                                       
 											<i class=""></i>
 											<input name="tgl" id="tgl" class="form-control" type="date" required>                                 
 										</div>
 									</div>
 								</div>
 							</div>
 							<div class="form-group">
 								<label class="form-label">Deskripsi</label>
 								<span class="help">e.g. "Overtime"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>                              
 								</div>
 							</div>              
 							<div class="form-actions">  
 								<div class="pull-right">
 									<button type="submit" class="btn light-blue darken-2"><i class="icon-ok"></i> Save</button>
 									<button type="button" class="btn btn-blue-grey">Cancel</button>
 								</div>
 							</div>

 						</div>

 					</div>
 				</div>
 			</form>


 			<form method="post" action="<?= base_url('admin/overtime/tambah_cuti')?>" >
 				<div class="panel panel-success" id="cutitambah" style="display:none;">
 					<div class="panel-heading">
 						<b>Tambah</b> Cuti / Hari
 					</div>
 					<div>
 						<div class="grid-body no-border"> <br>

 							<div class="form-group">
 								<label class="form-label">Jumlah Cuti</label>
 								<span class="help">e.g. "1 or 2 or 3 dll"</span>
 								<div class="row">
 									<div class="col-md-3">
 										<div class="input-with-icon  right">                                       
 											<i class=""></i>
 											<input name="jmhhr" id="jmhhr" class="form-control" type="number" min="0" required>                                 
 										</div>
 									</div>
 								</div>
 							</div>


 							<div class="form-group">
 								<label class="form-label">Tanggal</label>
 								<span class="help">e.g. "01/24/2017"</span>
 								<div class="row">
 									<div class="col-md-3">
 										<div class="input-with-icon  right">                                       
 											<i class=""></i>
 											<input name="tgl" id="tgl" class="form-control" type="date" required>                                 
 										</div>
 									</div>
 								</div>
 							</div>     
 							<div class="form-group">
 								<label class="form-label">Name</label>
 								<span class="help">e.g. "rizki"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<select id="getcutitambah" name="getname[]" class="form-control" multiple="multiple" style="padding:0;border:0px" required>
 										<option value=""></option>
 										<?php foreach($results as $gn){ ?>
 										<?php if($gn->username<>'admin'){ ?>
 										<option value="<?php echo $gn->username; ?>"><?php echo $gn->username; ?></option>
 										<?php } ?>
 										<?php } ?>
 									</select>                                 
 								</div>
 							</div>


 							<div class="form-group">
 								<label class="form-label">Deskripsi</label>
 								<span class="help">e.g. "Overtime"</span>
 								<div class="input-with-icon  right">                                       
 									<i class=""></i>
 									<textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>                              
 								</div>
 							</div>              
 							<div class="form-actions">  
 								<div class="pull-right">
 									<button type="submit" class="btn teal"><i class="icon-ok"></i> Save</button>
 									<button type="button" class="btn btn-blue-grey">Cancel</button>
 								</div>
 							</div>

 						</div>

 					</div>
 				</div>
 			</form>

 			<hr>

 			<div class="grid simple mt-3">
 				<div class="grid-title no-border">
 					<h4>Perhitungan <span class="semi-bold">Overtime</span></h4><br>	
 				</div>
 				<div class="grid-body no-border" >
 					<div data-ng-app="" data-ng-init="msk=9;mnt_msk=0;plg=18;mnt_plg=0; ny_msk=9;ny_mnt_msk=0;ny_plg=18;ny_mnt_plg=0;">

 						<div>

 							<div class="row">
 								<div class="col-md-6">
 								    
 								    <!-- START DEFAULT JAM MASUK -->

 									<div class="row">
 										<div class="col-md-6">
 											<p><b>Default</b> Jam Masuk</p>
 										</div>
 										
 										<div class="col-md-2">
 											<div class="form-group">
 											    
 												<input type="number" min="0" max="23" ng-model="msk" class="form-control">
 											</div>
 										</div>
 										<div class="col-md-1" style="width: 0px;padding-top: 8px;">
 											<div class="form-group">

 												:
 											</div>
 										</div>
 										<div class="col-md-2">
 											<div class="form-group">											

 												<select ng-model="mnt_msk" class="form-control">
 													<option value="00">00</option>
 													<option value="30">30</option>
 												</select>
 											</div>
 										</div>
 									
 									</div>
 									
 									<!-- END DEFAULT JAM MASUK -->
                                    
                                    <!-- START DEFAULT JAM PULANG -->

    								<div class="row">
    
    									<div class="col-md-6">
    										<p><b>Default</b> Jam Pulang</p>
    									</div>
    									
    									<div class="col-md-2">
 											<div class="form-group">

 												<input type="number" min="0" max="23" ng-model="plg" class="form-control">
 											</div>
 										</div>
 										<div class="col-md-1" style="width: 0px;padding-top: 8px;">
 											<div class="form-group">

 												:
 											</div>
 										</div>
 										<div class="col-md-2">
 											<div class="form-group">											

 												<select ng-model="mnt_plg" class="form-control">
 													<option value="00">00</option>
 													<option value="30">30</option>
 												</select>
 											</div>
 										</div>	
    
    								</div>
    
    								<!-- END DEFAULT JAM PULANG -->
    								
    								<hr style="height: 15px;">
    								
    								<!-- START DEFAULT REAL JAM MASUK -->

    								<div class="row">
    
    									<div class="col-md-6">
    										<p><b>Real</b> Jam Masuk</p>
    									</div>
    
    								    <div class="col-md-2">
 											<div class="form-group">

 												<input type="number" min="0" max="23" ng-model="ny_msk" class="form-control">
 											</div>
 										</div>
 										<div class="col-md-1" style="width: 0px;padding-top: 8px;">
 											<div class="form-group">

 												:
 											</div>
 										</div>
 										<div class="col-md-2">
 											<div class="form-group">

 												<select ng-model="ny_mnt_msk" class="form-control">
 													<option value="00">00</option>
 													<option value="30">30</option>
 												</select>
 											</div>
 										</div>
    
    								</div>
    								
    								<!-- END DEFAULT REAL JAM PULANG -->
    								
    								<!-- START DEFAULT REAL JAM PULANG -->

 									<div class="row">
 									
 										<div class="col-md-6">
 											<p><b>Real</b> Jam Pulang</p>
 										</div>
 										
 										<div class="col-md-2">
 											<div class="form-group">

 												<input type="number" min="0" max="23" ng-model="ny_plg" class="form-control">
 											</div>
 										</div>
 										<div class="col-md-1" style="width: 0px;padding-top: 8px;">
 											<div class="form-group">

 												:
 											</div>
 										</div>
 										<div class="col-md-2">
 											<div class="form-group">
 												<select ng-model="ny_mnt_plg" class="form-control" >
 													<option value="00">00</option>
 													<option value="30">30</option>
 												</select>
 											</div>
 										</div>	
 									</div>
 									
 									<!-- END DEFAULT REAL JAM PULANG -->

 									<div class="row" style="display: none;">
 										<div class="col-md-5">
 											<div class="form-group" style="text-align: center;">																								
 												{{ ((msk-ny_msk)+ (((mnt_msk-ny_mnt_msk)/6)/10)) }} 
 											</div>
 										</div>
 										<div class="col-md-1">
 										</div>
 										<div class="col-md-5" style="padding-left: 0px;">
 											<div class="form-group" style="text-align: center;">																			
 												{{ ((ny_plg-plg) + (((ny_mnt_plg - mnt_plg)/6)/10)) }} 
 											</div>
 										</div>
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="card" style="height: 250px">
 										<div class="card-body">
		 									<div style="text-align: center;font-size: 50px;margin-top: 72px; margin-bottom: 100px;">
		 										{{ (((msk-ny_msk)+ (((mnt_msk-ny_mnt_msk)/6)/10)) + ((ny_plg-plg) + (((ny_mnt_plg - mnt_plg)/6)/10))) }} 
		 									</div>
 										</div>
 									</div>

 								</div>
 							</div>



 						</div>


 					</div>

 				</div>
 			</div>
 		</div>
 	</div>

 	<link rel="stylesheet" href="<?= base_url(); ?>inc/bootstrap-select2/select2.min.css"/>
 	<script type="text/javascript" src="<?= base_url();?>inc/bootstrap-select2/select2.min.js"></script>
 	<script type="text/javascript">
 		$(document).ready(function(){
 			$("#showtambah").click(function(){
 				$("#kurang").hide(200);
 				$("#cuti").hide(200);
 				$("#cutitambah").hide(200);
 				$("#tambah").toggle(200);
 			});
 			$("#showkurang").click(function(){
 				$("#tambah").hide(200);
 				$("#cuti").hide(200);
 				$("#cutitambah").hide(200);
 				$("#kurang").toggle(200);
 			});
 			$("#showcuti").click(function(){
 				$("#tambah").hide(200);
 				$("#kurang").hide(200);
 				$("#cutitambah").hide(200);
 				$("#cuti").toggle(200);
 			});
 			$("#showcutitambah").click(function(){
 				$("#tambah").hide(200);
 				$("#kurang").hide(200);
 				$("#cuti").hide(200);
 				$("#cutitambah").toggle(200);
 			});
 			$("#getname2, #getminusname2, #getcutiname2, #getcutitambah").select2({
 				placeholder: "Please Select"
 			});
 		});	
 	</script>


