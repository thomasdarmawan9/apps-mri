  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">

	      <div class="page-title"> <i class="icon-custom-left"></i>
	        <h3>Update Apply</h3>
	      </div>
	      <div id="container">
	      
	<div class="grid simple">
		<div class="grid-title no-border">
			<h4>Tanggal : <span class="semi-bold"><?php echo date("d-M-Y", strtotime($_GET['tgl'])); ?></span></h4>
		<div class="tools"> <a href="javascript:;" class="collapse"></a></div>
	</div>
	
	<div class="grid-body no-border" style="display: block;"><br>
		<!--<form method="post" action="/display/update_addlembur">
			<input type="hidden" name="id" value="<?php echo $_GET['idt']; ?>" >
			<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
			<div class="panel panel-success" id="tambah" style="overflow: hidden;">
				<div class="panel-heading">
					<b>Update Apply</b>
				</div>
			</div>
			
			<?php
			
			$angka = $_GET['lembur'];
			$tanda   = ".";
			$stgh = null;
			
			if( strpos( $angka, $tanda ) !== false ) {
				$nilai = $_GET['lembur'] - 0.5;
				$stgh = 1;
			}else{
				$nilai = $_GET['lembur'];
				$stgh = 0;
			}
			
			
			?>
			
			<div class="grid-body no-border"><br>
				<div class="row">
				     	<div class="col-md-2">
					      	<div class="form-group">
					      		<label class="form-label">Durasi Lembur</label>
					      		<input name="nilai" id="nilai" value="<?php echo $nilai; ?>" class="form-control" type="number" min="0" required="">
					      	</div>
					</div>
					<div class="col-md-6">
						
						<div class="checkbox check-primary">
							<br><br>
							<?php if($stgh == 1){ ?>
								<input id="checkbox3" name="plus" type="checkbox" checked>
							<?php }else{ ?>
								<input id="checkbox3" name="plus" type="checkbox">
							<?php } ?>
							
							<label for="checkbox3"> + 1/2 Jam (<b>Plus</b> <i>Setengah jam</i>)</label>
						</div>
					</div>
				</div>
	                  
				<div class="form-group">
					<label class="form-label">Tujuan Lembur</label>
					<span class="help">e.g. "Tele"</span>
					<div class="input-with-icon  right">                                       
						<i class=""></i>
						<textarea name="deskripsi" id="deskrispi" class="form-control"><?php echo $_GET['desc']; ?></textarea>                              
					</div>
				</div>              
				<div class="form-actions">  
					<div class="pull-right">
					  <button type="submit" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
					  <button type="button" class="btn btn-white btn-cons">Cancel</button>
					</div>
				</div>				
	                </div>
	        </form>-->
	        
	        
	            <?php $hsl = explode(" ",strip_tags($_GET['desc'])); ?>
	            
	            
	            <form action="/display/update_addlembur" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['idt']; ?>" >
            	    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            	    
					<div class="panel panel-success" id="tambah" style="overflow: hidden;">
						<div class="panel-heading">
							<b>Apply</b>
						</div>
						<div>
							<div class="grid-body no-border">
								<br>
								
								
								<div class="row" data-ng-app="" data-ng-init="msk=0;plg=0;">
								    <div class="col-md-6">
    									<div class="row">
    									    <div class="col-md-4">
    											<div class="form-group">
    												<label class="form-label">Jam Awal</label><br>
    												<input type="time" ng-model="msk" name="msk" required>
    												<input class="form-control" id="nilai" min="0" name="nilai" type="number" value="{{ (plg | date:'HH') - (msk | date:'HH') }}" style="display:none;">
    											</div>
    										</div>
    										<div class="col-md-4">
    										        <div class="form-group">
        										        <label class="form-label">Jam Akhir</label><br>
        										        <input type="time" ng-model="plg" name="plg" required>
        										        <input class="form-control" id="nilai" min="0" name="plus" type="number" value="{{ (plg | date:'mm') - (msk | date:'mm') }}" style="display:none;">
    										        </div>
    										</div>
    										
    									</div>
    								</div><!-- col-md-6-->
    								<div class="col-md-6">
    								    <div style="text-align: center;font-size: 50px;margin-top: 50px;border: 1px solid lightgray;" class="ng-binding"> {{ (plg | date:'HH') - (msk | date:'HH') }} : {{ (plg | date:'mm') - (msk | date:'mm') }} </div>
    								</div>
								</div><!-- angularjs-->
								
								<div class="form-group">
									<label class="form-label">Tujuan Lembur</label> <span class="help">e.g. "Tele"</span>
									<div class="input-with-icon right">
										<i class=""></i> 
										<textarea class="form-control" id="deskrispi" name="deskripsi"><?php echo $hsl[3]; ?></textarea>
									</div>
								</div>
								<div class="form-actions">
									<div class="pull-right">
										<button class="btn btn-primary btn-cons" type="submit"><i class="icon-ok"></i> Save</button> <button class="btn btn-white btn-cons" type="button">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
    					
    					
    					
    					
    					
	
	</div>
	
	
	                                                                       
	</div>
	</div>
                   
                   
              
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

