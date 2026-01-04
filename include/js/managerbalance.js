$(document).ready(function () {
  const transferModal = $("#transfer-modal");
  const transferModalOpenBtn = $(".transferModalOpenBtn");

  $(transferModalOpenBtn).click(function () {

    const managerId = $(this).attr("data-person");
    const availableAmount = $(this).attr("data-availableBalance");
    const gaadiId = $(this).attr("data-gaadi");

    $("#gaadi_id").val(gaadiId);
    $("#availAmount").val(availableAmount);
    $("#managerid").val(managerId);
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
    const managerId = $("#managerid").val();
    const gaadiId = $("#gaadi_id").val();

    const alertDiv = $("#alertdiv");
    alertDiv.text("");

    if (availAmount == "" || availAmount == 0) {
      alertDiv.text("No available balance to transfer");
      alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
      return;
    }

    if (amount == "" || amount == 0) {
      alertDiv.text("Enter Amount *");
      alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
      return;
    }

    if (parseInt(amount) > parseInt(availAmount)) {
      alertDiv.text("Amount cannot exceed available balance");
      alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
      return;
    }

    $.ajax({
      url: "./queries.php",
      type: "GET",
      data: { 
        availAmount: availAmount, 
        amount: amount, 
        mode: mode, 
        managerId_1: managerId, 
        gaadiId: gaadiId 
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == true) {
          $(transferModal).addClass("hidden");
          alert("Amount transferred successfully!");
          window.location.href = "managerbalance.php?personRemainBalance=1";
        } else {
          alertDiv.text(data.msg);
          alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
        }
      },
      error: function (error) {
        console.error(error);
        alertDiv.text("Error transferring amount");
        alertDiv.addClass("m-1 p-1 text-red-400 rounded-lg");
      },
    });
  });

  //set Div as Hide
  // $("#TransactionTableDiv").hide();
  // $("#showTransactionTableBtn").click(function () {
  //   $("#TransactionTableDiv").toggle();
  // });
});
