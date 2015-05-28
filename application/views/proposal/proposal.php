<div class="container"> 
    <section>
        <div id="container_demo">
            <div id="wrapper">
                <div id="proposal" class="animate form">
                    <form  method="post" action="changePassword" onsubmit="return changePwdValidations()"> 
                        <p> 
                        <div>
                            <a class="openProposalBtn" href="createProposal">Create New Proposal</a> 
                        </div>
                        </p><br/>
                        <p> 
                        <br/><br/><h5><label for="myProposal" style="float: left;font-weight: bold;font-size: 30px;color: #0088cc;">My Proposal</label></h5>
                        </p><br/><br/>
                        <p> 
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th style="text-align:center;">Title</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Sections</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                            <tr>
                                <?php
                                if (!empty($list)) {
                                    foreach ($list as $proposalList) {
                                        ?>
                                        <td>
                                            <label style="font-weight: bold;">No Title Supplied<br/><?php echo $proposalList['createdAt']; ?></label>
                                        </td>
                                        <td>
                                            <label style="color:red;font-weight: bold;"><?php echo $proposalList['proposalStatus']; ?></label> 
                                            <label>Last Modified</label> 
                                            <label><?php echo $proposalList['editedAt']; ?></label> 
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
                                                <a class="openProposalBtn" style="float: right;margin-right: 10px;margin-top: 30px;" href="openProposal/<?php echo $proposalList['proposalId']; ?>">Open Proposal</a>
                                            </div>
                                            <br>
                                            <?php if ($proposalList['proposalStatus'] === "Unsubmitted") { ?>
                                                <a href="deleteProposal/<?php echo $proposalList['proposalId']; ?>" class = "deleteProposal" id = "<?php echo $proposalList['proposalId']; ?>" style = "float:right;margin-right: 50px;">Delete Proposal</a>
                                            <?php } ?>
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