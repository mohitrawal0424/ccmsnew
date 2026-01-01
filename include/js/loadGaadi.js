$(document).ready(function () {

  let table = new DataTable('#activeGaadiTable');

//by default bottleadd and list section hide
  $(".bottleSection").hide();

  $("#hideBtn").on("click", function (e) {
    e.preventDefault();
    $(".bottleSection").toggle();
    
  });
  
  $("select").selectize({
    sortField: "text",
  });

  $("#createGaadiBtn").click(function (e) {
    e.preventDefault();
    $("#addGaadiReceiverForm").toggle();
    $("#activeGaadiTable").hide();
  });

  //initializing empty array for Peti and product
  var addedPeti = [];
  var addedProducts = [];

  // delete the Gaadidetails entries from database
  $(".dltbtn").on("click", function (e) {
    e.preventDefault();
    var itemId = $(this).val();
    var listItem = $(this).closest("li");
    $.ajax({
      url: "./delete.php",
      type: "GET",
      data: { itemId },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == true) {
          listItem.remove();
        } else {
          alert("something Wrong");
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  });
});
