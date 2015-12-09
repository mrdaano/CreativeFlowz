$(document).ready(function() {
});

function checkContactForm() {
  var err = false;
    $(".form").removeClass('err');
    $('.form').each(function() {
      if ($(this).val() == "") {
        $(this).addClass('err');
        err = true;
      }
    });

    if(err == true) {
      return false;
    }
    return true;
}
