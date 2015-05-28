<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div style="float: left;min-height: 760px;">
                    <div id="login" class="animate form">
                        <form  data-parsley-validate method="post" action="<?php echo base_url() ?>users/changePassword"> 
                            <h1>Change your password </h1> 
                            <p> 
                                <label for="password" data-icon="p">Old Password </label>
                                <input id="oldPassword" name="oldPassword" type="password" required data-parsley-required-message="old password is required." placeholder="********" /> 
                            </p>
                            <p> 
                                <label for="password" data-icon="p">New Password </label>
                                <input id="newPassword" name="newPassword" type="password" required data-parsley-required-message="new password is required." data-parsley-equalto="#newPassword"  placeholder="********" /> 
                            </p>
                            <p> 
                                <label for="password" data-icon="p">Confirm Password </label>
                                <input id="confirmPassword" name="confirmPassword" type="password" required data-parsley-equalto="#newPassword" data-parsley-error-message="Confirm Password must match New Password" placeholder="********" /> 
                            </p>
                            <p class="login button"> 
                                <input type="button" onclick=" window.history.back();" value="Back"/>
                                <input type="submit" value="OK"/>
                            </p>
                            <p class="loginErr" style="float: left; color: red;">
                                <?php
                                if ($this->session->flashdata('changePwdError')) {
                                    echo $this->session->flashdata('changePwdError');
                                }
                                ?>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>