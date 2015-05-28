<div style="float: left;min-height: 760px;">
    <div style="width: 1300px;margin-left: 160px;height: 760px;float: left;background-color: #dddddd;">
        <label><img style="margin-left: 166px;margin-top: 75px;" src="<?php echo base_url(); ?>assets/images/errorImage.jpeg"/>
            <label style="color: red;float: right;font-size: 25px;font-weight: bold;margin-right: 430px;margin-top: 60px;">
                <?php
                if ($this->session->flashdata('openProposalError')) {
                    echo $this->session->flashdata('openProposalError');
                }
                ?>
            </label>
            <label style="color: red;float: right;font-size: 25px;font-weight: bold;margin-right: 430px;margin-top: 60px;">
                <?php
                if ($this->session->flashdata('deleteProposalError')) {
                    echo $this->session->flashdata('deleteProposalError');
                }
                ?>
            </label>
        </label>
    </div>
</div>