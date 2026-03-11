$(document).ready(function () {

  //default productadd and list section hide
  $(".bottleSection").hide();

  $("select").selectize({
    sortField: "text",
  });

  $("#createCounterBtn").click(function (e) {
    e.preventDefault();
    $("#addCounterForm").toggle();
  });

  // delete the Gaadidetails entries from database

  $(".dltbtn").on("click", function (e) {
    e.preventDefault();
    var itemIdCounter = $(this).val();
    var listItem = $(this).closest("tr");
    $.ajax({
      url: "./delete.php",
      type: "GET",
      data: { itemIdCounter },
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

  $("#hideBtn").on("click", function (e) {
    e.preventDefault();
    $(".bottleSection").toggle();
    
  });



  
  // to enter return quantity on counter
  $('.returnQuantitySubmit').on('click', function (e) {
    e.preventDefault();

    let $parent = $(this).parent();
    let tableId = parseInt($parent.find(".tableId").val());
    let quantity = parseInt($parent.find(".availableStoke").val());
    let itemType = parseInt($parent.find(".itemtype").val());
    let itemId = parseInt($parent.find(".itemid").val());
    let returnQuantity = parseInt($parent.find(".ReturnQuantity").val());
    let counterid = parseInt($('#counterid').val());
    
    let table = "counterdetails";
    let requestName = "counterQuatityReturn";

    if(isNaN(returnQuantity) || returnQuantity == 0 || returnQuantity == ""){
      alert("Enter Return quantity");
      return
    }
    if(returnQuantity > quantity){
        alert("Please Enter Less Quantity")
        return
      }

    //quantity to update in table
    let updatedQuantity = quantity - returnQuantity;
    console.log(tableId,quantity,itemType,returnQuantity,counterid,updatedQuantity)
    
    // Make an AJAX request to delete the entry
    $.ajax({
        url: './queries.php',
        type: 'GET',
        data: {requestName,tableId,updatedQuantity,table,returnQuantity,itemType,itemId},
        success: function (response) {
            var data = JSON.parse(response)
            if(data.status == true){
              window.location.href = "counter.php?counterid=" + counterid;
            } else {
              alert("something Wrong Please try again");
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});
});
