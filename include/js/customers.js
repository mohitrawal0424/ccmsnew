$(document).ready(function () {
  // js to delete staff on deletebtn

  $(document).on("click", "#deleteBtn", function (e) {
    e.preventDefault();
    if (confirm("Delete Staff ?") == true) {
      var deleteCustId = $(this).attr("value");
      const thisElement = $(this);

      $.ajax({
        url: "./queries.php",
        type: "GET",
        data: { deleteCustId },
        success: function (data) {

          if (data == 1) {
            thisElement.parent().parent().remove();
          }
        },
      });
    }
  });

});
