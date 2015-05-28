<!DOCTYPE html>
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <title>Assignment</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <!--include css-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/header.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/animate-custom.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/parsley.css" />
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js" type="text/javascript"></script>
        <!--include js-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>
        <!--script for parsley validation-->
        <script src="<?php echo base_url(); ?>assets/js/parsley.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/validator.js" type="text/javascript"></script>
        <!--End of script for parsley validation-->
        <script type="text/javascript">
            var baseUrl = "http://localhost/current/";

            $(function () {
                $(".dob").datepicker({
                    dateFormat: "yy-mm-dd",
                    hideIfNoPrevNext: true,
                });
            });
        </script>
    </head>
    <body style="background-image: url('<?php echo base_url(); ?>assets/images/background.jpg');">
        <!--<body>-->    
        <div class="header">
            <div class="grid-view">
                <div class="logo">
                    <img src="<?php echo base_url(); ?>assets/images/icon.jpeg"/>
                </div>
                <?php
                $userInformation = $this->session->userdata('userInformation');
                if (isset($userInformation['userEmail'])) {
                    ?>
                    <ul class="nav-bar">

                        <li><a href="<?php echo base_url(); ?>users/proposal" class="<?php echo ($this->uri->uri_string() == 'users/proposal' ? 'active' : ''); ?>">Proposals</a></li>
                        <li><a href="<?php echo base_url(); ?>users/profile" class="<?php echo ($this->uri->uri_string() == 'users/profile' ? 'active' : ''); ?>">Profile</a></li>
                        <li><a href="<?php echo base_url(); ?>users/help" class="<?php echo ($this->uri->uri_string() == 'users/help' ? 'active' : ''); ?>">Help</a></li>
                    </ul>
                <?php } else { ?>
                    <div style="color: steelblue;float: left;font-size: 30px;margin-left: 280px;margin-top: 39px;">Welcome to Site. Please Login or Register </div>
                <?php } ?>
            </div>
            <div id="userInfo" style=" float: right;height: 42px;margin-right: 75px;margin-top: 34px;width: 214px;">
                <?php
                if (isset($userInformation['userEmail'])) {
                    ?>
                    <label style="font-weight: bold;"><?php echo $userInformation['userEmail'] ?></label>
                    <a class="logout-link" href="<?php echo base_url(); ?>users/logout">Logout</a>
                <?php } else { ?>
                <?php } ?>
            </div>
        </div>     
