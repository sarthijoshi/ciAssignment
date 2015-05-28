<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div style="float: left;min-height: 760px;">
                    <div id="login" class="animate form">
                        <form  data-parsley-validate method="post" action="forgetPassword"> 
                            <h1>Forgot password? </h1> 
                            <p> 
                                <label for="emailAddress"> E-mail Address</label>
                                <input type="email" data-parsley-trigger="change" required id="userEmail"  name="userEmail" placeholder="mymail@mail.com"/>
                            </p>
                            <p class="login button"> 
                                <input type="button" onclick=" window.history.back();" value="Back" />
                                <input type="submit" value="Go" /> 
                            </p>
                            <p class="loginErr" style="float: left; color: red;">
                                <?php
                                if ($this->session->flashdata('forgetPwdError')) {
                                    echo $this->session->flashdata('forgetPwdError');
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
