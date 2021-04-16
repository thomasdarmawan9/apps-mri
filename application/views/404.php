<!DOCTYPE html>
<html>
<head>
  <title>404 Error not found!</title>
  <meta charset="utf-8">
  <meta content="ie=edge" http-equiv="x-ua-compatible">
  <meta content="template language" name="keywords">
  <meta content="Tamerlan Soziev" name="author">
  <meta content="Admin dashboard html template" name="description">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="<?= base_url('inc/image/logo.png');?>" rel="shortcut icon">
  <link href="<?php echo base_url(); ?>inc/404/main.css?version=2.6" rel="stylesheet">
</head>
<body>
  <div class="all-wrapper menu-side">
    <div class="layout-w">


      <div class="content-w">

        <div class="content-i">
          <div class="content-box mb-5">
            <div class="big-error-w w-100" style="max-width:500px;">
              <img src="<?= base_url('inc/image/logo.png');?>" class="w-100" style="max-width:150px;"><br><br>
              <h1>
                404
              </h1>
              <h5 style="color:#333;">
                Page not Found
              </h5>
              <h4>
                Oops, Something went missing...
              </h4>
              <br>
              <a onclick="history.go(-1);"><button class="btn btn-primary"  style="cursor:pointer;"> <i class="os-icon os-icon-common-07"></i> Back</button></a>          
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="display-type"></div>
  </div>

</body>
</html>
