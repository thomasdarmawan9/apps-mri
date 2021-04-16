<!-- Menu Top -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
	<div class="container-fluid">
		
			<img id="logo" src="<?= base_url(); ?>inc/image/logo.png" class="logo mCS_img_loaded" alt="Logo MRI" width="106" height="50">
			<button type="button" id="sidebarCollapse" class="btn" style="    background-color: transparent !important;box-shadow: none;color: gray !important;font-size: 1.5em;" >
				<i class="fas fa-bars"></i>
			</button>
		
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav ml-auto">
				  <li class="mt-3" style="margin: 12px 10px 0 0;font-weight: bold;color: #33b5e5;"><?= $this->session->userdata('name'); ?></li>
					<li class="mt-2">
						<?php 
        				if(!empty($this->session->userdata('picture'))){
        					$foto = base_url().'inc/image/warriors/pp/'.$this->session->userdata('picture');
        				}else{
        					$foto = base_url().'inc/image/user.png';
        				}
        				?>
						<img src="<?= $foto?>" style="width: 45px;border-radius: 100%;margin-right: 5px;" class="mCS_img_loaded">
					</li>
					
				</ul>
				
					
			  </div>
			  
			  <div  id="navbarNavDropdown">
				<ul class="navbar-nav ml-auto">
				    <li>
						<div class="dropdown">
						  <button class="btn waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="    background-color: transparent !important;box-shadow: none;color: gray !important;font-size: 1.5em;">	
							<i class="fas fa-cog"></i>
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="left:-110px;">
							<li><a href="<?= base_url('account')?>" style="padding-left:20px !important;"><i class="fas fa-user"></i> &nbspMy Account</a></li>
							<li><a href="<?= base_url('logout')?>" style="padding-left:20px !important;"><i class="fas fa-power-off"></i> &nbspLog Out</a></li>
						  </ul>
						</div>
					</li>
				</ul>
			</div>
		
		  
		  
	</div>
</nav>