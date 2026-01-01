$(document).ready(function () {
  // js to delete staff on deletebtn

  $(document).on("click", "#deleteBtn", function (e) {
    e.preventDefault();
    if (confirm("Delete Staff ?") == true) {
      var staffId = $(this).attr("value");
      const thisElement = $(this);

      $.ajax({
        url: "./queries.php",
        type: "GET",
        data: { staffId: staffId },
        success: function (data) {
          if (data == 1) {
            thisElement.parent().parent().remove();
          }
        },
      });
    }
  });

  // Ajax/Js to enter user attendence into db

  $(document).on("click", "#presentBtn, #absentBtn", function (e) {
    e.preventDefault();
    $(this).html('<i class="fa-solid fa-spinner"></i>');
    const date = $("#attendanceDate").val();
    const thisElement = $(this);
    const attendType = parseInt(thisElement.attr("data-custom-value"));

    if (attendType === 0) {
      var attendTypeInWords = "Absent";
      var fontColor = "text-red-500";
    } else if (attendType === 1) {
      var attendTypeInWords = "Present";
      var fontColor = "text-green-500";
    }

    var staffIdForAttend = parseInt(
      thisElement
        .parent()
        .parent()
        .parent()
        .children(".IdClassDom")
        .text()
        .trim()
    );
    var dateOfJoining = thisElement
      .parent()
      .parent()
      .parent()
      .children(".DOJClassDom")
      .text()
      .trim();

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: {
        staffIdForAttend: staffIdForAttend,
        date: date,
        attendType: attendType,
        dateOfJoining: dateOfJoining,
      },
      success: function (response) {
        try {
          var data = JSON.parse(response);

          if (data.status === true) {
            thisElement
              .parent()
              .parent()
              .prev()
              .html(
                "<p class='font-bold " +
                  fontColor +
                  "'>" +
                  attendTypeInWords +
                  "</p>"
              );
            thisElement
              .parent()
              .html(
                "<p class='font-bold text-lg text-green-700'>" +
                  data.msg +
                  "</p>"
              );
          } else {
            thisElement
              .parent()
              .html(
                "<p class='font-bold text-lg text-red-700'>" +
                  data.error +
                  "</p>"
              );
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      },
    });
  });


  // js to close staff acount

  $(document).on("click", "#closeBtn", function (e) {
    e.preventDefault();
    if (confirm("Close Staff Account?") == true) {
      var staffIdClose = parseInt($(this).attr("value").trim());
      const thisElement = $(this);
      var doc = $("#attendanceDate").val();

      $.ajax({
        url: "./queries.php",
        type: "GET",
        data: { staffIdClose: staffIdClose , doc : doc},
        success: function (data) {
          if (data == 1) {
            thisElement.parent().parent().remove();
          }
        },
      });
    }
  });
});
