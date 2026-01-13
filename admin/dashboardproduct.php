<?php
include("../include/functions/session.php");
session();
session_timeout();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CocaCola Salary Management</title>
    <link rel="stylesheet" href="../output.css">
</head>
<body>
<?php
date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar2.php";
include_once "../include/connect.php";
include("../include/functions/functions.php");

// Get today's date
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$currentMonth = date('Y-m-01');
$currentYear = date('Y-01-01');

// Daily Sales - from solditems table with timestamp
$dailySales = 0;
$sqlDailySales = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE(p.price, 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE(pr.price, 0) * si.nos
        ELSE 0
    END
), 0) as daily_sales 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) = ?
";
$stmtDailySales = $conn->prepare($sqlDailySales);
if ($stmtDailySales) {
    $stmtDailySales->bind_param("s", $today);
    $stmtDailySales->execute();
    $resultDailySales = $stmtDailySales->get_result();
    $dailySales = $resultDailySales->fetch_assoc()['daily_sales'] ?? 0;
    $stmtDailySales->close();
}

// Yesterday Sales - from solditems table with timestamp
$yesterdaySales = 0;
$sqlYesterdaySales = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE(p.price, 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE(pr.price, 0) * si.nos
        ELSE 0
    END
), 0) as yesterday_sales 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) = ?
";
$stmtYesterdaySales = $conn->prepare($sqlYesterdaySales);
if ($stmtYesterdaySales) {
    $stmtYesterdaySales->bind_param("s", $yesterday);
    $stmtYesterdaySales->execute();
    $resultYesterdaySales = $stmtYesterdaySales->get_result();
    $yesterdaySales = $resultYesterdaySales->fetch_assoc()['yesterday_sales'] ?? 0;
    $stmtYesterdaySales->close();
}

// Monthly Sales - from solditems table with timestamp
$monthlySales = 0;
$sqlMonthlySales = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE(p.price, 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE(pr.price, 0) * si.nos
        ELSE 0
    END
), 0) as monthly_sales 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) >= ?
";
$stmtMonthlySales = $conn->prepare($sqlMonthlySales);
if ($stmtMonthlySales) {
    $stmtMonthlySales->bind_param("s", $currentMonth);
    $stmtMonthlySales->execute();
    $resultMonthlySales = $stmtMonthlySales->get_result();
    $monthlySales = $resultMonthlySales->fetch_assoc()['monthly_sales'] ?? 0;
    $stmtMonthlySales->close();
}

// Yearly Sales - from solditems table with timestamp
$yearlySales = 0;
$sqlYearlySales = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE(p.price, 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE(pr.price, 0) * si.nos
        ELSE 0
    END
), 0) as yearly_sales 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) >= ?
";
$stmtYearlySales = $conn->prepare($sqlYearlySales);
if ($stmtYearlySales) {
    $stmtYearlySales->bind_param("s", $currentYear);
    $stmtYearlySales->execute();
    $resultYearlySales = $stmtYearlySales->get_result();
    $yearlySales = $resultYearlySales->fetch_assoc()['yearly_sales'] ?? 0;
    $stmtYearlySales->close();
}

// Lifelong Sales - from solditems table with timestamp
$lifelongSales = 0;
$sqlLifelongSales = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE(p.price, 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE(pr.price, 0) * si.nos
        ELSE 0
    END
), 0) as lifelong_sales 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
";
$stmtLifelongSales = $conn->prepare($sqlLifelongSales);
if ($stmtLifelongSales) {
    $stmtLifelongSales->execute();
    $resultLifelongSales = $stmtLifelongSales->get_result();
    $lifelongSales = $resultLifelongSales->fetch_assoc()['lifelong_sales'] ?? 0;
    $stmtLifelongSales->close();
}

// Daily Gaadi Created
$dailyGaadi = 0;
$sqlDailyGaadi = "SELECT COUNT(*) as daily_gaadi FROM gaadis WHERE DATE(timestamp) = ?";
$stmtDailyGaadi = $conn->prepare($sqlDailyGaadi);
if ($stmtDailyGaadi) {
    $stmtDailyGaadi->bind_param("s", $today);
    $stmtDailyGaadi->execute();
    $resultDailyGaadi = $stmtDailyGaadi->get_result();
    $dailyGaadi = $resultDailyGaadi->fetch_assoc()['daily_gaadi'] ?? 0;
    $stmtDailyGaadi->close();
}

