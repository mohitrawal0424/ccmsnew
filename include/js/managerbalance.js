$(document).ready(function () {
  const transferModal = $("#transfer-modal");
  const transferModalOpenBtn = $(".transferModalOpenBtn");

  $(transferModalOpenBtn).click(function () {

    const personId = $(this).attr("data-person");
    const availableAmount = $(this).attr("data-availableBalance");
    // console.log(personId,availableAmount);
    // return

    $("#availAmount").val(availableAmount);
    $("#personid").val(personId);
    $(transferModal).removeClass("hidden");
  });

  $("#transferModalCloseBtn").click(function () {
    $(transferModal).addClass("hidden");
  });

  $("#sendAmount").click(function (e) {

    e.preventDefault();
    
    const availAmount = $("#availAmount").val();
    const amount = $("#tamount").val();
    const mode = $("#modePayment").val();
    const personId = $("#personid").val();
    // console.log(availAmount,amount,mode,personId);

    const alertDiv = $("#alertdiv");
    alertDiv.text("");

    if (availAmount == "" || availAmount == 0) {
      return;
    }

    if (amount == "" || amount == 0) {
      alertDiv.text("Enter Amount *");
      alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
      $("#tamount").after(alertDiv);
      return;
    }
    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { availAmount, amount, mode, personId },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        if (data.status == true) {
          window.location.href = "managerbalance.php?personRemainBalance=1";
        } else {
          alert("something Wrong");
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  });

  //set Div as Hide
  // $("#TransactionTableDiv").hide();
  // $("#showTransactionTableBtn").click(function () {
  //   $("#TransactionTableDiv").toggle();
  // });
});
