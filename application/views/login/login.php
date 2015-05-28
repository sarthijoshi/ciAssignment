<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div style="float: left;min-height: 760px;">
                <div id="login" style="height: <?php echo isset($divHeight) ? $divHeight : '' ?>" class="animate form">
                    <form  data-parsley-validate method="post" action="<?php echo base_url(); ?>users/login"> 
                        <h1>Sign In</h1> 
                        <a style="float: right;margin-top: -15px;" href="<?php echo base_url() ?>users/registration">Click here to register</a>
                        <p> 
                            <label for="e-mail" data-icon="u" > E-mail Address</label>
                            <input type="email" required data-parsley-trigger="change"  id="emailAddress" name="emailAddress" 
                            value="<?php if (isset($_COOKIE['emailAddress'])) {echo $_COOKIE['emailAddress'];}?>"placeholder="mymail@mail.com"/>
                        </p>
                        <p> 
                            <label for="password" data-icon="p">Password </label>
                            <input id="userPwd" name="userPwd" type="password" required data-parsley-required-message="password is required." placeholder="********" /> 
                        </p>
                        <p class="login button"> 
                            <input type="submit" value="Login" /> 
                        </p>
                        <p class="keeplogin"> 
                            <label for="loginkeeping">Remember Me</label>
                            <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                        </p>
                        <p class="forgetpwd"> 
                            <a href="<?php echo base_url() ?>users/forgetPassword">forgot your Password?</a>
                        </p>
                        <p class="loginErr" style="float: left; color: red;">
                            <?php
                            if ($this->session->flashdata('loginError')) {
                                echo $this->session->flashdata('loginError');
                            }
                            ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