// Daily Cash Received
$dailyCash = 0;
$sqlDailyCash = "SELECT COALESCE(SUM(amount), 0) as daily_cash FROM amountpaidgaadis WHERE type = 1 AND DATE(timestamp) = ?";
$stmtDailyCash = $conn->prepare($sqlDailyCash);
if ($stmtDailyCash) {
    $stmtDailyCash->bind_param("s", $today);
    $stmtDailyCash->execute();
    $resultDailyCash = $stmtDailyCash->get_result();
    $dailyCash = $resultDailyCash->fetch_assoc()['daily_cash'] ?? 0;
    $stmtDailyCash->close();
}

// Daily Bank Transfer Received
$dailyBank = 0;
$sqlDailyBank = "SELECT COALESCE(SUM(amount), 0) as daily_bank FROM amountpaidgaadis WHERE type = 2 AND DATE(timestamp) = ?";
$stmtDailyBank = $conn->prepare($sqlDailyBank);
if ($stmtDailyBank) {
    $stmtDailyBank->bind_param("s", $today);
    $stmtDailyBank->execute();
    $resultDailyBank = $stmtDailyBank->get_result();
    $dailyBank = $resultDailyBank->fetch_assoc()['daily_bank'] ?? 0;
    $stmtDailyBank->close();
}

// Yesterday Cash Received
$yesterdayCash = 0;
$sqlYesterdayCash = "SELECT COALESCE(SUM(amount), 0) as yesterday_cash FROM amountpaidgaadis WHERE type = 1 AND DATE(timestamp) = ?";
$stmtYesterdayCash = $conn->prepare($sqlYesterdayCash);
if ($stmtYesterdayCash) {
    $stmtYesterdayCash->bind_param("s", $yesterday);
    $stmtYesterdayCash->execute();
    $resultYesterdayCash = $stmtYesterdayCash->get_result();
    $yesterdayCash = $resultYesterdayCash->fetch_assoc()['yesterday_cash'] ?? 0;
    $stmtYesterdayCash->close();
}

// Yesterday Bank Transfer Received
$yesterdayBank = 0;
$sqlYesterdayBank = "SELECT COALESCE(SUM(amount), 0) as yesterday_bank FROM amountpaidgaadis WHERE type = 2 AND DATE(timestamp) = ?";
$stmtYesterdayBank = $conn->prepare($sqlYesterdayBank);
if ($stmtYesterdayBank) {
    $stmtYesterdayBank->bind_param("s", $yesterday);
    $stmtYesterdayBank->execute();
    $resultYesterdayBank = $stmtYesterdayBank->get_result();
    $yesterdayBank = $resultYesterdayBank->fetch_assoc()['yesterday_bank'] ?? 0;
    $stmtYesterdayBank->close();
}

// Monthly Cash Received
$monthlyCash = 0;
$sqlMonthlyCash = "SELECT COALESCE(SUM(amount), 0) as monthly_cash FROM amountpaidgaadis WHERE type = 1 AND DATE(timestamp) >= ?";
$stmtMonthlyCash = $conn->prepare($sqlMonthlyCash);
if ($stmtMonthlyCash) {
    $stmtMonthlyCash->bind_param("s", $currentMonth);
    $stmtMonthlyCash->execute();
    $resultMonthlyCash = $stmtMonthlyCash->get_result();
    $monthlyCash = $resultMonthlyCash->fetch_assoc()['monthly_cash'] ?? 0;
    $stmtMonthlyCash->close();
}

// Monthly Bank Transfer Received
$monthlyBank = 0;
$sqlMonthlyBank = "SELECT COALESCE(SUM(amount), 0) as monthly_bank FROM amountpaidgaadis WHERE type = 2 AND DATE(timestamp) >= ?";
$stmtMonthlyBank = $conn->prepare($sqlMonthlyBank);
if ($stmtMonthlyBank) {
    $stmtMonthlyBank->bind_param("s", $currentMonth);
    $stmtMonthlyBank->execute();
    $resultMonthlyBank = $stmtMonthlyBank->get_result();
    $monthlyBank = $resultMonthlyBank->fetch_assoc()['monthly_bank'] ?? 0;
    $stmtMonthlyBank->close();
}

