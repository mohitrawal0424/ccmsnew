$(document).ready(function () {
  let tablebottle = new DataTable("#bottlelisttable");
  let tablepeti = new DataTable("#petilisttable");
  $("select").selectize({
    sortField: "text",
  });

  // code to enter Product/Bottle data

  $("#productsubmit").click(function (e) {
    e.preventDefault();
    let id = $("#id").val();
    let productName = $("#name").val().trim();
    let bottleSize = $("#size").val();
    let price = $("#price").val();
    let bprice = $("#bprice").val();

    if (productName.length === 0) {
      $("#errorDiv").text("* कृपया प्रोडक्ट का नाम डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#name").after($("#errorDiv"));
      return;
    }
    if (bottleSize.length === 0) {
      $("#errorDiv").text("* कृपया साइज डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#size").after($("#errorDiv"));
      return;
    }
    if (price.length === 0) {
      $("#errorDiv").text("* कृपया price डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#price").after($("#errorDiv"));
      return;
    }
    if (bprice.length === 0) {
      $("#errorDiv").text("* कृपया price डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#bprice").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { productName, bottleSize, price, bprice, id },
      success: function (data) {
        // console.log(data);
        var response = JSON.parse(data);
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

  // code to add Peti details in DB

  $("#petisubmit").click(function (e) {
    e.preventDefault();
    let productId = $("#productId").val();
    let bottleNos = $("#bottleNos").val();
    let priceSet = $("#priceSet").val();
    let bpriceSet = $("#bpriceSet").val();

    // let nameInput = $("#name");
    if (productId.length === 0) {
      $("#errorDiv").text("* कृपया प्रोडक्ट का नाम डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#productId").after($("#errorDiv"));
      return;
    }
    if (bottleNos.length === 0) {
      $("#errorDiv").text("* कृपया bottle No. डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#bottleNos").after($("#errorDiv"));
      return;
    }
    if (priceSet.length === 0) {
      $("#errorDiv").text("* कृपया price डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#priceSet").after($("#errorDiv"));
      return;
    }
    if (bpriceSet.length === 0) {
      $("#errorDiv").text("* कृपया price डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#bpriceSet").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { productId, bottleNos, priceSet, bpriceSet },
      success: function (data) {
        var response = JSON.parse(data);
        console.log(response);
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

  // code to add Peti stokes in DB

  $("#petistokesubmit").click(function (e) {
    e.preventDefault();
    let petiId = $("#petiSelect option:selected").val();
    let unitsPeti = $("#units").val();
    let defectPeti = $("#defPeti").val();
    // console.log(petiId,unitsPeti,defectPeti);

    if (petiId.length === 0 || petiId == 0) {
      $("#errorDiv").text("*Please Select Peti");
      $("#errorDiv").removeClass("hidden");
      $("#productIdandSetId").after($("#errorDiv"));
      return;
    }

    if (unitsPeti.length === 0) {
      $("#errorDiv").text("* Please Enter Quantity");
      $("#errorDiv").removeClass("hidden");
      $("#units").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { petiId, unitsPeti, defectPeti},
      success: function (data) {
        var response = JSON.parse(data);
        console.log(response);
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

  // code to add Box/Set stokes in DB
  $("#stokeBottlesubmit").click(function (e) {
    e.preventDefault();
    let productIdB = $("#productIdS option:selected").val();
    let unitsBottle = $("#unitsBottle").val();
    // let defectBottle = $("#defBottle").val();

    if (productIdB.length === 0) {
      $("#errorDiv").text("* कृपया प्रोडक्ट का नाम डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#productIdS").after($("#errorDiv"));
      return;
    }
    if (unitsBottle.length === 0) {
      $("#errorDiv").text("* कृपया bottle No. डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#unitsBottle").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { productIdB, unitsBottle},
      success: function (data) {
        var response = JSON.parse(data);
        console.log(response);
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

  // success modal close
  const successModal = document.getElementById("successModal");
  const successModalCloseBtn = document.getElementById("successModalCloseBtn");
  successModalCloseBtn.addEventListener("click", () => {
    successModal.classList.add("hidden");
  });

  // code to add defect Peti stokes in DB

  $("#defectpetisubmit").click(function (e) {
    e.preventDefault();
    let DpetiId = $("#petiSelect option:selected").val();
    let DunitsPeti = $("#units").val();
    // console.log(DpetiId,DunitsPeti);

    if (DpetiId.length === 0 || DpetiId == 0) {
      $("#errorDiv").text("* कृपया प्रोडक्ट का नाम डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#productIdandSetId").after($("#errorDiv"));
      return;
    }

    if (DunitsPeti.length === 0) {
      $("#errorDiv").text("* कृपया price डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#units").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { DpetiId, DunitsPeti },
      success: function (data) {
        console.log(data);
        // // return
        var response = JSON.parse(data);
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

  // code to add defect product stokes in DB
  $("#defectproductsubmit").click(function (e) {
    e.preventDefault();
    let DproductIdB = $("#productIdS option:selected").val();
    let DunitsBottle = $("#unitsBottle").val();

    if (DproductIdB.length === 0) {
      $("#errorDiv").text("* कृपया प्रोडक्ट का नाम डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#productIdS").after($("#errorDiv"));
      return;
    }
    if (DunitsBottle.length === 0) {
      $("#errorDiv").text("* कृपया bottle No. डालिये");
      $("#errorDiv").removeClass("hidden");
      $("#unitsBottle").after($("#errorDiv"));
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { DproductIdB, DunitsBottle },
      success: function (data) {
        var response = JSON.parse(data);
        console.log(response);
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

  //delete peti

  $(document).on("click", ".petideleteclass", function (e) {
    e.preventDefault();
    var petiDeleteId = $(this).attr("value").trim();
    var trItem = $(this).closest("tr");
    if (confirm("Delete Staff ?") == true) {
      $.ajax({
        url: "./delete.php",
        type: "GET",
        data: { petiDeleteId },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == true) {
            trItem.remove();
          } else {
            alert("something Wrong");
          }
        },
        error: function (error) {
          console.error(error);
        },
      });
    }
  });

  //delete bottle
  $(document).on("click", ".bottledeleteclass", function (e) {
    e.preventDefault();
    var bottleDeleteId = $(this).attr("value").trim();
    var trItem = $(this).closest("tr");
    if (confirm("Delete Staff ?") == true) {
      $.ajax({
        url: "./delete.php",
        type: "GET",
        data: { bottleDeleteId },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == true) {
            trItem.remove();
          } else {
            alert("something Wrong");
          }
        },
        error: function (error) {
          console.error(error);
        },
      });
    }
  });
});
