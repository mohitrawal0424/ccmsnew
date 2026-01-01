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

    let tableId = $(this).parent().children("#tableId").val(); //id on counterdetails table
    tableId = parseInt(tableId);
    let quantity = $(this).parent().children("#availableStoke").val(); //current quantity in counterdetails table
    quantity = parseInt(quantity);
    let itemType = $(this).parent().children("#itemtype").val(); //item type
    itemType = parseInt(itemType);
    let itemId = $(this).parent().children("#itemid").val(); //item id
    itemId = parseInt(itemId);
    let returnQuantity = $(this).parent().children("#ReturnQuantity").val(); //return quantity
    returnQuantity = parseInt(returnQuantity);
    let counterid = $('input[name="counterId"]').val(); //counter Id
    counterid = parseInt(counterid);
    
    let table = "counterdetails";
    let requestName = "counterQuatityReturn";

    if(returnQuantity == 0 || returnQuantity == ""){
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
    // return
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
