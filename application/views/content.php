<div class="content">
	<div class="container-fluid">
		<div class="form-group">
			<div class="row">
			
				<?php 
					if (!empty($_GET['event']) and ($_GET['event']=='beranda')) {
            			 		$this->load->view("beranda"); 
            			 	}
					elseif (!empty($_GET['event']) and ($_GET['event']=='jam-lembur')) {
            			 		$this->load->view("jam_lembur"); 
            			 	}
            			 	elseif (!empty($_GET['event']) and ($_GET['event']=='profil') and (!empty($_GET['changepass'])) and ($_GET['changepass']=='open') ) {
            			 	
            			 		$this->session->set_userdata('changepass', $this->session->userdata('changepass') + 1);
            			 		
            			 		if ($this->session->userdata('changepass')== 2) {
            			 		$this->load->view("change_pass"); 
            			 		}else{
            			 			redirect('http://apps.mri.co.id/?event=profil');
            			 		}
            			 	}
            			 	elseif (!empty($_GET['event']) and ($_GET['event']=='profil')) {
            			 		$this->load->view("profile"); 
            			 	}
            			 	elseif (!empty($_GET['event']) and ($_GET['event']=='pemberitahuan')) {
            			 		$this->load->view("pemberitahuan"); 
            			 	}
            			 
            			 ?>
			</div>
		</div>

	</div>
</div><!-- End content -->