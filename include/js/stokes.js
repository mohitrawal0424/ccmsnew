$(document).ready(function () {
  let tablePetiStoke = new DataTable("#petistoketable");
  let tableBottleStoke = new DataTable("#bottlestoketable");

  //add stokes from table
  $(document).on("click", ".addstokeClass,.removestokeClass", function (e) {

    e.preventDefault();

   let unitsBottle = $(this).siblings('.quantityinput').val(); 
   let productIdB = $(this).attr("value");
   let stokeType = $(this).attr("data-stokeType");
    // console.log(productIdB,unitsBottle,stokeType);
 
    if(!unitsBottle){
        alert("Please Enter Quantity");
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { productIdB, unitsBottle ,stokeType},
      success: function (data) {
        var response = JSON.parse(data);
        // console.log(response);
        $("#successModal").removeClass("hidden");

        if (response.status === true) {
          $("#msg").addClass("text-green-400");
          $("#imgDiv").html(
            '<img src="../icons/correct (1) 32.png" alt="icons">'
          );
        } else if (response.status === false) {
          $("#msg").addClass("text-red-400");
          $("#imgDiv").html(
            '<img src="../icons/incorrect 32 px.png" alt="icons">'
          );
        }

        $("#msg").text(response.msg);
        setTimeout(function () {
          $("#successModal").addClass("hidden");
        }, 3000);
      },
    });
  });

    //add stokes from table
    $(document).on("click", ".addstokeClass,.removestokeClass", function (e) {

        e.preventDefault();
    
       let unitsPeti = $(this).siblings('.quantityinput').val(); 
       let petiId = $(this).attr("value");
       let stokeType = $(this).attr("data-stokeType");
        // console.log(productIdB,unitsBottle,stokeType);
     
        if(!unitsPeti){
            alert("Please Enter Quantity");
        }
    
        $.ajax({
          url: "./queries.php",
          type: "GET",
          data: { petiId, unitsPeti ,stokeType},
          success: function (data) {
            var response = JSON.parse(data);
            // console.log(response);
            $("#successModal").removeClass("hidden");
    
            if (response.status === true) {
              $("#msg").addClass("text-green-400");
              $("#imgDiv").html(
                '<img src="../icons/correct (1) 32.png" alt="icons">'
              );
            } else if (response.status === false) {
              $("#msg").addClass("text-red-400");
              $("#imgDiv").html(
                '<img src="../icons/incorrect 32 px.png" alt="icons">'
              );
            }
    
            $("#msg").text(response.msg);
            setTimeout(function () {
              $("#successModal").addClass("hidden")
            }, 3000);
          },
        });
      });
});
