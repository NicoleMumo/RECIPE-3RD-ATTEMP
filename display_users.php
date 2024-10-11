<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .user-img {
            max-width: 100px;
            max-height: 100px;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin-right: 5px;
        }
        .edit-btn:hover, .delete-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>User Data</h2>

<table>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Email</th>
        <th>Role</th> <!-- Added Role column header -->
        <th>Image</th>
        <th>Action</th>
    </tr>

    <?php
    // Include database connection
    require 'database.php';

    // SQL query to retrieve data from the 'user' table
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    // Display data in HTML table
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["User-id"] . "</td>";
            echo "<td>" . $row["Username"] . "</td>";
            echo "<td>" . $row["Age"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["Role"] . "</td>"; // Display Role column
           
            // Display image if available
            if (!empty($row['Image'])) {
                echo '<td><img src="data:image/jpeg;base64,'.base64_encode($row['Image']).'" alt="User Image" class="user-img"></td>';
            } else {
                echo "<td>No image uploaded</td>";
            }

            // Action buttons (Edit and Delete)
            echo '<td>';
            echo '<a href="edit_user.php?id=' . $row["User-id"] . '" class="edit-btn">Edit</a>';
            echo '<a href="delete_user.php?id=' . $row["User-id"] . '" class="delete-btn">Delete</a>';
            echo '</td>';
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No users found</td></tr>";
    }
    $conn->close();
    ?>

</table>

</body>
</html>
