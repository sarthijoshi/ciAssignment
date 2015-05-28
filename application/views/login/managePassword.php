<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div style="float: left;min-height: 760px;">
                    <div id="login" class="animate form">
                        <form  data-parsley-validate method="post" action="<?php echo base_url() ?>users/createNewPassword"> 
                            <h1>Manage Password </h1> 
                            <p> 
                                <label for="email" data-icon="p">Email</label>
                                <input data-parsley-trigger="change" required id="email_id" name="email_id" value="<?php echo $emailAddress; ?>" type="email" placeholder="mymail@mail.com"/> 
                            </p>
                            <p> 
                                <label for="password" data-icon="p">New Password </label>
                                <input required data-parsley-required-message="new password is required." data-parsley-equalto="#new_password" id="new_password" name="new_password" type="password" placeholder="********" /> 
                            </p>
                            <p> 
                                <label for="password" data-icon="p">Confirm Password </label>
                                <input required data-parsley-equalto="#new_password" data-parsley-error-message="Confirm Password must match New Password" id="confirm_new_password" name="confirm_new_password" type="password" placeholder="********" /> 
                            </p>
                            <p class="login button"> 
                                <input type="button" onclick=" window.history.back();" value="Back" />
                                <input type="submit" value="OK" />
                            </p>
                            <p class="loginErr" style="float: left; color: red;">
                                <?php
                                if ($this->session->flashdata('emailError')) {
                                    echo $this->session->flashdata('emailError');
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
