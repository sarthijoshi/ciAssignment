<div class="container"> 
    <div id="container_demo">
        <div class="container"> 
            <div id="container_demo">
                <div id="wrapper">
                    <div style="float: left;margin-left: -185px;width: 1330px;background-color: #dddddd;min-height:750px;">
                        <div class="container--compare-blocks" style="width: 1300px;margin-top: 70px;">
                            <?php
                            foreach ($sectionInformation as $books) {
                                ?>
                                <div class="compare-block compare-block-one" style="min-height: 250px;width: 625px;">
                                    <header class="small-title"><b>Original section content</b></header>
                                    <div class="block" id="block1">
                                        <?php echo $books['original_content']; ?>
                                    </div>
                                </div>
                                <div class="compare-block compare-block-two" style="float: left;margin-left: 188px;margin-top: 30px;min-height: 167px;width: 920px;">
                                    <header class="small-title"><b>Modified Section Content</b>
                                    </header>
                                    <div class="block" id="block2">
                                        <?php echo $books['modified_content']; ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="container--diff" style="float: left;margin-left: 640px;margin-top: -489px;min-height: 253px;width: 650px;">
                                <header class="title">
                                    Modified Legislative Content
                                </header>
                                <!-- results of our comparison -->
                                <section id="diff" class="diff"></section>	 	
                            </div>
                            <input type="button" class="backBtn" onclick=" window.history.back();" style="width:100px;float: right;" value="Back" />
                        </div>
                    </div>
                    <!--css and js files for html diff function-->
                    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/diff.css" />
                    <script src="<?php echo base_url() ?>assets/js/diff.js" type="text/javascript" charset="utf-8"></script>
                </div>
            </div>
        </div>
    </div>
</div>
