<!-- BEGIN PAGE CONTAINER-->
<div class="page-content">

    <div class="content ">

        <div class="page-title"> <i class="icon-custom-left"></i>
            <h3>Dashboard <span class="semi-bold"></span></h3>
        </div>
        <div id="container">

            <div class="grid simple">

                <div class="grid-body no-border" style="display: block;"> <br>

                    <div class="row">
                        <div class="col-md-7">
                            <div>
                                <!--<div class="alert alert-info" id="msg-info">
								<b> New Update Overtime</b>: Jika lembur dibawah 30 menit maka akan dianggap tidak lembur, jika diatas 30 menit maka dianggap lembur 30 menit.
							</div>-->
                                <h1 style="font-size: 50px;font-weight: 600;font-style: italic;letter-spacing: -1.3px;color: #0d4e6c;margin-top:20px;">Hello, <?php echo ucfirst($this->session->userdata('username')); ?></h1>
                                <p style="font-size: 20px;line-height: 1.4;letter-spacing: -.5px;color: #6f6f6f;">This is Your Company's Transaction for This Month</p>
                            </div>
                            <div class="row mb-6">
                                <div class="col-12 col-md-8 my-1">
                                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                        <div class="card-header"><i class="fa fa-arrow-left" style="float: left"></i><b style="float: right">Profit/Loss Bulan <?php echo date('M', strtotime('-1 month')) ?> </b></div>
                                        <div class="card-body">
                                            <?php if (!empty($last)) { ?>
                                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($last, 2) ?></h3>
                                            <?php } else { ?>
                                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                                            <?php } ?>
                                        </div>
                                        <!-- <div class="card-footer bg-transparent "><a href="#"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></a></div> -->
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-1">
                                    <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                                        <div class="card-header"><b style="float:left">Profit/Loss Bulan <?php echo date('M') ?> </b><i class="fa fa-arrow-right" style="float: right"></i></div>
                                        <div class="card-body">
                                            <?php if (!empty($transaction)) { ?>
                                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($transaction, 2) ?></h3>
                                            <?php } else { ?>
                                                <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                                            <?php } ?>
                                        </div>
                                        <!-- <div class="card-footer bg-transparent "><a href="#"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></a></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5"><img src="<?= base_url(); ?>inc/image/dashboard_finance.png" class="animated bounceIn" style="width:100%;"></div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <h3 style="font-size: 50px; color: #32a0a8 ;margin-top:20px;"><b>Transaksi Berjalan</b></h3>
                                <hr>
                            </center>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <?php 
                        if (!empty($bank)) {
                        foreach ($bank as $row) { ?>
                            <div class="col-sm-4">
                                <div class="card text-white bg-dark mb-3" style="max-width: 25rem;">
                                    <div class="card-header"><b style="float: left"><?php echo $row->pt ?> </b> <i class="fa fa-bank" style="float:right"></i></div>
                                    <div class="card-title"><b style="float: right; margin-right:20px; margin-top: 15px"><?php echo $row->atas_nama ?> </b></div>
                                    <div class="card-body">
                                        <span style="font-weight:bold;margin-left: 1px; float:left">Profit/Loss <?php echo date('M') ?> :</span><br>
                                        <?php if (!empty($row->tr)) { ?>
                                            <h3 class=" my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.<?php echo number_format($row->tr, 2) ?></h3>
                                        <?php } else { ?>
                                            <h3 class="my-3" style="font-size: 2em;color: white;font-weight:bold;text-align: center;">Rp.0</h3>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer bg-transparent"><a href="<?php echo base_url('finance/dashboard/dashboard_detail/' . $row->id_pt) ?>"><i class="fas fa-forward" style="float: right"></i><b>Transaction Detail</b></a></div>
                                </div>
                            </div>
                        <?php }
                        } else {
                            echo "<p class='mx-auto d-block'>Belum ada Transaksi yang Berjalan</p>";
                        }  ?>

                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>
        </div>