// Yearly Cash Received
$yearlyCash = 0;
$sqlYearlyCash = "SELECT COALESCE(SUM(amount), 0) as yearly_cash FROM amountpaidgaadis WHERE type = 1 AND DATE(timestamp) >= ?";
$stmtYearlyCash = $conn->prepare($sqlYearlyCash);
if ($stmtYearlyCash) {
    $stmtYearlyCash->bind_param("s", $currentYear);
    $stmtYearlyCash->execute();
    $resultYearlyCash = $stmtYearlyCash->get_result();
    $yearlyCash = $resultYearlyCash->fetch_assoc()['yearly_cash'] ?? 0;
    $stmtYearlyCash->close();
}

// Yearly Bank Transfer Received
$yearlyBank = 0;
$sqlYearlyBank = "SELECT COALESCE(SUM(amount), 0) as yearly_bank FROM amountpaidgaadis WHERE type = 2 AND DATE(timestamp) >= ?";
$stmtYearlyBank = $conn->prepare($sqlYearlyBank);
if ($stmtYearlyBank) {
    $stmtYearlyBank->bind_param("s", $currentYear);
    $stmtYearlyBank->execute();
    $resultYearlyBank = $stmtYearlyBank->get_result();
    $yearlyBank = $resultYearlyBank->fetch_assoc()['yearly_bank'] ?? 0;
    $stmtYearlyBank->close();
}

// Lifelong Cash Received
$lifelongCash = 0;
$sqlLifelongCash = "SELECT COALESCE(SUM(amount), 0) as lifelong_cash FROM amountpaidgaadis WHERE type = 1";
$stmtLifelongCash = $conn->prepare($sqlLifelongCash);
if ($stmtLifelongCash) {
    $stmtLifelongCash->execute();
    $resultLifelongCash = $stmtLifelongCash->get_result();
    $lifelongCash = $resultLifelongCash->fetch_assoc()['lifelong_cash'] ?? 0;
    $stmtLifelongCash->close();
}

// Lifelong Bank Transfer Received
$lifelongBank = 0;
$sqlLifelongBank = "SELECT COALESCE(SUM(amount), 0) as lifelong_bank FROM amountpaidgaadis WHERE type = 2";
$stmtLifelongBank = $conn->prepare($sqlLifelongBank);
if ($stmtLifelongBank) {
    $stmtLifelongBank->execute();
    $resultLifelongBank = $stmtLifelongBank->get_result();
    $lifelongBank = $resultLifelongBank->fetch_assoc()['lifelong_bank'] ?? 0;
    $stmtLifelongBank->close();
}

// Daily Profit - from solditems with cost calculation
$dailyProfit = 0;
$sqlDailyProfit = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE((p.price - p.bprice), 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE((pr.price - pr.bprice), 0) * si.nos
        ELSE 0
    END
), 0) as daily_profit 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) = ?
";
$stmtDailyProfit = $conn->prepare($sqlDailyProfit);
if ($stmtDailyProfit) {
    $stmtDailyProfit->bind_param("s", $today);
    $stmtDailyProfit->execute();
    $resultDailyProfit = $stmtDailyProfit->get_result();
    $dailyProfit = $resultDailyProfit->fetch_assoc()['daily_profit'] ?? 0;
    $stmtDailyProfit->close();
}

// Yesterday Profit - from solditems with cost calculation
$yesterdayProfit = 0;
$sqlYesterdayProfit = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE((p.price - p.bprice), 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE((pr.price - pr.bprice), 0) * si.nos
        ELSE 0
    END
), 0) as yesterday_profit 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) = ?
";
$stmtYesterdayProfit = $conn->prepare($sqlYesterdayProfit);
if ($stmtYesterdayProfit) {
    $stmtYesterdayProfit->bind_param("s", $yesterday);
    $stmtYesterdayProfit->execute();
    $resultYesterdayProfit = $stmtYesterdayProfit->get_result();
    $yesterdayProfit = $resultYesterdayProfit->fetch_assoc()['yesterday_profit'] ?? 0;
    $stmtYesterdayProfit->close();
}

// Monthly Profit - from solditems with cost calculation
$monthlyProfit = 0;
$sqlMonthlyProfit = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE((p.price - p.bprice), 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE((pr.price - pr.bprice), 0) * si.nos
        ELSE 0
    END
), 0) as monthly_profit 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) >= ?
";
$stmtMonthlyProfit = $conn->prepare($sqlMonthlyProfit);
if ($stmtMonthlyProfit) {
    $stmtMonthlyProfit->bind_param("s", $currentMonth);
    $stmtMonthlyProfit->execute();
    $resultMonthlyProfit = $stmtMonthlyProfit->get_result();
    $monthlyProfit = $resultMonthlyProfit->fetch_assoc()['monthly_profit'] ?? 0;
    $stmtMonthlyProfit->close();
}

