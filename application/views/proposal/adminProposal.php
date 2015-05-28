<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div id="proposal" class="animate form">
                    <form  method="post" action="changePassword" onsubmit="return changePwdValidations()"> 
                        <p>
                            <label style="font-size: 30px;font-weight: bold;color: #0088cc;">Admin Proposals</label>
                        </p><br/><br/>
                        <p> 
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Proponent</th>
                                <th>Submitted At</th>
                                <th>Status</th>
                                <th>Assigned Staff</th>
                                <th>Sections</th>
                                <th>Internal #</th>
                            </tr>
                            <tr>
                                <?php
                                if (!empty($list)) {
                                    foreach ($list as $proposalList) {
                                        ?>
                                        <td>
                                            <a style="float: right;margin-right: 10px;margin-top: 30px;"href="openProposal/<?php echo $proposalList['proposalId']; ?>">No Title Supplied</a>
                                        </td>
                                        <td>
                                            <label style="font-weight: bold;"><?php echo $proposalList['createdAt']; ?></label>
                                        </td>
                                        <td>
                                            <label style="font-weight: bold;"><?php echo $proposalList['first_name']; ?></label>
                                            <label style="font-weight: bold;"><?php echo $proposalList['last_name']; ?></label>
                                        </td>
                                        <td>
                                            <label for="submittedAt"><?php echo $proposalList['submittedAt']; ?></label> 
                                        </td>
                                        <td>
                                            <label for="status"><?php echo $proposalList['proposalStatus']; ?></label> 
                                        </td>
                                        <td>
                                            <label for="assignedStaff"></label> 
                                        </td>
                                        <td>
                                            <label for="sectionsIncluded"><b>Sections Included</label></b><br>
                                            <label for="sectionsIncluded"><b>
                                                    <?php
                                                    $section = str_replace(",", "<br>", $proposalList['sections']);
                                                    echo $section;
                                                    ?>
                                            </label>
                                        </td>    
                                        <td>
                                            <div id="openProposalBtn">
                                                <a href="#" id="<?php echo $proposalList['proposalId']; ?>"  style="float:right;margin-right: 50px;">Set internal Number</a>                                         
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <td>
                                    <label style="color:green;" for="proposalStatus">There is no section Proposal created for this user yet.</label> 
                                </td>
                            <?php } ?>
                        </table>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div id="preloader" style="display:none;height: 500px;left: 50%;margin-left: -200px;position: fixed;width: 200px;">
            <img src="<?php echo base_url(); ?>assets/images/preloader.gif"> 
        </div>
    </section>
</div>
<!--Script for proposal listing validation-->
<script src="<?php echo base_url(); ?>assets/js/proposal.js" type="text/javascript"></script>
</body>