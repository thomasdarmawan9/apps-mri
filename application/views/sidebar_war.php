<?php $active = $this->session->userdata('menu_active');?>
<!-- Sidebar Holder -->
<nav id="sidebar" class="dinamisTop" style="background: url(<?= base_url(); ?>inc/image/textureweb.jpg); background-size: 100% 100%;">

	<div class="text-center py-3" style="background: url(<?= base_url(); ?>inc/image/md.jpg);background-size:100% 100%;">
		<div class="row p-3 m-0">
			<div class="col-6">
				<?php 
				if(!empty($this->session->userdata('picture'))){
					$foto = base_url().'inc/image/warriors/pp/'.$this->session->userdata('picture');
				}else{
					$foto = base_url().'inc/image/user.png';
				}
				?>
				<img id="profile" src="<?= $foto?>" style="width: 80px;border-radius: 100%;position: relative;">
			</div>
			<div class="col-6 ml-0 pl-0">
				<p style="color:white;">Welcome, <br>
					<span style="color: #33b5e5;font-size: 1.5em;font-weight: bold;text-shadow: 0 0 3px black;"><?= ucfirst($this->session->userdata('username'))?></span>
				</p>
			</div>
		</div>				
	</div>

	<ul class="list-unstyled components">
		<!-- SIDEBAR USER -->
		<?php if($this->session->userdata('level') == 'user'){ ?>
		<li class="<?= (!empty($active) && $active == 'dashboard')? 'active':'';?>"> 
			<a href="<?= base_url('dashboard')?>"><i class="fa fa-home"></i>&nbsp Dashboard</a>
		</li>
		
		<!-- <?php if ($this->session->userdata('id') == 44 || $this->session->userdata('id') == 32 || $this->session->userdata('id') == 37 || $this->session->userdata('id') == 30 || $this->session->userdata('id') == 35 || $this->session->userdata('id') == 82 || $this->session->userdata('id') == 76 || $this->session->userdata('id') == 64 || $this->session->userdata('branch_leader') > 0 || $this->session->userdata('is_spv') == true || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72') { ?>
			<li class="<?= (!empty($active) && $active == 'Event') ? 'active' : ''; ?>">
				<a href="<?= base_url('user/task/sesi_perkenalan') ?>"><i class="fa fa-bullhorn"></i>&nbsp Event</a>
			</li>
		<?php } ?> -->
		
		
		
		<?php if(((($this->session->userdata('is_spv') == true && $this->session->userdata('signup_privilege') == 1) || $this->session->userdata('id') == 76) || $this->session->userdata('id') == 87)  || $this->session->userdata('branch_leader') > 0 || $this->session->userdata('id') == 28 || $this->session->userdata('id') == 113 || $this->session->userdata('id') == 32 || ($this->session->userdata('id') == '155') || ($this->session->userdata('id') == '190') || ($this->session->userdata('id') == '72') || $this->session->userdata('signup_privilege') == 1  || strpos($this->session->userdata('divisi'), 'MRLC') !== false){ ?>
		<li>
			<a href="#menu4" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user-plus"></i>&nbsp Signup</a>
			<ul class="collapse list-unstyled" id="menu4">
				<li class="<?= (!empty($active) && $active == 'Add Signup')? 'active':'';?>"> 
					<a href="<?= base_url('user/signup')?>">Add Signup </a>
				</li>
				<?php 
					if($this->session->userdata('student_privilege') == 0 || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '128'){ 
					?>
					<li class="<?= (!empty($active) && $active == 'Add Repayment')? 'active':'';?>"> 
						<a href="<?= base_url('user/signup/add_repayment')?>">Add Pembayaran DP</a>
					</li>
				<?php	
					}
				?>
				<li class="<?= (!empty($active) && $active == 'List Signup')? 'active':'';?>"> 
					<a href="<?= base_url('user/signup/all')?>">List Signup</a>
				</li>
			</ul>
			
		</li>
		<?php } ?>
		
		<?php if($this->session->userdata('is_spv') == true && strpos($this->session->userdata('divisi'), 'MRLC') !== false || $this->session->userdata('id') == 32 || $this->session->userdata('id') == 128){ ?>
		<li>
			<a href="#menu_rc" data-toggle="collapse" aria-expanded="false"><i class="fa fa-clone"></i>&nbsp Regular Class</a>
			<ul class="collapse list-unstyled" id="menu_rc">
				<li class="<?= (!empty($active) && $active == 'dashboard student')? 'active':'';?>"><a href="<?= base_url('rc/dashboard')?>">Dashboard Student </a></li>
				<li class="<?= (!empty($active) && $active == 'branch')? 'active':'';?>"><a href="<?= base_url('rc/branch')?>">Manage Branch </a></li>
				<li class="<?= (!empty($active) && $active == 'periode')? 'active':'';?>"><a href="<?= base_url('rc/periode')?>">Manage Periode </a></li>
				<li class="<?= (!empty($active) && $active == 'classroom')? 'active':'';?>"><a href="<?= base_url('rc/classroom')?>">Manage Class </a></li>
				<li class="<?= (!empty($active) && $active == 'trainer')? 'active':'';?>"><a href="<?= base_url('rc/trainer')?>">Manage Trainer </a></li>
				<li class="<?= (!empty($active) && $active == 'student')? 'active':'';?>"><a href="<?= base_url('rc/student/manage')?>">Manage Student </a></li>
				<li class="<?= (!empty($active) && $active == 'absensi')? 'active':'';?>"><a href="<?= base_url('rc/absensi')?>">Absensi </a></li>
				<li class="<?= (!empty($active) && $active == 'submission')? 'active':'';?>"><a href="<?= base_url('rc/student/submission')?>">List Pengajuan Pindah </a></li>
			</ul>
		</li>
		<?php } ?>
		
		<li> 
			<a href="#menu2" data-toggle="collapse" aria-expanded="false"><i class="fa fa-tasks"></i>&nbsp Task Allocation <span class="arrow"></span> </a>
			<ul class="collapse list-unstyled" id="menu2">
			    <?php if( $this->session->userdata('id') == '169' || $this->session->userdata('id') == '43' || $this->session->userdata('id') == '28' || $this->session->userdata('id') == '44' || $this->session->userdata('id') == '64' || $this->session->userdata('id') == '76' || $this->session->userdata('id') == '82' || $this->session->userdata('id') == '63'|| $this->session->userdata('id') == '88' || $this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '133' ){ ?>
				<li class="<?= (!empty($active) && $active == 'Future Task Support') ? 'active' : ''; ?>">
					<a href="<?= base_url('support/task'); ?>">Future Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Last Task Support') ? 'active' : ''; ?>">
					<a href="<?= base_url('support/task/all'); ?>">Last Task</a>
				</li>
				<?php } ?>
				<li class="<?= (!empty($active) && $active == 'My Task')? 'active':'';?>"> 
					<a href="<?= base_url('user/task'); ?>">My Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Request Task')? 'active':'';?>"> 
					<a href="<?= base_url('user/task/request'); ?>">List Permohonan Task <?php if($task_permite > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;">'.$task_permite.'</label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Submission Task')? 'active':'';?>"> 
					<a href="<?= base_url('user/task/submission'); ?>">List Pengajuan Task <?php if($task_submission > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;">'.$task_submission.'</label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'All Task')? 'active':'';?>"> 
					<a href="<?= base_url('user/task/all'); ?>">All Task</a>
				</li>
			</ul>
		</li>
		
		<?php if($this->session->userdata('is_spv') == false && $this->session->userdata('id') != '128' && strpos($this->session->userdata('divisi'), 'MRLC') !== false){ ?>
			<li>
			<a href="#menu_trainer" data-toggle="collapse" aria-expanded="false"><i class="fa fa-clone"></i>&nbsp Regular Class</a>
			<ul class="collapse list-unstyled" id="menu_trainer">
				<li class="<?= (!empty($active) && $active == 'dashboard student')? 'active':'';?>""><a href="<?= base_url('rc/dashboard')?>">Dashboard Student </a></li>
				<li class="<?= (!empty($active) && $active == 'absensi')? 'active':'';?>"><a href="<?= base_url('rc/absensi')?>">Absensi </a></li>
				<li class="<?= (!empty($active) && $active == 'student')? 'active':'';?>"><a href="<?= base_url('rc/student/manage')?>">Manage Student </a></li>
				<li class="<?= (!empty($active) && $active == 'submission')? 'active':'';?>"><a href="<?= base_url('rc/student/submission')?>">Pengajuan Pindah </a></li>
				<?php if($this->session->userdata('id') == '190' || $this->session->userdata('id') == '72'){ ?>
				<!-- <li class="<?= (!empty($active) && $active == 'dashboard student')? 'active':'';?>""><a href="<?= base_url('rc/dashboard')?>">Dashboard Student </a></li> -->
				<li class="<?= (!empty($active) && $active == 'branch')? 'active':'';?>""><a href="<?= base_url('rc/branch')?>">Manage Branch </a></li>
				<li class="<?= (!empty($active) && $active == 'periode')? 'active':'';?>""><a href="<?= base_url('rc/periode')?>">Manage Periode </a></li>
				<li class="<?= (!empty($active) && $active == 'classroom')? 'active':'';?>"><a href="<?= base_url('rc/classroom')?>">Manage Class </a></li>
				<li class="<?= (!empty($active) && $active == 'trainer')? 'active':'';?>"><a href="<?= base_url('rc/trainer')?>">Manage Trainer </a></li>
				<!-- <li class="<?= (!empty($active) && $active == 'student')? 'active':'';?>"><a href="<?= base_url('rc/student/manage')?>">Manage Student </a></li> -->
				<!-- <li class="<?= (!empty($active) && $active == 'absensi')? 'active':'';?>"><a href="<?= base_url('rc/absensi')?>">Absensi </a></li> -->
				<!-- <li class="<?= (!empty($active) && $active == 'submission')? 'active':'';?>"><a href="<?= base_url('rc/student/submission')?>">List Pengajuan Pindah </a></li> -->
				<?php } ?>
			</ul>
		</li>
		<?php }?>
		
		<!--<li class="<?= (!empty($active) && $active == 'Uang Masuk')? 'active':'';?>"> 
			<a href="<?= base_url('user/incentive/uang_masuk'); ?>"> <i class="fa fa-check"></i>&nbsp Check Uang Masuk</a>
		</li>-->
		
		<!--<li>
			<a href="#menu5" data-toggle="collapse" aria-expanded="false"><i class="fas fa-box-open"></i>&nbsp Logistic <i style="font-size: 0.70em;color: orange;">(Beta)</i></a>
			<ul class="collapse list-unstyled" id="menu5">
				<li class="<?= (!empty($active) && $active == 'Logistic')? 'active':'';?>"> 
        			<a href="<?= base_url('user/logistic'); ?>">Tools</a>
        		</li>
				<li class="<?= (!empty($active) && $active == 'Logistic Request')? 'active':'';?>"> 
					<a href="<?= base_url('user/logistic/request'); ?>">Request Tools <?php if($my_request_product > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;">'.$my_request_product.'</label>'; } ?></a>
				</li>
			</ul>
		</li>-->

		<?php } ?>
		
		<!-- SIDEBAR HR-->
		<?php if($this->session->userdata('level')=='hr'){ ?>
		
		<li class="<?= (!empty($active) && $active == 'dashboard')? 'active':'';?>"> 
			<a href="<?= base_url('dashboard'); ?>"> <i class="fa fa-home"></i>&nbsp Dashboard</a>
		</li>
		
		<li class="">
				<li class="<?= (!empty($active) && $active == 'Overtime')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime'); ?>"> <i class="fas fa-clock"></i>&nbsp Jam Overtime</a>
				</li>
    			<li class="<?= (!empty($active) && $active == 'Acc Overtime') ? 'active' : ''; ?>">
    				<a href="<?= base_url('hr/overtime/acc'); ?>"><i class="fas fa-clipboard-check"></i>&nbsp Acc Overtime</a>
    			</li>
				<li class="<?= (!empty($active) && $active == 'Report HR')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_hr'); ?>"> <i class="fas fa-clipboard-list"></i>&nbsp L-HR (Jam Overtime)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Report Izin')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_izin_hr'); ?>"> <i class="fas fa-clipboard-list"></i>&nbsp L-HR (Cuti Izin)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Report Sakit')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_sakit_hr'); ?>"><i class="fas fa-clipboard-list"></i>&nbsp L-HR (Cuti Sakit)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Data User')? 'active':'';?>">
        			<a href="<?= base_url('hr/user'); ?>"> <i class="fa fa-user"></i>&nbsp Data User <small class="badge badge-primary">Download</small></a>
        		</li>
        		<li class="<?= (!empty($active) && $active == 'Loker')? 'active':'';?>">
        			<a href="<?= base_url('hr/loker'); ?>"> <i class="fa fa-suitcase"></i>&nbsp Loker</a>
        		</li>
		</li>
		
		
		
		<?php }else if($this->session->userdata('id') == '190' || $this->session->userdata('id') == '72'){ ?>
		
		
		<br>
		<li>
			<small class="ml-4"><b>-</b> Sidebar HR</small>
		</li>
		
		<li class="">
				<li class="<?= (!empty($active) && $active == 'Overtime')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime'); ?>"> <i class="fas fa-clock"></i>&nbsp Jam Overtime</a>
				</li>
    			<li class="<?= (!empty($active) && $active == 'Acc Overtime') ? 'active' : ''; ?>">
    				<a href="<?= base_url('hr/overtime/acc'); ?>"><i class="fas fa-clipboard-check"></i>&nbsp Acc Overtime</a>
    			</li>
				<li class="<?= (!empty($active) && $active == 'Report HR')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_hr'); ?>"> <i class="fas fa-clipboard-list"></i>&nbsp L-HR (Jam Overtime)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Report Izin')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_izin_hr'); ?>"> <i class="fas fa-clipboard-list"></i>&nbsp L-HR (Cuti Izin)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Report Sakit')? 'active':'';?>"> 
					<a href="<?= base_url('hr/overtime/report_sakit_hr'); ?>"><i class="fas fa-clipboard-list"></i>&nbsp L-HR (Cuti Sakit)</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Data User')? 'active':'';?>">
        			<a href="<?= base_url('hr/user'); ?>"> <i class="fa fa-user"></i>&nbsp Data User <small class="badge badge-primary">Download</small></a>
        		</li>
        		<li class="<?= (!empty($active) && $active == 'Loker')? 'active':'';?>">
        			<a href="<?= base_url('hr/loker'); ?>"> <i class="fa fa-suitcase"></i>&nbsp Loker</a>
        		</li>
		</li>
        <?php } ?>
        
        
        
        		
		<!-- SIDEBAR FINANCE -->
		<?php if ($this->session->userdata('level') == 'finance' && ($this->session->userdata('id') == 67) !== false) { ?>
		<li class="<?= (!empty($active) && $active == 'dashboard') ? 'active' : ''; ?>">
				<a href="<?= base_url('finance/dashboard') ?>"><i class="fa fa-home"></i>&nbsp Dashboard<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		
		<li>
			<a href="#menu7" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user-plus"></i>&nbsp Signup</a>
			<ul class="collapse list-unstyled" id="menu7">
				<li class="<?= (!empty($active) && $active == 'Confirm Signup')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/confirm')?>">Confirm Signup <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Confirm Repayment')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/confirm_repayment')?>">Confirm DP</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Set Batch')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/batch')?>">Set Batch <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Transaksi')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/master')?>">Data Transaksi <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Peserta')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/master_participant')?>">Data Participant <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="#menu16" data-toggle="collapse" aria-expanded="false"><i class="fas fa-list-alt"></i>&nbsp Nomerator<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu16">
				<li class="<?= (!empty($active) && $active == 'Report Nomerator') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/nomerator/report_nomerator'); ?>">Report Nomerator<br><small class="text-warning"><i>Beta Version</i></small></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Approve Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/approve_transaction'); ?>">Approve Transaction</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="#menu8" data-toggle="collapse" aria-expanded="false"><i class="fas fa-tasks"></i>&nbsp Management<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu8">
			    <li class="<?= (!empty($active) && $active == 'Manage Accountant') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant'); ?>">Manage Accountant</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage PT') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/pt'); ?>">Manage PT</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Bank') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/bank'); ?>">Manage Bank</a>
				</li>
				 <li class="<?= (!empty($active) && $active == 'Manage Divisi') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/divisi'); ?>">Manage Divisi</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Head Divisi') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/head_divisi'); ?>">Manage Head Divisi</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Index') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/indeks'); ?>">Manage Indeks</a>
				</li>
			</ul>
		</li>
		
	    <li>
			<a href="#menu5" data-toggle="collapse" aria-expanded="false"><i class="fas fa-balance-scale"></i>&nbsp Transaction<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu5">
				<li class="<?= (!empty($active) && $active == 'Income Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/income'); ?>">Income Transaction</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Exoense Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/expense'); ?>">Expense Transaction</a>
				</li>
			</ul>
		</li>
		
	    <li>
			<a href="#menu12" data-toggle="collapse" aria-expanded="false"><i class="fa fa-line-chart"></i>&nbsp Report<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu12">
				<li class="<?= (!empty($active) && $active == 'Monthly Report') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report'); ?>">Monthly Report</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Finance Summary') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report/finance_summary'); ?>">Finance Summary</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'MRLC P&L') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report/pl_mrlc'); ?>">MRLC P&L</a>
				</li>
			</ul>
		</li>
		
		<li class="<?= (!empty($active) && $active == 'Transfer') ? 'active' : ''; ?>">
			<a href="<?= base_url('finance/transfer') ?>"><i class="fas fa-bank"></i>&nbsp Transfer<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		
		<li>
			<a href="#menu9" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>&nbsp Incentive</a>
			<ul class="collapse list-unstyled" id="menu9">

				<li class="<?= (!empty($active) && $active == 'Future Task')? 'active':'';?>"> 
					<a href="<?= base_url('finance/incentive/future'); ?>">Future Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Last Task')? 'active':'';?>"> 
					<a href="<?= base_url('finance/incentive'); ?>">Last Task</a>
				</li>

			</ul>
		</li>
		
		<li class="<?= (!empty($active) && $active == 'Money Checker')? 'active':'';?>">
			<a href="<?= base_url('finance/incentive/moneychecker'); ?>"> <i class="fa fa-check"></i>&nbsp Cek Uang Masuk</a>
		</li>
		
		
		
		<?php } else if ($this->session->userdata('level') == 'finance') { ?>
		
		
		
		<li class="<?= (!empty($active) && $active == 'dashboard') ? 'active' : ''; ?>">
			<a href="<?= base_url('finance/dashboard') ?>"><i class="fa fa-home"></i>&nbsp Dashboard<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		<li>
			<a href="#menu8" data-toggle="collapse" aria-expanded="false"><i class="fas fa-tasks"></i>&nbsp Management<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu8">
				<li class="<?= (!empty($active) && $active == 'Manage Bank') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/bank'); ?>">Manage Bank</a>
				</li>
			</ul>
		</li>
		
		<!--<li>-->
		<!--	<a href="#menu9" data-toggle="collapse" aria-expanded="false"><i class="fas fa-list-alt"></i>&nbsp Tanda Terima<br><small class="text-warning"><i>Beta Version</i></small></a>-->
		<!--	<ul class="collapse list-unstyled" id="menu9">-->
		<!--		<li class="<?= (!empty($active) && $active == 'Acc Tanda Terima') ? 'active' : ''; ?>">-->
		<!--			<a href="<?= base_url('finance/tandaterima'); ?>">Acc Tanda Terima<br><small class="text-warning"><i>Beta Version</i></small></a>-->
		<!--		</li>-->
		<!--	</ul>-->
		<!--</li>-->
		
		 <li>
			<a href="#menu5" data-toggle="collapse" aria-expanded="false"><i class="fas fa-balance-scale"></i>&nbsp Transaction<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu5">
				<li class="<?= (!empty($active) && $active == 'Income Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/income'); ?>">Income Transaction</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Exoense Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/expense'); ?>">Expense Transaction</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Approve Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/approve_transaction'); ?>">Approve Transaction</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#menu12" data-toggle="collapse" aria-expanded="false"><i class="fa fa-line-chart"></i>&nbsp Report<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu12">
				<li class="<?= (!empty($active) && $active == 'Monthly Report') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report'); ?>">Monthly Report</a>
				</li>
			</ul>
		</li>
		<li class="<?= (!empty($active) && $active == 'Transfer') ? 'active' : ''; ?>">
			<a href="<?= base_url('finance/transfer') ?>"><i class="fas fa-bank"></i>&nbsp Transfer<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		
		
		
		<?php }else if($this->session->userdata('id') == '190' || $this->session->userdata('id') == '72' || $this->session->userdata('id') == '163') { ?>
		<br>
		<li>
			<small class="ml-4"><b>-</b> Sidebar Finance</small>
		</li>
		
		<?php if($this->session->userdata('id') != '163'){ ?>
		<li class="<?= (!empty($active) && $active == 'dashboard') ? 'active' : ''; ?>">
				<a href="<?= base_url('finance/dashboard') ?>"><i class="fa fa-home"></i>&nbsp Dashboard<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		
		<li>
			<a href="#menu7" data-toggle="collapse" aria-expanded="false"><i class="fa fa-user-plus"></i>&nbsp Signup</a>
			<ul class="collapse list-unstyled" id="menu7">
				<li class="<?= (!empty($active) && $active == 'Confirm Signup')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/confirm')?>">Confirm Signup <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Confirm Repayment')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/confirm_repayment')?>">Confirm DP</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Set Batch')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/batch')?>">Set Batch <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Transaksi')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/master')?>">Data Transaksi <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Peserta')? 'active':'';?>"> 
					<a href="<?= base_url('finance/signup/master_participant')?>">Data Participant <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="#menu16" data-toggle="collapse" aria-expanded="false"><i class="fas fa-list-alt"></i>&nbsp Nomerator<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu16">
				<li class="<?= (!empty($active) && $active == 'Report Nomerator') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/nomerator/report_nomerator'); ?>">Report Nomerator<br><small class="text-warning"><i>Beta Version</i></small></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Approve Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/approve_transaction'); ?>">Approve Transaction</a>
				</li>
			</ul>
		</li>
		
		<li>
			<a href="#menu8" data-toggle="collapse" aria-expanded="false"><i class="fas fa-tasks"></i>&nbsp Management<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu8">
			    <li class="<?= (!empty($active) && $active == 'Manage Accountant') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant'); ?>">Manage Accountant</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage PT') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/pt'); ?>">Manage PT</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Bank') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/bank'); ?>">Manage Bank</a>
				</li>
				 <li class="<?= (!empty($active) && $active == 'Manage Divisi') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/divisi'); ?>">Manage Divisi</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Head Divisi') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/head_divisi'); ?>">Manage Head Divisi</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Manage Index') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/indeks'); ?>">Manage Indeks</a>
				</li>
			</ul>
		</li>
		
	    <li>
			<a href="#menu5" data-toggle="collapse" aria-expanded="false"><i class="fas fa-balance-scale"></i>&nbsp Transaction<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu5">
				<li class="<?= (!empty($active) && $active == 'Income Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/income'); ?>">Income Transaction</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Exoense Transaction') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/accountant/expense'); ?>">Expense Transaction</a>
				</li>
			</ul>
		</li>
		
	    <li>
			<a href="#menu12" data-toggle="collapse" aria-expanded="false"><i class="fa fa-line-chart"></i>&nbsp Report<br><small class="text-warning"><i>Beta Version</i></small></a>
			<ul class="collapse list-unstyled" id="menu12">
				<li class="<?= (!empty($active) && $active == 'Monthly Report') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report'); ?>">Monthly Report</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Finance Summary') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report/finance_summary'); ?>">Finance Summary</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'MRLC P&L') ? 'active' : ''; ?>">
					<a href="<?= base_url('finance/report/pl_mrlc'); ?>">MRLC P&L</a>
				</li>
			</ul>
		</li>
		
		<li class="<?= (!empty($active) && $active == 'Transfer') ? 'active' : ''; ?>">
			<a href="<?= base_url('finance/transfer') ?>"><i class="fas fa-bank"></i>&nbsp Transfer<br><small class="text-warning"><i>Beta Version</i></small></a>
		</li>
		<?php } ?>
		
		<li>
			<a href="#menu9" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>&nbsp Incentive</a>
			<ul class="collapse list-unstyled" id="menu9">

				<li class="<?= (!empty($active) && $active == 'Future Task')? 'active':'';?>"> 
					<a href="<?= base_url('finance/incentive/future'); ?>">Future Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Last Task')? 'active':'';?>"> 
					<a href="<?= base_url('finance/incentive'); ?>">Last Task</a>
				</li>
			</ul>
		</li>
		
		<?php if($this->session->userdata('id') != '163'){ ?>
		
    		<li class="<?= (!empty($active) && $active == 'Money Checker')? 'active':'';?>">
    			<a href="<?= base_url('finance/incentive/moneychecker'); ?>"> <i class="fa fa-check"></i>&nbsp Cek Uang Masuk</a>
    		</li>
		<?php } ?>
		<?php } ?>
		
		
		
		
		
		<!-- SIDEBAR SUPPORT -->
		<?php if($this->session->userdata('level')=='support'){ ?>
		<li> 
			<a href="#menu10" data-toggle="collapse" aria-expanded="true"><i class="fa fa-book"></i>&nbsp Task Allocation</a>
			<ul class="collapse list-unstyled show" id="menu10">
				<li class="<?= (!empty($active) && $active == 'Future Task Support')? 'active':'';?>"> 
					<a href="<?= base_url('support/task');?>">Future Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Last Task Support')? 'active':'';?>"> 
					<a href="<?= base_url('support/task/all'); ?>">Last Task</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'List Incentive')? 'active':'';?>"> 
					<a href="<?= base_url('support/task/list_incentive'); ?>">List Incentive SP</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Overview Task')? 'active':'';?>"> 
					<a href="<?= base_url('support/task/overview'); ?>">Report Task Allocation</a>
				</li>			
			</ul>
		</li>
		<?php } ?>
		
		
		
		
		
		<!-- SIDEBAR LOGISTIC -->
		<?php if($this->session->userdata('level')=='logistic'){ ?>
		<li> 
			<a href="#menu11" data-toggle="collapse" aria-expanded="true"><i class="fa fa-book"></i>&nbsp Product</a>
			<ul class="collapse list-unstyled show" id="menu11">
				<li class="<?= (!empty($active) && $active == 'Product')? 'active':'';?>"> 
					<a href="<?= base_url('logistic/product');?>">Product</a>
				</li>
				<!--<li class="<?= (!empty($active) && $active == 'List Request')? 'active':'';?>"> 
					<a href="<?= base_url('logistic/product/request'); ?>">List Request <?php if($request_product > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;">'.$request_product.'</label>'; } ?></a>
				</li>-->
				<li class="<?= (!empty($active) && $active == 'Event Request')? 'active':'';?>"> 
					<a href="<?= base_url('logistic/product/event_request'); ?>">Event Request <?php //if($event_request_product > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;">'.$event_request_product.'</label>'; } ?></a>
				</li>
			</ul>
		</li>
		<?php } ?>
		
		
		
		
		
		<!-- SIDEBAR viewer -->
		<?php if($this->session->userdata('level')=='viewer'){ ?>
		<li>
			<a href="#menu7" data-toggle="collapse" aria-expanded="true"><i class="fa fa-user-plus"></i>&nbsp Signup</a>
			<ul class="collapse list-unstyled show" id="menu7">
				<li class="<?= (!empty($active) && $active == 'Confirm Signup')? 'active':'';?>"> 
					<a href="<?= base_url('viewer/signup/confirm')?>">Confirm Signup <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Confirm Repayment')? 'active':'';?>"> 
					<a href="<?= base_url('viewer/signup/confirm_repayment')?>">Confirm Pembayaran DP</a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Set Batch')? 'active':'';?>"> 
					<a href="<?= base_url('viewer/signup/batch')?>">Set Batch <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Transaksi')? 'active':'';?>"> 
					<a href="<?= base_url('viewer/signup/master')?>">Data Transaksi <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
				<li class="<?= (!empty($active) && $active == 'Master Data Peserta')? 'active':'';?>"> 
					<a href="<?= base_url('viewer/signup/master_participant')?>">Data Peserta <?php if($acc > 0){ echo '<label class="badge badge-light float-right" style="cursor: auto;font-weight:bold;"></label>'; } ?></a>
				</li>
			</ul>
			
		</li>
		<?php }?>
		
	</ul>

</nav>

<div id="content" class="dinamisTop">