// Yearly Profit - from solditems with cost calculation
$yearlyProfit = 0;
$sqlYearlyProfit = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE((p.price - p.bprice), 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE((pr.price - pr.bprice), 0) * si.nos
        ELSE 0
    END
), 0) as yearly_profit 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
WHERE DATE(si.timestamp) >= ?
";
$stmtYearlyProfit = $conn->prepare($sqlYearlyProfit);
if ($stmtYearlyProfit) {
    $stmtYearlyProfit->bind_param("s", $currentYear);
    $stmtYearlyProfit->execute();
    $resultYearlyProfit = $stmtYearlyProfit->get_result();
    $yearlyProfit = $resultYearlyProfit->fetch_assoc()['yearly_profit'] ?? 0;
    $stmtYearlyProfit->close();
}

// Lifelong Profit - from solditems with cost calculation
$lifelongProfit = 0;
$sqlLifelongProfit = "
SELECT COALESCE(SUM(
    CASE 
        WHEN gd.itemtype = 1 THEN COALESCE((p.price - p.bprice), 0) * si.nos
        WHEN gd.itemtype = 2 THEN COALESCE((pr.price - pr.bprice), 0) * si.nos
        ELSE 0
    END
), 0) as lifelong_profit 
FROM solditems si
JOIN gaadidetails gd ON si.idFromGaadiDetails = gd.id
LEFT JOIN peti p ON gd.itemid = p.id AND gd.itemtype = 1
LEFT JOIN product pr ON gd.itemid = pr.id AND gd.itemtype = 2
";
$stmtLifelongProfit = $conn->prepare($sqlLifelongProfit);
if ($stmtLifelongProfit) {
    $stmtLifelongProfit->execute();
    $resultLifelongProfit = $stmtLifelongProfit->get_result();
    $lifelongProfit = $resultLifelongProfit->fetch_assoc()['lifelong_profit'] ?? 0;
    $stmtLifelongProfit->close();
}
?>
   
