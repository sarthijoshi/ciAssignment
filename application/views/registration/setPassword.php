<div class="container">
    <section>
        <div id="container_demo" >
            <div id="wrapper">
                <div id="login" class="animate form">
                    <form data-parsley-validate method="post" action="<?php echo base_url(); ?>users/setPassword"> 
                        <h1>Welcome</h1> 
                        <?php
                        $userInformation = $this->session->userdata('userInformation');
                        ?>
                        <p> 
                            <label for="primaryEmail">Primary E-mail:</label>
                            <input type="email" required data-parsley-trigger="change" value="<?php echo $userInformation['userEmail'] ?>" readonly="readonly"/>
                        </p>
                        <p> 
                            <label for="newPwd">Password:</label>
                            <input required data-parsley-required-message="password is required." data-parsley-equalto="#newPwd" data-parsley-minlength="8" id="newPwd" name="newPwd"  type="password" placeholder="********" /> 
                            <label for="password">Hint: Password must be 8 or more character with one number.</label>
                        </p>
                        <p> 
                            <label for="confirmNewPwd">Confirm Password:</label>
                            <input required data-parsley-equalto="#newPwd" data-parsley-minlength="8" data-parsley-error-message="Password and confirm password must be same." id="confirmNewPwd" name="confirmNewPwd" type="password" placeholder="********" /> 
                        </p>
                        <p> 
                            <label for="pin">Create PIN:</label>
                            <input id="pin" required data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" data-parsley-minlength="4" name="pin" type="password" placeholder="****" /> 
                            (4 Digits)
                        </p>
                        <p> 
                            <label for="dob">Date Of Birth:</label>
                            <input class="dob" id="dob" name="dob" type="text" /> 
                            (xx/xx/xxxx)
                        </p>
                        <p class="login button"> 
                            <input type="button" onclick=" window.history.back();" value="Cancel" />
                            <input type="submit" value="Continue" /> 
                        </p>
                        <p class="loginErr" style="float: left; color: red;">
                            <?php
                            if ($this->session->flashdata('setPasswordError')) {
                                echo $this->session->flashdata('setPasswordError');
                            }
                            ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

