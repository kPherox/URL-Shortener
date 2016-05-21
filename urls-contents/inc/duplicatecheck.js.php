<?php
  header('Content-Type: text/javascript; charset=utf-8');
?>
$(function() {
  check_fill();

  $("input").keydown(function() {
    if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
      return false;
    } else {
      return true;
    }

    check_duplicate();
  });

  $("input").keypress(function() {
    check_duplicate();
  });

  $("input").keyup(function() {
    check_duplicate();
  });

  function check_fill() {
    if ($("#emailform").val().length == 0) {
      $(":submit").prop('disabled', true);
    } else {
      $(":submit").prop('disabled', false);
    }
  }

  function check_duplicate() {
    if ($("#emailform").val().length == 0) {
      $(":submit").prop('disabled', true);
    } else {
      var data = {
        "check" : "mail",
        "str" : $("#emailform").val(),
      };

      $.ajax({
        url: "<?php echo scheme . '://' . urlsdomain . '/duplicatechecker'; ?>",
        type : "POST",
        data : data,
      }).done(function(j_data, dataType){
        if(j_data == "bool(false)\n"){
          $("#emaildupcheck").html("Success!");
          $(":submit").prop('disabled', false);
        } else {
          $("#emaildupcheck").html("Duplicate!");
          $(":submit").prop('disabled', true);
        }
      }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        this;
        $(this).after("<strong>Error!!</strong>");
      });
    }
  }
});
