$(document).ready(function () {
    $("#addSchemeBtn").click(function (e) {
      e.preventDefault();
      $("#schemeForm").toggle();
    });


      // delete the Scheme entries from database

  $('.schemedltbtn').on('click', function (e) {
    e.preventDefault();
    var SchemeId = $(this).val(); // Get the value (ID) of the clicked button
    var listItem = $(this).closest('tr'); // Get the closest parent <li> element

    // Make an AJAX request to delete the entry
    $.ajax({
        url: './delete.php', // Replace with the actual server-side script
        type: 'GET',
        data: {SchemeId},
        success: function (response) {
            var data = JSON.parse(response)
            // Handle the response, e.g., remove the item from the list
            if(data.status == true){
              listItem.remove();
              // console.log(data.status)
            } else {
              // console.log(data);
              alert("something Wrong");
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});
})