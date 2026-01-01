$(document).ready(function () {

  // this function is used to enter sold items in a different 
    $('.returnQuantitySubmit').on('click', function (e) {
      e.preventDefault();

      // let noss = $(this).parent().children("#noss").val();
      // noss = parseInt(noss);

      let id = $(this).parent().children("#petiID").val();
      id = parseInt(id);

      let itemType = $(this).parent().children("#itemtype").val();
      itemType = parseInt(itemType);

      let returnQuantity = $(this).parent().children("#ReturnQuantity").val();
      if(returnQuantity == 0){
        alert("Enter some quantity");
        return
      }
      returnQuantity = parseInt(returnQuantity);

      // let NosToEnter = noss - returnQuantity;
      let gaadiID = $('input[name="gaadiId"]').val();
      gaadiID = parseInt(gaadiID);
      
      // if(returnQuantity > noss){
      //     alert("Please Enter Less Quantity")
      //     return
      //   }
        
      //   if(returnQuantity == ""){
      //       alert("Please Enter Return Quantity");
      //       return
      //   }
        console.log(returnQuantity , id, itemType, gaadiID);
      // Make an AJAX request to delete the entry
      $.ajax({
          url: './queries.php', // Replace with the actual server-side script
          type: 'GET',
          data: {id,returnQuantity, itemType, gaadiID},
          success: function (response) {
            console.log(response);
              var data = JSON.parse(response)
              // Handle the response, e.g., remove the item from the list
              if(data.status == true){
                // alert("refresh");
                window.location.href = "returnGaadi.php?receiverid=" + gaadiID;
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
  