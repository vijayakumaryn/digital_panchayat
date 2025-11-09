<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

require('conn.php');

// Delete user if requested
if (isset($_GET['delete'])) {
    $userId = (int)$_GET['delete'];
    $stmt = $con->prepare("DELETE FROM user_table WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    header("Location: usersinfo.php");
    exit();
}

// Fetch all users
$result = $con->query("SELECT * FROM user_table ORDER BY id DESC");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Registered Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('images/im9.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #fff;
        }
        h1 { text-align: center; font-size: 44px; color: #FFD700; font-family: 'Pacifico', cursive; text-shadow: 2px 2px 8px rgba(0,0,0,0.7); margin-top: 20px; }
        h2 { text-align: center; font-size: 28px; color: #00FFFF; margin-bottom: 20px; text-shadow: 1px 1px 5px rgba(0,0,0,0.7); }
        .search-box { text-align: center; margin-bottom: 20px; }
        #searchInput { width: 50%; padding: 10px 15px; border-radius: 15px; border: 2px solid #00FFFF; font-size: 16px; outline: none; }
        #searchInput:focus { box-shadow: 0 4px 15px rgba(0,255,255,0.5); }
        table { width: 90%; margin: 0 auto 30px auto; border-collapse: collapse; border-radius: 15px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; }
        th { background: linear-gradient(90deg, #FF416C, #FF4B2B); color: #fff; font-size: 16px; }
        tr { background-color: rgba(255,255,255,0.85); color: #000; transition: 0.3s; }
        tr:nth-child(even) { background-color: rgba(255,255,255,0.75); }
        tr:hover { background-color: rgba(0,255,255,0.2); transform: scale(1.02); }
        .delete-button { background: linear-gradient(45deg, #FF416C, #FF4B2B); color: #fff; border: none; padding: 8px 12px; border-radius: 10px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .delete-button:hover { background: linear-gradient(45deg, #FF4B2B, #FF416C); transform: translateY(-3px); box-shadow: 0 4px 15px rgba(255,65,108,0.7); }
        .back-link { display: block; width: 200px; margin: 0 auto 40px auto; padding: 12px; text-align: center; background: linear-gradient(90deg, #00f, #0ff); color: #fff; text-decoration: none; border-radius: 15px; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,255,0.5); transition: 0.3s; }
        .back-link:hover { background: linear-gradient(90deg, #0ff, #00f); transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,255,255,0.6); }
    </style>
</head>
<body>
    <h1>Gram Panchayat Admin</h1>
    <h2>Registered Users</h2>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search by Name, Mobile, Aadhar...">
    </div>

    <table id="usersTable">
        <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Aadhar</th>
            <th>State</th>
            <th>Town</th>
            <th>Village</th>
            <th>Action</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['uname'] ?></td>
                <td><?= $user['mobile'] ?></td>
                <td><?= $user['aadhar'] ?></td>
                <td><?= $user['state'] ?></td>
                <td><?= $user['town'] ?></td>
                <td><?= $user['village'] ?></td>
                <td><button class="delete-button" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a class="back-link" href="adminhome.php">Back to Admin Home</a>

<script>
    function deleteUser(userId) {
        if(confirm("Are you sure you want to delete this user?")) {
            window.location.href = "usersinfo.php?delete=" + userId;
        }
    }

    // Client-side search filter
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('usersTable');

    searchInput.addEventListener('keyup', function(){
        const filter = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tr');
        for(let i=1; i<rows.length; i++){
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            for(let j=0; j<cells.length-1; j++){
                if(cells[j].innerText.toLowerCase().includes(filter)){
                    match = true; break;
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    });
</script>
</body>
</html>
