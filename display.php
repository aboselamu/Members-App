<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }

        .employee-list-container {
            max-width: 100%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        h2 {
            color: #333;
            font-size: 40px;
        }

        .back-button {
            position: absolute;
            top: 100px;
            left: 100px;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        .search-form {
            margin-top: 20px;
            text-align: center;
        }

        .search-input {
            padding: 10px;
            width: 60%;
            box-sizing: border-box;
        }

        .search-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #45a049;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px;
            margin: 0 5px;
            text-decoration: none;
            color: #4CAF50;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        .rows-per-page {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <button class="back-button" onclick="goBack()">Back</button>

    <div class="employee-list-container">
        <h2>Members List</h2>

        <form class="search-form" method="GET" action="">
            <label for="search">Search:</label>
            <input class="search-input" type="text" id="search" name="search" placeholder="Enter name">
            <input class="search-button" type="submit" value="Search">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>File Number</th>
                <th>Phone Number</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Email</th>
                <th>Permit Type</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "registration_form";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $rowsPerPage = isset($_GET['rows']) ? $_GET['rows'] : 10;

            $offset = ($currentPage - 1) * $rowsPerPage;
            
            $sql = "SELECT * FROM registration WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' LIMIT $offset, $rowsPerPage";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ID']}</td>";
                    echo "<td>{$row['firstname']}</td>";
                    echo "<td>{$row['lastname']}</td>";
                    echo "<td>{$row['filenumber']}</td>";
                    echo "<td>{$row['phonenumber']}</td>";
                    echo "<td>{$row['gender']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['ftype']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No members found</td></tr>";
            }

            $conn->close();
            ?>
        </table>

        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $totalRowsQuery = "SELECT COUNT(*) AS count FROM registration WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
        $totalRowsResult = $conn->query($totalRowsQuery);
        $totalRows = $totalRowsResult->fetch_assoc()['count'];

        $totalPages = ceil($totalRows / $rowsPerPage);
        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;

        echo "<div class='pagination'>";
        if ($prevPage > 0) {
            echo "<a href='?search=$search&page=$prevPage&rows=$rowsPerPage'>&lt;</a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?search=$search&page=$i&rows=$rowsPerPage'";
            if ($i == $currentPage) {
                echo " style='background-color: #45a049; color: white;'";
            }
            echo ">$i</a>";
        }

        if ($nextPage <= $totalPages) {
            echo "<a href='?search=$search&page=$nextPage&rows=$rowsPerPage'>&gt;</a>";
        }
        echo "</div>";

        $conn->close();
        ?>

        <div class="rows-per-page">
            Rows per page:
            <select id="rowsPerPage" onchange="changeRowsPerPage()">
                <option value="10" <?php if ($rowsPerPage == 10) echo 'selected="selected"'; ?>>10</option>
                <option value="20" <?php if ($rowsPerPage == 20) echo 'selected="selected"'; ?>>20</option>
                <option value="50" <?php if ($rowsPerPage == 50) echo 'selected="selected"'; ?>>50</option>
                <option value="100" <?php if ($rowsPerPage == 100) echo 'selected="selected"'; ?>>100</option>
            </select>
        </div>

    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function changeRowsPerPage() {
            var select = document.getElementById("rowsPerPage");
            var selectedValue = select.options[select.selectedIndex].value;
            window.location.href = window.location.pathname + "?search=" + getParameterByName('search') + "&page=1&rows=" + selectedValue;
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
</body>

</html>
