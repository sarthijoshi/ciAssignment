<!--<div class="container">--> 
<?php echo $this->tinyMce; ?>
<section>
    <?php
    if ($userEmailId === "admin@admin.com" || $userEmailId === "superadmin@admin.com") {
        ?>
        <div style=" background-color: #dddddd;float: left;height: 180px;margin-left: 44px;width: 1490px;">
            <table class="table table-striped table-bordered" style="width:70%;float: left;margin-left: 20px;margin-top: 20px;">
                <tr>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Group</th>
                    <th style="text-align:center;">Assigned Staff</th>
                    <th style="text-align:center;">Tracking Number</th>
                    <th style="text-align:center;">Hearing Committee</th>
                    <th style="text-align:center;">Reference Standards Review</th>
                </tr>
                <tr>
                    <td>
                        <select class="privilege" id="proposalStatus" disabled="disabled">
                            <?php
                            foreach ($proposalData['status'] as $proposalInfo) {
                                ?>
                                <option id="<?php echo $proposalInfo['id']; ?>"><?php echo $proposalInfo['name'] ?></option>
                            <?php }
                            ?>      
                        </select>
                    </td>
                    <td>
                        <select class="privilege" id="proposalGroup" disabled="disabled">
                            <?php
                            foreach ($proposalData['groups'] as $groupInfo) {
                                ?>
                                <option id="<?php echo $groupInfo['id']; ?>"><?php echo $groupInfo['long_name'] ?></option>
                            <?php }
                            ?>    
                        </select>
                    </td>
                    <td>
                        <select class="privilege" id="proposalAssignedStaff" disabled="disabled" >
                            <?php
                            foreach ($proposalData['users'] as $userInfo) {
                                ?>
                                <option id="<?php echo $userInfo['id']; ?>"><?php echo $userInfo['first_name'] . " " . $userInfo['last_name'] ?></option>
                            <?php }
                            ?>      
                        </select>
                    </td>
                    <td>
                        <input type="text"class="privilege" id="trackingNumber" disabled="disabled"/>
                    </td>
                    <td>
                        <select class="privilege" id="proposalCommittee" disabled="disabled">
                            <option value="N/A">N/A</option>
                            <option value="IGCC">IGCC</option>
                            <option value="IFCC">IFCC</option>
                        </select>
                    </td>
                    <td>
                        <select class="privilege" id="proposalStatus" disabled="disabled">
                            <option value="N/A">N/A</option>
                            <option value="Request to Proponent">Request to Proponent</option>
                            <option value="Copy Received From Proponent">Copy Received From Proponent</option>
                            <option value="Staff Review Complete">Staff Review Complete</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button class='editPrivilege'>Edit</button>
        </div>
    <?php } ?> 
    <div style="background-color: #dddddd;border: 1px solid grey;float: left;margin-left: 45px;width: 93%;" >
        <div style="float:left;margin-left: 500px;" class="proposalName">
            <input id="proposalNameInput" readonly="readonly" type="text" value="Name your proposal"/>
            <button class='nameProposal'>edit</button>
        </div>
        <div style="float:right;font-family: inherit;font-weight: bold;margin-right: 115px;" class="proposalOwner">
            <label>Proposal Owner</label>
            <label for="ownerName">Regular user</label>
            <label for="ownerEmail">user@user.com</label>
        </div>
    </div>
    <div style="  background-color: #dddddd;border: 1px solid grey;float: left;height: 500px;min-height: 674px;margin-left: 45px;width: 93%;">
        <div style="float:left;width: 25%;height: 600px;border:1px solid grey;">
            <div class="sectionControls">
                <label style="font-weight:bold;">Section Controls</label>
                <a  id="addExistingProposal">Add Existing</a></br>
                <a  id="addNewProposal">Add New</a>
            </div>
            <div id="pce_listing_reorder_button_box" style="height:50px;background-color: activecaption;">
                <img id="reorder" src="<?php echo base_url(); ?>assets/images/reorder-icon.png" title="Click here to reorder" style="cursor:pointer;margin-left: 150px;height: 50px;">
            </div>
            <div for="sections" class="sectionExisting" style="float:left;margin-left:25px;margin-top: 10px; ">
            </div>
        </div>
        <div style="float:left;width: 54%;height: 600px;border:1px solid grey;">
            <div class="bookDetail" style=" border: 1px solid grey;">
                <label style="font-size: 21px;font-weight: bold;">Editor</label><br/>
                <b><label for="bookName" id="selectedSectionBook"></label></b>
                <select id="instructionLine">
                    <option>Select Instruction Line</option>
                    <option>Mark for Deletion</option>
                    <option>Reference Review</option>                    
                </select>
                <!--<input type="button" value="Discard" style="background-color: red;"/>-->
                <input type="button" class="updateContentBtn" id="updateSectionBtn" value="Save" style="background-color: green;"/><br/>
                <input type="text" for="Section" placeholder="Number" id="existingNewSectionNumber"/>
                <input type="text" for="SectionTitle" placeholder="Title" id="existingNewSectionTitle"/>
                <input type="checkbox" class="markForDeletion" value="1"/> <label for="MarkForDeletion" style=" float: right;margin-right: 228px;margin-top: 12px;">Mark for deletion</label>
            </div>
            <div id="viewChange" style="float:right;">

            </div>
            <div style="width:800px;height: 800px;float: left;">
                <textarea id="sectionContent" rows="12" cols="20">
                </textarea>
                <b>Note : Please click on "Save" button to save changes.</b>
            </div>
        </div>
        <div id="preview" style="float:left;width: 25%;height: 500px;border:1px solid grey;">

        </div>
        <!--dialog box  for addExistingProposal --> 
        <div id="addExistingProposalDialog" style="display: none;float: left;width: 700px;" title="Add sections to my proposal for editing">
            <div class="addExistingProposalHeader" style="background-color: black;float: left;height: 20px;margin-left: -21px;margin-top: -8px;width: 1500px">
            </div>
            <div>
                <div>
                    <label style="font-weight: bold;">Book</label>
                    <select name="existingProposalBooks"  id="existingProposalBooks" style=" float: right;margin-right: 400px;width: 330px;margin-top: -25px;">
                        <option>Please select Book</option>
                        <?php
                        foreach ($bookData as $books) {
                            ?>
                            <option id="<?php echo $books['id']; ?>"><?php echo $books['year'] . " " . $books['title']; ?></option>
                        <?php }
                        ?>      
                    </select>
                </div>
                <div id="bookPartId"  style="display:none;">
                    <label style="font-weight: bold;">Book Part</label>
                    <select name="existingProposalBookParts"  id="existingProposalBookParts" style=" float: right;margin-right: 400px;width: 330px;margin-top: -25px;">
                        <option>Please select Book Part</option>
                    </select>
                </div>
                <div>
                    <label style="font-weight: bold;">Chapter</label>
                    <select name="existingProposalChapters"  id="existingProposalChapters" style=" float: right;margin-right: 400px;width: 330px;margin-top: -25px;">
                        <option>Please select Chapter</option>
                    </select>
                </div>
                <div id="chapterPartId" style="display:none;">
                    <label style="font-weight: bold;">Chapter Part</label>
                    <select name="existingProposalChapterParts"  id="existingProposalChapterParts" style="float: right;margin-right: 400px;width: 330px;margin-top: -25px;">
                        <option>Please select Chapter Part</option>
                    </select>
                </div>
                <div>
                    <label style="font-weight: bold;">Section</label>
                    <select name="existingProposalSections"  id="existingProposalSections"  style=" float: right;margin-right: 400px;width: 330px;margin-top: -25px;">
                        <option>Please select Section</option>
                    </select>
                </div>
            </div>
            <div id="sectionContentInformation" style="border:1px solid black;width: 1400px;margin-top: 20px;">
            </div>
            <div for="howtoaddInExistingProposal">
                <label style="background-color: #dfdfdf;margin-left: 5px;margin-top: 70px;">
                    To create a new Chapter, please add a new section at the end of the previous chapter. For example, to create a new Chapter 10, create a new section after the last section in Chapter 9.

                    To edit a chapter title or number, please create a new section at the beginning of the chapter. For instance, to edit the title of Chapter 9, create a new section before the first section in Chapter 9, and edit the title and section number to reflect the new Chapter title and number.

                    2012 International Green Construction Code. Copyright © 2012, International Code Council, Inc.

                    2012 International Plumbing Code. Copyright © 2011, International Code Council, Inc. 
                </label>
            </div>
        </div>
        <!--Dialog box  for addNewProposal --> 
        <div id="addNewProposalDialog" style="display: none;float: left;width: 700px;" title="Create a new section">
            <div class="addNewProposalHeader" style="background-color: black;float: left;height: 20px;margin-left: -21px;margin-top: -8px;width: 1500px;">
            </div>
            <div>
                <label style="flaot:left;margin-top: 28px;font-weight: bold;">Create New Content</label>
                <select style="float: left;margin-left: 135px;margin-top: -22px;width: 151px;">
                    <option>Before</option>
                    <option>After</option>
                </select>
                <label style="flaot:left;margin-top:-10px;font-weight: bold;">this Section:</label>
            </div>
            <div>
                <div style="margin-top: 30px;">
                    <label style="font-weight: bold;margin-left: 750px;">Book</label>
                    <select name="newProposalBooks"  id="newProposalBooks"  style="float:right;margin-right: 275px;width: 330px;margin-top: -25px;">
                        <option>Please select Book:</option>
                        <?php
                        foreach ($bookData as $books) {
                            ?>
                            <option id="<?php echo $books['id']; ?>"><?php echo $books['year'] . " " . $books['title']; ?></option>
                        <?php }
                        ?>                   
                    </select>
                </div>
                <div id="newBookPartId"  style="display:none;">
                    <label  style="font-weight: bold;margin-left: 750px;margin-top: 30px;">Book part</label>
                    <select name="newProposalBookParts"  id="newProposalBookParts" style="float:right;margin-right: 275px;width: 330px;margin-top: -25px;">
                        <option>Please select book part:</option>
                    </select>
                </div>
                <div style="margin-top: 30px;">
                    <label  style="font-weight: bold;margin-left: 750px">Chapter</label>
                    <select name="newProposalChapters"  id="newProposalChapters" style="float:right;margin-right: 275px;width: 330px;margin-top: -25px;">
                        <option>Please select Chapter:</option>
                    </select>
                </div>
                <div id="newChapterPartId" style="display:none;margin-top: 30px;">
                    <label style="font-weight: bold;margin-left: 750px">Chapter Part</label>
                    <select name="newProposalChapterParts"  id="newProposalChapterParts" style="float:right;margin-right: 275px;width: 330px;margin-top: -25px;">
                        <option>Please select Chapter Part</option>
                    </select>
                </div>
                <div style="margin-top: 30px;">
                    <label style="font-weight: bold;margin-left: 750px;">Sections</label>
                    <select  name="newProposalSection"  id="newProposalSection" style="float:right;margin-right: 275px;width: 330px;margin-top: -25px;">
                        <option>Please select Section:</option>
                    </select>
                </div>
                <div id="newSectionContentInformation" style="border:1px solid black;width: 1400px;margin-top: 20px;">
                </div>
                <div for="howtoaddInNewProposal">
                    <label style="background-color: #dfdfdf;margin-left: 5px;margin-top: 70px;">
                        Select "Before" or "After" from the dropdown to indicate where in the book your new content piece should be included.

                        The type of content being inserted to the proposal is displayed in [brackets] before the content section (i.e. [CHAPTER] indicates adding a new Chapter) 
                    </label>
                </div>
            </div>
        </div>
        <div id="reOrderPopup" style="display:none;" title="Re-order Proposal">
            <ul id="sortable" class="sortLi">
            </ul>
        </div>

        <div id="preloader" style="display:none;height: 500px;left: 50%;margin-left: -200px;position: fixed;width: 200px;">
            <img src="<?php echo base_url(); ?>assets/images/preloader.gif"> 
        </div>


</section>
<!--</div>-->
<!--Script for open proposal validation-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/openProposal.js" type="text/javascript"></script>
