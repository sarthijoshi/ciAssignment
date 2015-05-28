<div class="container">
    <section>
        <div id="container_demo" >
            <div id="wrapper">
                <div id="login" class="animate form" style=" margin-left: 129px;width: 601px;">
                    <form  data-parsley-validate method="post"  action="registration"> 
                        <h1>Registration</h1> 
                        <p>
                            <b><h3><label for="personalInfo"> Personal Information</label></h3></b>
                            <a style="float: right;margin-top: -20px;" href="login">login</a>
                        </p>
                        <p> 
                            <label for="firstName">First Name:</label>
                            <input type="text" required id="firstName"  name="firstName"  placeholder="Enter First Name"/>
                        </p>
                        <p> 
                            <label for="middleName"> Middle Name:</label>
                            <input  type="text" id="middleName"  name="middleName"  placeholder="Enter Middle Name"/>
                        </p>
                        <p> 
                            <label for="lastName"> Last Name:</label>
                            <input  type="text" required id="lastName"  name="lastName"  placeholder="Enter Last Name"/>
                        </p>
                        <p>
                            <b><h3><label for="addressInfo">Address Information</label></h3></b>
                        </p>
                        <p> 
                            <label for="mailingAddress">Mailing Address:</label>
                            <input type="text" id="mailingAddress1"  name="mailingAddress1"/>
                            <input type="text" id="mailingAddress2"  name="mailingAddress2" />
                            <input type="text" id="mailingAddress3"  name="mailingAddress3" />
                        </p>
                        <p> 
                            <label for="country">Country:</label>
                            <select required id="country"  name="country">
                                <option value="">SELECT</option>
                                <option value="INDIA">INDIA</option>
                                <option value="UNITED STATES">UNITED STATES</option>
                                <option value="SHRI LANKA">SHRI LANKA</option>
                            </select>
                        </p>
                        <p> 
                            <label for="state">State:</label>
                            <select id="state"  name="state">
                                <option value="">SELECT</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Gujarat">Gujarat</option>
                            </select>
                        </p>
                        <p> 
                            <label for="city">City:</label>
                            <input  type="text" required id="city" name="city" placeholder="Enter City Here"/>
                        </p>
                        <p>
                            <b><h3><label for="contact">Contact Information</label></h3></b>
                        </p>
                        <p>
                        <h3><label for="phone">Phone:</label></h3>
                        <input  type="text" required data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" data-parsley-minlength="10" id="phone" name="phone"  placeholder="Enter Phone Number Here"/>
                        Ext.:<input type="text" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" id="phoneExt"  name="phoneExt"/>
                        <select required id="phoneCountry"  name="phoneCountry">
                            <option value="">SELECT</option>
                            <option value="INDIA">INDIA</option>
                            <option value="UNITED STATES">UNITED STATES</option>
                            <option value="SHRI LANKA">SHRI LANKA</option>
                        </select>
                        </p>
                        <p>
                        <h3><label for="fax">Fax:</label></h3>
                        <input type="text" required data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" id="fax"  name="fax"  placeholder="Enter Fax Number Here"/>
                        Ext.:<input type="text" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" 
                                data-parsley-type="digits" id="faxExtension"  name="faxExtension"/>
                        <select required id="faxCountry"  name="faxCountry">
                            <option value="">SELECT</option>  
                            <option value="INDIA">INDIA</option>
                            <option value="UNITED STATES">UNITED STATES</option>
                            <option value="SHRI LANKA">SHRI LANKA</option>
                        </select>
                        </p>
                        <p>
                            <b><h3><label for="email">E-mail:</label></h3></b>
                            <input  type="email" required data-parsley-trigger="change" id="emailInput"  name="emailInput"  placeholder="Enter E-mail Id Here"/>
                        </p>
                        <p>
                        <h3><label for="commMethod">Comm Method:</label></h3>
                        <select required id="commMethod"  name="commMethod">
                            <option value="">Select</option>
                            <option value="Email">Email</option>
                            <option value="Fax">Fax</option>
                            <option value="Mail">Mail</option>
                            <option value="Phone">Phone</option>
                        </select>
                        </p>
                        <p class="login button"> 
                            <input type="button" onclick=" window.history.back();" value="Cancel" />
                            <input type="submit" value="Continue" /> 
                        </p>
                        <p class="loginErr" style="float: left; color: red;">
                            <?php
                            if ($this->session->flashdata('registrationError')) {
                                echo $this->session->flashdata('registrationError');
                            }
                            ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
