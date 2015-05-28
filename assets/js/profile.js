$(document).ready(function () {
   $("#editProfile").on('click', function(){
      $(".profileClass").attr("readonly", false);
      $("#updateProfile").show();
   }) 
});