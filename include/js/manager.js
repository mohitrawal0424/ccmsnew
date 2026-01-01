$(document).ready(function () {
  $(document).on("click", "#deleteBtn", function (e) {
    e.preventDefault();
    const thisElement = $(this);
    if (confirm("Delete Staff ?") == true) {
      var managerId = $(this).attr("value");

      $.ajax({
        url: "./queries.php",
        type: "GET",
        data: { managerId: managerId },

        success: function (res) {
          try {
            var data = JSON.parse(res);
            if (data.status === true) {
              thisElement.parent().parent().remove();
            } else {
              alert("ERROR : Manager Not Deleted");
            }
          } catch (error) {
            console.error("Error parsing JSON response:", error);
          }
        },
      });
    }
  });
});
