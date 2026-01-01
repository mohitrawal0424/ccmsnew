$(document).ready(function () {
    $(document).on("click", "#deleteBtnAdvanceID", function (e) {
      e.preventDefault();
      const thisElement = $(this);
      if (confirm("Delete Staff ?") == true) {
        var advanceDBid = $(this).attr("value");
  
        $.ajax({
          url: "./queries.php",
          type: "GET",
          data: { advanceDBid: advanceDBid },
  
          success: function (res) {
            try {
              var data = JSON.parse(res);
              if (data.status === true) {
                thisElement.parent().parent().remove();
              } else {
                alert("ERROR : Not Deleted");
              }
            } catch (error) {
              console.error("Error parsing JSON response:", error);
            }
          },
        });
      }
    });


  $("#inputStaffId").focus();
  });
  