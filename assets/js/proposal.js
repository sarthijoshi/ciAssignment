$(document).ready(function () {
    $(".deleteProposal").on('click', function () {
        var proposalId = $(this).attr('id');
        $.ajax({
            url: baseUrl + 'index.php/users/deleteRegularUserSection',
            datatype: "applicaton/JSON",
            type: "POST",
            data: {
                'proposalId': proposalId
            },
            beforeSend: function () {
                // setting a preloader image
                $("#preloader").css('display', 'block');
            },
            success: function (data) {
                $("#preloader").css('display', 'none');
            }
        });
    });
});