$(document).ready(function () {
  const transferModal = $("#transfer-counter-modal");
  const transferModalOpenBtn = $(".transferModalOpenBtn");

  $(transferModalOpenBtn).click(function () {

    const managerId = $(this).attr("data-person");
    const availableAmount = $(this).attr("data-availableBalance");
    const counterId = $(this).attr("data-counter");

    $("#counter_id").val(counterId);
    $("#availAmountCounter").val(availableAmount);
    $("#manageridCounter").val(managerId);
    $(transferModal).removeClass("hidden");
  });

  $("#transferCounterModalCloseBtn").click(function () {
    $(transferModal).addClass("hidden");
  });

  $("#sendAmountCounter").click(function (e) {

    e.preventDefault();
    
    const availAmount = $("#availAmountCounter").val();
    const amount = $("#tamountCounter").val();
    const mode = $("#modePaymentCounter").val();
    const managerId = $("#manageridCounter").val();
    const counterId = $("#counter_id").val();

    const alertDiv = $("#alertdivCounter");
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
        managerId_counter: managerId, 
        counterId: counterId 
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == true) {
          $(transferModal).addClass("hidden");
          alert("Amount transferred successfully!");
          window.location.href = "counterbalance.php?personRemainBalance=1";
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
});
