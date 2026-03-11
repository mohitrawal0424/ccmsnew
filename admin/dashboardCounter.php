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
include_once "../include/navbarCounter.php";
include_once "../include/connect.php";

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$currentMonth = date('Y-m-01');
$currentYear = date('Y-01-01');

// Daily Counter Sales
$dailySales = 0;
$sql = "SELECT COALESCE(SUM(totalbill - discount), 0) as total FROM counter WHERE DATE(timestamp) = ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $dailySales = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}

// Yesterday Counter Sales
$yesterdaySales = 0;
$sql = "SELECT COALESCE(SUM(totalbill - discount), 0) as total FROM counter WHERE DATE(timestamp) = ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $yesterday);
    $stmt->execute();
    $yesterdaySales = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}

// Monthly Counter Sales
$monthlySales = 0;
$sql = "SELECT COALESCE(SUM(totalbill - discount), 0) as total FROM counter WHERE DATE(timestamp) >= ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $currentMonth);
    $stmt->execute();
    $monthlySales = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}

// Yearly Counter Sales
$yearlySales = 0;
$sql = "SELECT COALESCE(SUM(totalbill - discount), 0) as total FROM counter WHERE DATE(timestamp) >= ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $currentYear);
    $stmt->execute();
    $yearlySales = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}

// Lifelong Counter Sales
$lifelongSales = 0;
$sql = "SELECT COALESCE(SUM(totalbill - discount), 0) as total FROM counter";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->execute();
    $lifelongSales = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}

// Daily Counter Profit
$dailyProfit = 0;
$sql = "SELECT COALESCE(SUM(
    CASE 
        WHEN cd.itemtype = 1 THEN (p.price - p.bprice) * cd.nos
        WHEN cd.itemtype = 0 THEN (pr.price - pr.bprice) * cd.nos
        ELSE 0
    END
), 0) as profit FROM counterdetails cd
JOIN counter c ON cd.counterid = c.id
LEFT JOIN peti p ON cd.itemid = p.id AND cd.itemtype = 1
LEFT JOIN product pr ON cd.itemid = pr.id AND cd.itemtype = 0
WHERE DATE(c.timestamp) = ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $dailyProfit = $stmt->get_result()->fetch_assoc()['profit'];
    $stmt->close();
}

// Yesterday Counter Profit
$yesterdayProfit = 0;
$sql = "SELECT COALESCE(SUM(
    CASE 
        WHEN cd.itemtype = 1 THEN (p.price - p.bprice) * cd.nos
        WHEN cd.itemtype = 0 THEN (pr.price - pr.bprice) * cd.nos
        ELSE 0
    END
), 0) as profit FROM counterdetails cd
JOIN counter c ON cd.counterid = c.id
LEFT JOIN peti p ON cd.itemid = p.id AND cd.itemtype = 1
LEFT JOIN product pr ON cd.itemid = pr.id AND cd.itemtype = 0
WHERE DATE(c.timestamp) = ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $yesterday);
    $stmt->execute();
    $yesterdayProfit = $stmt->get_result()->fetch_assoc()['profit'];
    $stmt->close();
}

// Monthly Counter Profit
$monthlyProfit = 0;
$sql = "SELECT COALESCE(SUM(
    CASE 
        WHEN cd.itemtype = 1 THEN (p.price - p.bprice) * cd.nos
        WHEN cd.itemtype = 0 THEN (pr.price - pr.bprice) * cd.nos
        ELSE 0
    END
), 0) as profit FROM counterdetails cd
JOIN counter c ON cd.counterid = c.id
LEFT JOIN peti p ON cd.itemid = p.id AND cd.itemtype = 1
LEFT JOIN product pr ON cd.itemid = pr.id AND cd.itemtype = 0
WHERE DATE(c.timestamp) >= ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $currentMonth);
    $stmt->execute();
    $monthlyProfit = $stmt->get_result()->fetch_assoc()['profit'];
    $stmt->close();
}

