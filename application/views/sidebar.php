<div class="sidebar" data-color="black" data-image="assets/themplate/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    Warriors
                </a>
            </div>

            <ul class="nav">
                <li class="<?php if (!empty($_GET['event']) and ($_GET['event']=='beranda')){ echo 'active'; } ?>" >
                    <a href="http://apps.mri.co.id/?event=beranda">
                        <i class="pe-7s-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="<?php if (!empty($_GET['event']) and ($_GET['event']=='jam-lembur')){ echo 'active'; } ?>" >
                    <a href="http://apps.mri.co.id/?event=jam-lembur">
                        <i class="pe-7s-alarm"></i>
                        <p>Jam Lembur</p>
                    </a>
                </li>
                <li class="<?php if (!empty($_GET['event']) and ($_GET['event']=='kpi')){ echo 'active'; } ?>">
                    <a href="http://apps.mri.co.id/?event=kpi">
                        <i class="pe-7s-display2"></i>
                        <p>KPI</p>
                    </a>
                </li>
                <li class="<?php if (!empty($_GET['event']) and ($_GET['event']=='profil')){ echo 'active'; } ?>">
                    <a href="http://apps.mri.co.id/?event=profil">
                        <i class="pe-7s-user"></i>
                        <p>profil</p>
                    </a>
                </li>
                <li class="<?php if (!empty($_GET['event']) and ($_GET['event']=='pemberitahuan')){ echo 'active'; } ?>">
                    <a href="http://apps.mri.co.id/?event=pemberitahuan">
                        <i class="pe-7s-bell"></i>
                        <p>Pemberitahuan</p>
                    </a>
                </li>

            </ul>
    	</div><!-- End sidebar-wrapper -->
    </div><!-- End sidebar -->