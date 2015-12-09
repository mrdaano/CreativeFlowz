$(document).ready(function() {
  var err = false;
  $("#submit").on('click', function() {
    $('.login').each(function() {
      if ($(this).val() == "") {
        $(this).addClass('err');
        err = true;
      }
    });

    if(err == true) {
      return false;
    }
    return true;
  });
});
