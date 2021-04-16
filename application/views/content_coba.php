  <!-- BEGIN PAGE CONTAINER-->
  <div class="page-content">
    
    <div class="content ">
      <ul class="breadcrumb">
			<li>
			  <p>FITUR</p>
			</li>
			<li><a href="#" class="active">Coba</a> </li>
		</ul>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>Coba <span class="semi-bold"></span></h3>
      </div>
      <div id="container">
		
		<?php
		for($x=0;$x<$jmh_user;$x++){
			//Print Result name & their over time save
			echo $hasil[$x][0].' '.$hasil[$x][1].' ';
			//Looping to print their time of over time save 
			for($d=0;$d < $jmh_hari;$d++){
				echo $hasil[$x][$d+1].' ';
			}
			
			echo '<br>';
		}
		?>
		
      </div>
      <!-- END PAGE -->
    </div>
  </div>
<!-- END CONTAINER -->
</div>