// Yearly Counter Profit
$yearlyProfit = 0;
$sql = "SELECT COALESCE(SUM(
    CASE 
        WHEN cd.itemtype = 1 THEN (p.price - p.bprice) * cd.nos
        WHEN cd.itemtype = 0 THEN (pr.price - pr.bprice) * cd.nos
        ELSE 0
    END
), 0) as profit FROM counterdetails cd
JOIN counter c ON cd.counterid = c.id
LEFT JOIN peti p ON cd.itemid = p.id AND cd.itemtype = 1
LEFT JOIN product pr ON cd.itemid = pr.id AND cd.itemtype = 0
WHERE DATE(c.timestamp) >= ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $currentYear);
    $stmt->execute();
    $yearlyProfit = $stmt->get_result()->fetch_assoc()['profit'];
    $stmt->close();
}

// Lifelong Counter Profit
$lifelongProfit = 0;
$sql = "SELECT COALESCE(SUM(
    CASE 
        WHEN cd.itemtype = 1 THEN (p.price - p.bprice) * cd.nos
        WHEN cd.itemtype = 0 THEN (pr.price - pr.bprice) * cd.nos
        ELSE 0
    END
), 0) as profit FROM counterdetails cd
JOIN counter c ON cd.counterid = c.id
LEFT JOIN peti p ON cd.itemid = p.id AND cd.itemtype = 1
LEFT JOIN product pr ON cd.itemid = pr.id AND cd.itemtype = 0";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->execute();
    $lifelongProfit = $stmt->get_result()->fetch_assoc()['profit'];
    $stmt->close();
}

// Daily Counter Created
$dailyCounter = 0;
$sql = "SELECT COUNT(*) as total FROM counter WHERE DATE(timestamp) = ?";
$stmt = $conn->prepare($sql);
if($stmt) {
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $dailyCounter = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();
}
?>

<div class="p-6">
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Counter Dashboard</h1>
    <p class="text-gray-500 text-sm mt-2">Counter business statistics</p>
  </div>

  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Sales Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
      <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Daily Sales</p>
        <p class="text-2xl font-bold text-blue-600 mt-2">₹<?php echo number_format($dailySales, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 border-2 border-cyan-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Yesterday Sales</p>
        <p class="text-2xl font-bold text-cyan-600 mt-2">₹<?php echo number_format($yesterdaySales, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Monthly Sales</p>
        <p class="text-2xl font-bold text-green-600 mt-2">₹<?php echo number_format($monthlySales, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Yearly Sales</p>
        <p class="text-2xl font-bold text-purple-600 mt-2">₹<?php echo number_format($yearlySales, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 border-2 border-indigo-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Lifelong Sales</p>
        <p class="text-2xl font-bold text-indigo-600 mt-2">₹<?php echo number_format($lifelongSales, 0); ?></p>
      </div>
    </div>
  </div>

  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Profit Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
      <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Daily Profit</p>
        <p class="text-2xl font-bold text-red-600 mt-2">₹<?php echo number_format($dailyProfit, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Yesterday Profit</p>
        <p class="text-2xl font-bold text-orange-600 mt-2">₹<?php echo number_format($yesterdayProfit, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Monthly Profit</p>
        <p class="text-2xl font-bold text-yellow-600 mt-2">₹<?php echo number_format($monthlyProfit, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-pink-50 to-pink-100 border-2 border-pink-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Yearly Profit</p>
        <p class="text-2xl font-bold text-pink-600 mt-2">₹<?php echo number_format($yearlyProfit, 0); ?></p>
      </div>
      <div class="p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Lifelong Profit</p>
        <p class="text-2xl font-bold text-emerald-600 mt-2">₹<?php echo number_format($lifelongProfit, 0); ?></p>
      </div>
    </div>
  </div>

  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Additional Metrics</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 border-2 border-teal-400 rounded-lg shadow-md">
        <p class="text-gray-600 text-sm font-semibold">Daily Counter Created</p>
        <p class="text-3xl font-bold text-teal-600 mt-2"><?php echo $dailyCounter; ?></p>
      </div>
    </div>
  </div>
</div>

<?php include_once "../include/footer.php";

?>
</body>
</html>