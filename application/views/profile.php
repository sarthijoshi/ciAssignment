<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div id="login" style="margin-left: 129px;width: 601px;" class="animate form">
                    <form data-parsley-validate method="POST" action="<?php echo base_url(); ?>users/updateProfile"> 
                        <h1>User Profile</h1> 
                        <?php
                        foreach ($profile as $profileInformation) {
                            ?>
                            <p>
                                <a style="float: right;margin-right: 10px;margin-top: -23px;"href="<?php echo base_url() ?>users/changePassword">Change Password</a>
                            </p>
                            <p> 
                                <label for="firstname">First Name </label>
                                <input required class="profileClass" title="Click on Edit button to change" readonly="readonly" id="firstname" name="firstname" type="text" value="<?php echo $profileInformation['first_name'] ?>"/> 
                            </p>
                            <p> 
                                <label for="middelname">Middle Name </label>
                                <input class="profileClass" title="Click on Edit button to change" readonly="readonly" id="middlename" name="middlename" type="text" value="<?php echo $profileInformation['middle_name'] ?>"/> 
                            </p>
                            <p> 
                                <label for="lastname">Last Name </label>
                                <input required class="profileClass" title="Click on Edit button to change" readonly="readonly" id="lastname" name="lastname" type="text" value="<?php echo $profileInformation['last_name'] ?>"/> 
                            </p>
                            <p> 
                                <label for="phone">Mobile No</label>
                                <input required data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" data-parsley-minlength="10" class="profileClass" title="Click on Edit button to change" readonly="readonly" id="phone" name="phone" type="text" value="<?php echo $profileInformation['phone_number'] ?>"/> 
                            </p>
                            <p> 
                                <label for="userAddress">Address </label>
                                <textarea class="profileClass" title="Click on Edit button to change" readonly="readonly" id="useraddress" name="useraddress" value="<?php echo $profileInformation['address'] ?>"><?php echo $profileInformation['address'] ?></textarea>
                            </p>
                            <p> 
                                <label for="country">Country</label>
                                <input required class="profileClass" title="Click on Edit button to change" readonly="readonly" id="usercountry" name="usercountry" type="text" value="<?php echo $profileInformation['country'] ?>"/> 
                            </p>
                            <p> 
                                <label for="state">State</label>
                                <input class="profileClass" title="Click on Edit button to change" readonly="readonly" id="userstate" name="userstate" type="text" value="<?php echo $profileInformation['state'] ?>"/> 
                            </p>
                            <p> 
                                <label for="city">City</label>
                                <input required class="profileClass" title="Click on Edit button to change" readonly="readonly" id="usercity" name="usercity" type="text" value="<?php echo $profileInformation['city'] ?>"/> 
                            </p>
                            <p> 
                                <label for="dob">Date Of Birth</label>
                                <input class="profileClass dob" title="Click on Edit button to change" readonly="readonly" id="dob" name="dob" type="text" value="<?php echo $profileInformation['birthday'] ?>"/> 
                            </p>
                            <p class="login button">
                                <input type="button" class="editProfile" id="editProfile" value="Edit" style=" float: right;margin-right: 133px;"/>
                                <input type="submit" class="updateProfile" id="updateProfile" value="Save" style="float: right;margin-right: -274px;display:none;"/>
                            </p>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!--Script for edit button click function-->
<script src="<?php echo base_url(); ?>assets/js/profile.js" type="text/javascript"></script>
