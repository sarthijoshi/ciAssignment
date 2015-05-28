$(document).ready(function () {
    /**
     * Global variables which are reused in functions
     */
    var book;
    var chapter;
    var chapterId;
    var bookPart;
    var bookPartId;
    var chapterPart;
    var bookId;
    var newBook;
    var newChapter;
    var newBookId;
    var chapterPartId;
    var newChapterPartId;
    var existingSelectedSections;
    var existingContent;
    var newContent;
    var newSectionNumber;
    var newSectionTitle;
    var newSectionValues = "";
    var SectionId;
    var existingSectionIds = [];
    var addedSectionIds = [];
    var newBookPartId;
    var newChapterId;
    var existingSectionContents;
    var newSectionContents;
    var selectedSectionId;
    var existingSectionCdpCodeId;
    var newSectionCdpCodeId;

    /**
     * Dialog box for add existing proposal 
     */
    $('#addExistingProposal').on('click', function () {
        $('#addExistingProposalDialog').css('display', 'block');
        var addExistingDialog = $("#addExistingProposalDialog").dialog({
            closeOnEscape: true,
            height: 700,
            width: 1500,
            maxHeight: 800,
            maxWidth: 800,
            minWidth: 1000
        });
        addExistingDialog.dialog("open");
    });
    /**
     * Dialog box for add new proposal 
     */
    $('#addNewProposal').on('click', function () {
        $('#addNewProposalDialog').css('display', 'block');
        var addNewDialog = $("#addNewProposalDialog").dialog({
            closeOnEscape: true,
            height: 500,
            width: 1500,
            maxHeight: 800,
            maxWidth: 800,
            minWidth: 1000
        });
        addNewDialog.dialog("open");
    });
    /**
     * Dialog box for add reorder 
     */
    $('#reorder').on('click', function () {
        $('#reOrderPopup').css('display', 'block');
        var reorderDialog = $("#reOrderPopup").dialog({
            closeOnEscape: true,
            height: 500,
            width: 1500,
            maxHeight: 800,
            maxWidth: 800,
            minWidth: 1000
        });
        reorderDialog.dialog("open");
        //function to take already added sections ids
        $('.sections').each(function () {
            existingSectionIds.push(this.id);
        });
        var reOrderData = "";
        var orderIndex = 1;
        //code to get all ids and reorder functionality
        $.each(existingSectionIds, function (index, value) {
            if (value != "") {
                var existingSectionText = $("#" + value).text();
                reOrderData += '<li class="ui-state-default"><input type="text" class="reoderLiClass" id="reorderId" value="' + orderIndex + '" style="width:25px;float:left;"><span rev="' + value + '" style="float:left;margin-left: 8px;">"' + existingSectionText + '"</span></li>';
                orderIndex++;
            }
        });
        reOrderData += '<input id="reorderBtn" type="submit" value="Create New Order"/>';
        $("#sortable").html(reOrderData);
    });
    /**
     *Code to enable sortable for particular div  
     */
    $(function () {
        $("#sortable").sortable({
            stop: function (event, ui) {
                var i = 1;
                $('#sortable > li ').children().not('span').each(function () {
                    $(this).val(i);
                    i++;
                });
            }
        });
        $("#sortable").disableSelection();
    });
    /**
     * Reorder sections
     */
    $(document).on('click', '#reorderBtn', function () {
        var newSortOrder = 1;
        $("ul.sortLi").find("li span").each(function () {
            $.ajax({
                url: baseUrl + 'index.php/users/reorderSection',
                datatype: "applicaton/JSON",
                type: "POST",
                data: {
                    'cdpCodeId': $(this).attr('rev'),
                    'newSortOrder': newSortOrder
                },
                beforeSend: function () {
                    // setting a preloader image
                    $("#preloader").css('display', 'block');
                },
                success: function (data) {
                    location.reload();
                    $("#reOrderPopup").css('display', 'none');
                }
            });
            newSortOrder++;
        })
    });

    /**
     * To get bookpart if exist for existing book after selecting book
     */
    $("#existingProposalBooks").on('change', function () {
        book = $('#existingProposalBooks :selected').text();
        bookId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getBookParts',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'bookId': bookId,
                'book': book
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                if (data != '') {
                    $("#bookPartId").css('display', 'block');
                    $("#existingProposalChapters").html("<option>Please select Chapter </option>");
                    var bookParts = "<option>Please select Book Part</option>";
                    $.each(data, function (i) {
                        bookParts += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                    });
                    $("#existingProposalBookParts").html(bookParts);
                } else {
                    $("#bookPartId").css('display', 'none');
                    //ajax to get chapters by book id 
                    $.ajax({
                        url: baseUrl + 'index.php/users/getChaptersByBook',
                        datatype: "applicaton/JSON",
                        type: "POST",
                        data: {
                            'bookId': bookId,
                            'book': book
                        },
                        beforeSend: function () {
                            // setting a preloader image
                            $("#preloader").css('display', 'block');
                        },
                        success: function (data) {
                            $("#preloader").css('display', 'none');
                            var chaptersByBook = "<option>Please select Chapter </option>";
                            $.each(data, function (i) {
                                chaptersByBook += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                            });
                            $("#existingProposalChapters").html(chaptersByBook);
                        }
                    });
                }
            }
        });
    });
    /**
     * To get chapters by Book part
     */
    $("#existingProposalBookParts").on('change', function () {

        bookPart = $('#existingProposalBookParts :selected').text();
        bookPartId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getChaptersByBookPart',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'bookId': bookId,
                'bookPartId': bookPartId,
                'bookPart': bookPart
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var chaptersByBookPart = "<option>Please select Chapter</option>";
                $.each(data, function (i) {
                    chaptersByBookPart += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#existingProposalChapters").html(chaptersByBookPart);
            }
        });
    });
    /**
     * To get chapters parts
     */
    $("#existingProposalChapters").on('change', function () {
        chapter = $('#existingProposalChapters :selected').text();
        chapterId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getChapterParts',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'chapterId': chapterId,
                'chapter': chapter
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                if (data != '') {
                    $("#chapterPartId").css('display', 'block');
                } else {
                    $("#chapterPartId").css('display', 'none');
                    //To get section by using chapterId
                    $.ajax({
                        url: baseUrl + 'index.php/users/getSectionsByChapter',
                        datatype: "applicaton/JSON",
                        type: "POST",
                        data: {
                            'chapterId': chapterId,
                            'chapter': chapter
                        },
                        success: function (data) {
                            var sections = "<option>Please select Chapter Part</option>";
                            $.each(data, function (i) {
                                sections += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                            });
                            $("#existingProposalSections").html(sections);
                        }
                    });
                }
                var chapterParts = "<option>Please select Chapter Part</option>";
                $.each(data, function (i) {
                    chapterParts += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#existingProposalChapterParts").html(chapterParts);
            }
        });
    });
    /**
     *  To get sections  for existing proposal
     */
    $("#existingProposalChapterParts").on('change', function () {
        chapterPart = $('#existingProposalChapterParts :selected').text();
        chapterPartId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getSectionsByChapterPart',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'chapterPartId': chapterPartId,
                'chapterPart': chapterPart
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var sections = "<option>Please select Chapter Part</option>";
                $.each(data, function (i) {
                    sections += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#existingProposalSections").html(sections);
            }
        });
    });
    /**
     * To get sectionDetails for existing proposal
     */
    $("#existingProposalSections").on('change', function () {
        var section = $('#existingProposalSections :selected').text();
        var sectionId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getSectionsContent',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'chapterPartId': chapterPartId,
                'sectionId': sectionId,
                'section': section
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var sectionContentssss = "<input type='checkbox' id='existingSectionSelectAll'/> <b>Select All</b>";
                $.each(data, function (i) {
                    sectionContentssss += "<label style='font-weight:bold;'><b>SECTION </b>" + data[i]['number'] + " " + data[i]['title'] + "</label><br/>";
                    sectionContentssss += "<input type='checkbox' class='checkbox1' name='existingSectionContents' rev='" + data[i]['content'] + "' rel='" + data[i]['content_id'] + "' value='" + data[i]['number'] + " " + data[i]['title'] + "'/>" + data[i]['content'] + "";
                });
                sectionContentssss += "<input type='button' id='addExistingSectionBtn' style='margin-top:20px;float: right;' value='Add selected Sections to proposal'/>"
                $("#sectionContentInformation").html(sectionContentssss);
            }
        });
    });

    /**
     * select all functionality for add existing pop up 
     */
    $(document).on('click', '#existingSectionSelectAll', function () {
        if (this.checked) { // check select status
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        } else {
            $('.checkbox1').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });

    /**
     * code to get and display selected section 
     */
    $(document).on('click', '#addExistingSectionBtn', function () {
        $('#addExistingProposalDialog').dialog('close');
        $("#existingNewSectionNumber").val('');
        $("#existingNewSectionNumber").val('');
        var sectionValues = "";
        $('input:checkbox[name=existingSectionContents]:checked').each(function () {
            existingSectionContents = $(this).attr('rev');
            sectionValues = $(this).val();
            existingSectionCdpCodeId = $(this).attr('rel');
            $.ajax({
                url: baseUrl + 'index.php/users/addExistingSectionCode',
                datatype: "applicaton/json",
                type: "POST",
                data: {
                    'book': book,
                    'bookPartId': bookPartId,
                    'chapterId': chapterId,
                    'chapterPartId': chapterPartId,
                    'sectionValues': sectionValues,
                    'existingSectionContents': existingSectionContents,
                    'cdpCodeID': existingSectionCdpCodeId
                },
                beforeSend: function () {
                    // setting a preloader image
                    $("#preloader").css('display', 'block');
                },
                success: function (data) {
                    $("#preloader").css('display', 'none');
                    //location.reload();
                    getAllSection();
                }
            });
        });
    });
    /**
     * ajax call to get content to be filled in tiny mc editor for section
     */
    $(document).on('click', '.sections', function () {
        selectedSectionId = $(this).attr('id');
        $.ajax({
            url: baseUrl + 'index.php/users/getContent',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'selectedSectionId': selectedSectionId
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                var viewChangeBtn = "";
                $("#preloader").css('display', 'none');
                $("#selectedSectionBook").text(data['book']);
                $("#existingNewSectionTitle").val(data['title']);
                tinyMCE.activeEditor.setContent(data['content']);
                viewChangeBtn += "<a class='viewChange' href='" + baseUrl + "users/viewChangeProposal/" + selectedSectionId + "'>View Changes</a>";
                $("#viewChange").html(viewChangeBtn);
            }
        });
    });

    /**
     * To get chapters for new book after selecting book
     */
    $("#newProposalBooks").on('change', function () {
        newBook = $('#newProposalBooks :selected').text();
        newBookId = $(this).find(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getNewBookParts',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'newBookId': newBookId,
                'newBook': newBook
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                if (data != '') {
                    $("#newBookPartId").css('display', 'block');
                    $("#newProposalChapters").html("<option>Please select Chapter </option>");
                    var newBookParts = "<option>Please select Book Part</option>";
                    $.each(data, function (i) {
                        newBookParts += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                    });
                    $("#newProposalBookParts").html(newBookParts);
                } else {
                    $("#newBookPartId").css('display', 'none');
                    //ajax to get chapters by book id 
                    $.ajax({
                        url: baseUrl + 'index.php/users/getNewChaptersByBook',
                        datatype: "applicaton/JSON",
                        type: "POST",
                        data: {
                            'newBookId': newBookId,
                            'newBook': newBook
                        },
                        success: function (data) {
                            var newChaptersByBook = "<option>Please select Chapter </option>";
                            $.each(data, function (i) {
                                newChaptersByBook += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                            });
                            $("#newProposalChapters").html(newChaptersByBook);
                        }
                    });
                }
            }
        });

    });
    /**
     * To get chapters by Book part for new proposal
     */
    $("#newProposalBookParts").on('change', function () {
        var newBookPart = $('#newProposalBookParts :selected').text();
        newBookPartId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getNewChaptersByBookPart',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'newBookId': newBookId,
                'newBookPartId': newBookPartId,
                'newBookPart': newBookPart
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var newChaptersByBookPart = "<option>Please select Chapter</option>";
                $.each(data, function (i) {
                    newChaptersByBookPart += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#newProposalChapters").html(newChaptersByBookPart);
            }
        });
    });
    /**
     *To get chapters parts for new proposal
     */
    $("#newProposalChapters").on('change', function () {
        newChapter = $('#newProposalChapters :selected').text();
        newChapterId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getNewChapterParts',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'newChapterId': newChapterId,
                'newChapter': newChapter
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                if (data != '') {
                    $("#newChapterPartId").css('display', 'block');
                } else {
                    $("#newChapterPartId").css('display', 'none');
                    //To get section by using chapterId
                    $.ajax({
                        url: baseUrl + 'index.php/users/getNewSectionsByChapter',
                        datatype: "applicaton/JSON",
                        type: "POST",
                        data: {
                            'newChapterId': newChapterId,
                            'newChapter': newChapter
                        },
                        success: function (data) {
                            var newSections = "<option>Please select Chapter Part</option>";
                            $.each(data, function (i) {
                                newSections += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                            });
                            $("#newProposalSection").html(newSections);
                        }
                    });
                }
                var newChapterParts = "<option>Please select Chapter Part</option>";
                $.each(data, function (i) {
                    newChapterParts += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#newProposalChapterParts").html(newChapterParts);
            }
        });
    });
    /**
     * To get sections for new proposal
     */
    $("#newProposalChapterParts").on('change', function () {
        var newChapterPart = $('#newProposalChapterParts :selected').text();
        newChapterPartId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getNewSectionsByChapterPart',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'newChapterPartId': newChapterPartId,
                'newChapterPart': newChapterPart
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var newSectionss = "<option>Please select Chapter Part</option>";
                $.each(data, function (i) {
                    newSectionss += "<option id=" + data[i]['id'] + ">" + data[i]['title'] + "</option>";
                });
                $("#newProposalSection").html(newSectionss);
            }
        });
    });

    /**
     * To get sectionDetails for new proposal
     */
    $("#newProposalSection").on('change', function () {
        var newSection = $('#newProposalSections :selected').text();
        var newSectionId = $(this).children(":selected").attr("id");
        $.ajax({
            url: baseUrl + 'index.php/users/getNewSectionsContent',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'newChapterPartId': newChapterPartId,
                'newSectionId': newSectionId,
                'newSection': newSection
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var newSectionContent = "<input type='checkbox' id='newSectionSelectAll'/> <b>Select All</b><br/>";
                $.each(data, function (i) {
                    newSectionContent += "<label style='font-weight:bold;'><b>SECTION </b>" + data[i]['number'] + " " + data[i]['title'] + "</label><br/>";
                    newSectionContent += "<input type='checkbox' class='checkbox2' name='newSectionContents' rev='" + data[i]['content'] + "' rel='" + data[i]['content_id'] + "' value='" + data[i]['number'] + " " + data[i]['title'] + "'/>" + data[i]['content'] + "";
                });
                newSectionContent += "<input id='addNewSectionBtn' class='sectionExisting' type='button' style='float: right;' value='Create New Content'/>"

                $("#newSectionContentInformation").html(newSectionContent);
            }
        });
    });
    /**
     * select all functionality for add new pop up 
     */
    $(document).on('click', '#newSectionSelectAll', function () {
        if (this.checked) { // check select status
            $('.checkbox2').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        } else {
            $('.checkbox2').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });
    /**
     * code to get and display selected section 
     */
    $(document).on('click', '#addNewSectionBtn', function () {

        $('#addNewProposalDialog').dialog('close');
        $("#existingNewSectionNumber").val('');
        $("#existingNewSectionTitle").val('');
        var newSectionInformation = "";
        $('input:checkbox[name=newSectionContents]:checked').each(function () {
            newSectionCdpCodeId = $(this).attr('rel');
            newSectionValues = $(this).val();
            newSectionContents = $(this).attr('rev');
            $.ajax({
                url: baseUrl + 'index.php/users/addNewSectionCode',
                datatype: "applicaton/json",
                type: "POST",
                data: {
                    'newBook': newBook,
                    'newBookPartId': newBookPartId,
                    'newChapterId': newChapterId,
                    'newChapterPartId': newChapterPartId,
                    'newSectionValues': newSectionValues,
                    'newSectionContents': newSectionContents,
                    'cdpCodeID': newSectionCdpCodeId
                },
                beforeSend: function () {
                    // setting a preloader image
                    $("#preloader").css('display', 'block');
                },
                success: function (data) {
                    $("#preloader").css('display', 'none');
                    getAllSection();
                    //location.reload();
                }
            });
        });
    });
    /**
     * upadate section content after clicking on "save" button
     */
    $(document).on('click', '#updateSectionBtn', function () {
        var updatedContent = tinyMCE.get('sectionContent').getContent();
        var updatedNumber = $("#existingNewSectionNumber").val();
        var updatedTitle = $("#existingNewSectionTitle").val();
        $.ajax({
            url: baseUrl + 'index.php/users/updateSectionCode',
            datatype: "applicaton/json",
            type: "POST",
            data: {
                'selectedSectionId': selectedSectionId,
                'updatedNumber': updatedNumber,
                'updatedTitle': updatedTitle,
                'updatedContent': updatedContent
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
                var previewContent = "";
                previewContent += updatedContent;
                $("#preview").html(previewContent);
            }
        });
    });
    var count = 0;
    $(document).on('click', '.editPrivilege', function () {
        count++;
        $(".privilege").prop("disabled", true);
        //code to toggle button name 
        $(this).text(function (i, text) {
            return text === "Edit" ? "Save" : "Edit";
        });
        //code to enable privileges
        if (count % 2 != 0) {
            $(".privilege").prop("disabled", false);
        } else {
            $(".privilege").prop("disabled", true);
        }
    });

});

function getAllSection() {
    /**
     * Ajax call to get section list of already added section
     */
    $.ajax({
        url: baseUrl + 'index.php/users/getAllSectionProposalByPid',
        datatype: "applicaton/JSON",
        type: "POST",
        beforeSend: function () {
            // setting a preloader iamge
            $("#preloader").css('display', 'block');
        },
        success: function (data) {
            $("#preloader").css('display', 'none');
            var sectionData = "<h3>" + data[0]['book'] + "</h3><br/>";
            $.each(data, function (index, value) {
                sectionData += "<a class='sections' href='#' id='" + value['id'] + "'>" + value['original_section'] + "</a>";
                sectionData += "<a href='#' id='" + value['id'] + "'> (remove)</a><br/><br/>";
            });
            $(".sectionExisting").html(sectionData);
        }
    });
}