<div class="p-6"> 
  <!-- Main Dashboard Title -->
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 text-sm mt-2">Real-time business statistics</p>
  </div>

  <!-- Sales Cards Section -->
  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Sales Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
      <!-- Daily Sales Card -->
      <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Daily Sales</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">₹<?php echo number_format($dailySales, 0); ?></p>
          </div>
          <div class="text-4xl text-blue-300">📊</div>
        </div>
      </div>

      <!-- Yesterday Sales Card -->
      <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 border-2 border-cyan-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yesterday Sales</p>
            <p class="text-2xl font-bold text-cyan-600 mt-2">₹<?php echo number_format($yesterdaySales, 0); ?></p>
          </div>
          <div class="text-4xl text-cyan-300">📈</div>
        </div>
      </div>

      <!-- Monthly Sales Card -->
      <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Monthly Sales</p>
            <p class="text-2xl font-bold text-green-600 mt-2">₹<?php echo number_format($monthlySales, 0); ?></p>
          </div>
          <div class="text-4xl text-green-300">📅</div>
        </div>
      </div>

      <!-- Yearly Sales Card -->
      <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yearly Sales</p>
            <p class="text-2xl font-bold text-purple-600 mt-2">₹<?php echo number_format($yearlySales, 0); ?></p>
          </div>
          <div class="text-4xl text-purple-300">📆</div>
        </div>
      </div>

      <!-- Lifelong Sales Card -->
      <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 border-2 border-indigo-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Lifelong Sales</p>
            <p class="text-2xl font-bold text-indigo-600 mt-2">₹<?php echo number_format($lifelongSales, 0); ?></p>
          </div>
          <div class="text-4xl text-indigo-300">💰</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Profit Cards Section -->
  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Profit Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
      <!-- Daily Profit Card -->
      <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Daily Profit</p>
            <p class="text-2xl font-bold text-red-600 mt-2">₹<?php echo number_format($dailyProfit, 0); ?></p>
          </div>
          <div class="text-4xl text-red-300">💵</div>
        </div>
      </div>

      <!-- Yesterday Profit Card -->
      <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yesterday Profit</p>
            <p class="text-2xl font-bold text-orange-600 mt-2">₹<?php echo number_format($yesterdayProfit, 0); ?></p>
          </div>
          <div class="text-4xl text-orange-300">📊</div>
        </div>
      </div>

      <!-- Monthly Profit Card -->
      <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Monthly Profit</p>
            <p class="text-2xl font-bold text-yellow-600 mt-2">₹<?php echo number_format($monthlyProfit, 0); ?></p>
          </div>
          <div class="text-4xl text-yellow-300">📈</div>
        </div>
      </div>

      <!-- Yearly Profit Card -->
      <div class="p-4 bg-gradient-to-br from-pink-50 to-pink-100 border-2 border-pink-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yearly Profit</p>
            <p class="text-2xl font-bold text-pink-600 mt-2">₹<?php echo number_format($yearlyProfit, 0); ?></p>
          </div>
          <div class="text-4xl text-pink-300">📆</div>
        </div>
      </div>

      <!-- Lifelong Profit Card -->
      <div class="p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Lifelong Profit</p>
            <p class="text-2xl font-bold text-emerald-600 mt-2">₹<?php echo number_format($lifelongProfit, 0); ?></p>
          </div>
          <div class="text-4xl text-emerald-300">💎</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Additional Metrics Section -->
  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Additional Metrics</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!-- Daily Gaadi Created Card -->
      <div class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 border-2 border-teal-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Daily Gaadi Created</p>
            <p class="text-3xl font-bold text-teal-600 mt-2"><?php echo $dailyGaadi; ?></p>
          </div>
          <div class="text-4xl text-teal-300">🚗</div>
        </div>
      </div>

      <!-- Daily Cash Received Card -->
      <div class="p-4 bg-gradient-to-br from-lime-50 to-lime-100 border-2 border-lime-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yesterday Cash Received</p>
            <p class="text-2xl font-bold text-lime-600 mt-2">₹<?php echo number_format($yesterdayCash, 0); ?></p>
          </div>
          <div class="text-4xl text-lime-300">💵</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Daily Cash Received</p>
            <p class="text-2xl font-bold text-lime-600 mt-2">₹<?php echo number_format($dailyCash, 0); ?></p>
          </div>
          <div class="text-4xl text-lime-300">💵</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Monthly Cash Received</p>
            <p class="text-2xl font-bold text-lime-600 mt-2">₹<?php echo number_format($monthlyCash, 0); ?></p>
          </div>
          <div class="text-4xl text-lime-300">💵</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yearly Cash Received</p>
            <p class="text-2xl font-bold text-lime-600 mt-2">₹<?php echo number_format($yearlyCash, 0); ?></p>
          </div>
          <div class="text-4xl text-lime-300">💵</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Lifelong Cash Received</p>
            <p class="text-2xl font-bold text-lime-600 mt-2">₹<?php echo number_format($lifelongCash, 0); ?></p>
          </div>
          <div class="text-4xl text-lime-300">💵</div>
        </div>
        
      </div>

      <!-- Daily Bank Transfer Card -->
      <div class="p-4 bg-gradient-to-br from-sky-50 to-sky-100 border-2 border-sky-400 rounded-lg shadow-md hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yesterday Bank Transfer</p>
            <p class="text-2xl font-bold text-sky-600 mt-2">₹<?php echo number_format($yesterdayBank, 0); ?></p>
          </div>
          <div class="text-4xl text-sky-300">🏦</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Daily Bank Transfer</p>
            <p class="text-2xl font-bold text-sky-600 mt-2">₹<?php echo number_format($dailyBank, 0); ?></p>
          </div>
          <div class="text-4xl text-sky-300">🏦</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Monthly Bank Transfer</p>
            <p class="text-2xl font-bold text-sky-600 mt-2">₹<?php echo number_format($monthlyBank, 0); ?></p>
          </div>
          <div class="text-4xl text-sky-300">🏦</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Yearly Bank Transfer</p>
            <p class="text-2xl font-bold text-sky-600 mt-2">₹<?php echo number_format($yearlyBank, 0); ?></p>
          </div>
          <div class="text-4xl text-sky-300">🏦</div>
        </div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-semibold">Lifelong Bank Transfer</p>
            <p class="text-2xl font-bold text-sky-600 mt-2">₹<?php echo number_format($lifelongBank, 0); ?></p>
          </div>
          <div class="text-4xl text-sky-300">🏦</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "../include/footer.php"; ?>
</body>
</html>