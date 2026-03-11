<?php
include("../include/functions/session.php");
session();
session_timeout();

if($_SESSION['role'] != 0) {
    header('location:staff.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../output.css">
</head>
<body>
<?php
date_default_timezone_set("Asia/Calcutta");
include_once "../include/navbar1.php";
?>

<div class="bg-white py-8 px-4 mx-auto max-w-2xl">
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="p-3 mb-3 text-md text-green-800 rounded-sm bg-green-100 border border-gray-800">Password changed successfully!</div>';
    }
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        echo '<div class="p-3 mb-3 text-md text-red-800 rounded-sm bg-red-100 border border-gray-800">' . htmlspecialchars($error) . '</div>';
    }
    ?>
    
    <h2 class="mb-4 text-2xl font-bold text-gray-900">Change Password</h2>
    <form action="./queries.php" method="POST">
        <div class="grid gap-4">
            <div>
                <label for="currentPassword" class="block mb-2 text-sm font-medium text-gray-900">Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div>
                <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
                <input type="password" name="newPassword" id="newPassword" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div>
                <label for="confirmPassword" class="block mb-2 text-sm font-medium text-gray-900">Confirm New Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
            </div>
        </div>
        <button type="submit" name="changePasswordSubmit" class="mt-6 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">Change Password</button>
    </form>
</div>

<?php include_once "../include/footer.php"; ?>
</body>
</html>
