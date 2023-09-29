<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_GET['delet_order'])) {
    $_SESSION['delet_order']=$_GET['delet_order'];
    header("Location: delet_order.php");
}
?>
<?php

function buildPageUrl($pageNumber, $searchTerm, $searchDate) {
    $url = "devis_manager.php?page={$pageNumber}";

    if (!empty($searchTerm)) {
        $url .= "&search={$searchTerm}";
    }

    if (!empty($searchDate)) {
        $url .= "&searchDate={$searchDate}";
    }

    return $url;
}

// Define the number of records per page
$recordsPerPage = 6;

// Get the current page number from the query string or set it to 1 if not provided
$pageNumber = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Get the search term from the query string if provided
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Get the search date from the query string if provided
$searchDate = isset($_GET['searchDate']) ? mysqli_real_escape_string($conn, $_GET['searchDate']) : '';

// Calculate the starting record for the current page
$startFrom = ($pageNumber - 1) * $recordsPerPage;

// Build the SQL query based on the search term and date
$q = "SELECT * FROM `orders`";
if (!empty($searchTerm) || !empty($searchDate)) {
    $q .= " WHERE";
    
    if (!empty($searchTerm)) {
        $q .= " `buyer_name` LIKE '%$searchTerm%' OR `company_name` LIKE '%$searchTerm%'";
        
        if (!empty($searchDate)) {
            $q .= " AND";
        }
    }

    if (!empty($searchDate)) {
        $q .= " `order_date` = '$searchDate'";
    }
}

// Add LIMIT and OFFSET clauses for pagination
$q .= " LIMIT $recordsPerPage OFFSET $startFrom";

$res = mysqli_query($conn, $q);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>

        h1, h3 {
            text-align: justify; /* Justify the text in headers */
        }
        body {
            font-family: Arial, sans-serif; /* Choose a readable font */
        }
        h1 {
            font-size: 24px; /* Adjust the font size for the h1 header */
        }
        h3 {
            font-size: 18px; /* Adjust the font size for the h3 headers */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            text-align: center;;
        }

        th {
            background-color: #f2f2f2;
        }
        .container{
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
        }
.pagination {
    margin-top: 20px;
}

.pagination a {
    padding: 5px 10px;
    margin: 0 5px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #007bff; /* Link color */
}

.pagination a.active {
    background-color: #007bff; /* Active link background color */
    color: #fff; /* Active link text color */
}
    </style>
<link rel="stylesheet" href="css/style.min.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1.0">
    <title>netserv</title>
    <link rel="stylesheet"
          href="css/style.css">

	<style type="text/css">
     td,th{
        padding: 10px 30px;
     }   
    </style>
</head>
 
<body>

    <header>
 
        <div class="logosec">
            <div class="logo">NETSERV</div>
            <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png"
                class="icn menuicn"
                id="menuicn"
                alt="menu-icon">
        </div>
 
        <div class="message">
            <div class="dp">
              <img src="../../imgUser/<?=$_SESSION['img']?>"
                    class="dpicn"
                    alt="dp">
              </div>
        </div>
 
    </header>
 
    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="index.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Dashboard</h3>
                    </div></a>
                    <a href="devis.php" style="all:unset;"><div class="nav-option option12">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Ajouter Un devis</h3>
                    </div></a>
                    <a href="devis_manager.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Devis manager</h3>
                    </div></a>
 
                    <a href="edit_profile_admin.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/edit.jpg" class="nav-img" alt="settings">
                        <h3> Settings</h3>
                    </div></a>

                    <a href="../deconnexion.php" style="all:unset;">
                        <div class="nav-option logout">
                        <img src="img/logout.jpg" class="nav-img" alt="logout">
                        <h3>Logout</h3>
                    </div></a>
 
                </div>
            </nav>
        </div>
        <div class="main">
    <h1>Order List</h1>

    <!-- Add a search bar -->
<form method="GET" action="devis_manager.php">
    <input type="text" name="search" placeholder="Search by buyer or company..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="date" name="searchDate" value="<?php echo isset($_GET['searchDate']) ? htmlspecialchars($_GET['searchDate']) : ''; ?>">
    <input type="submit" value="Search">
</form>

    <table>
        <thead>
            <tr>
                <th>order_id (reference)</th>
                <th>buyer_name</th>
                <th>mail_address</th>
                <th>phoneNumber</th>
                <th>company_name</th>
                <th>address</th>
                <th>order_date</th>
                <th>order_etat</th>
                <th>prix_rest</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($d = mysqli_fetch_assoc($res)) {
                echo '<tr>';
                echo '<td><a href="order_id.php?order_id=' . $d['order_id'] . '">' . $d['order_id'] . '</a></td>';
                echo '<td>' . $d['buyer_name'] . '</td>';
                echo '<td>' . $d['mail_address'] . '</td>';
                echo '<td>' . $d['phoneNumber'] . '</td>';
                echo '<td>' . $d['company_name'] . '</td>';
                echo '<td>' . $d['address'] . '</td>';
                echo '<td>' . $d['order_date'] . '</td>';
                echo '<td>' . $d['order_etat'] . '</td>';
                echo '<td>' . $d['prix_rest'] . '</td>';
                echo '<td><a href="devis_manager.php?delet_order=' . $d['order_id'] . '">DELETE</a></td>';
                echo '</tr>';
            }
            ?>

        </tbody>
    </table>

    <!-- Create pagination links with previous and next buttons -->
    <div class="pagination">
        <?php
        // Calculate the total number of pages
        $totalRecordsQuery = "SELECT COUNT(*) as total FROM `orders`";
        if (!empty($searchTerm) || !empty($searchDate)) {
            $totalRecordsQuery .= " WHERE";
            
            if (!empty($searchTerm)) {
                $totalRecordsQuery .= " `buyer_name` LIKE '%$searchTerm%' OR `company_name` LIKE '%$searchTerm%'";
                
                if (!empty($searchDate)) {
                    $totalRecordsQuery .= " AND";
                }
            }

            if (!empty($searchDate)) {
                $totalRecordsQuery .= " `order_date` = '$searchDate'";
            }
        }

        $totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
        $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Calculate previous and next page numbers
        $prevPage = ($pageNumber > 1) ? $pageNumber - 1 : 1;
        $nextPage = ($pageNumber < $totalPages) ? $pageNumber + 1 : $totalPages;

        // Output previous page button
        if ($pageNumber > 1) {
            echo "<a class='prev' href='" . buildPageUrl($prevPage, $searchTerm, $searchDate) . "'>&laquo; Previous</a>";
        }

        // Output numbered page links
        for ($i = 1; $i <= $totalPages; $i++) {
            $url = buildPageUrl($i, $searchTerm, $searchDate);
            $class = ($i == $pageNumber) ? 'active' : '';
            echo "<a class='$class' href='$url'>$i</a>";
        }

        // Output next page button
        if ($pageNumber < $totalPages) {
            echo "<a class='next' href='" . buildPageUrl($nextPage, $searchTerm, $searchDate) . "'>Next &raquo;</a>";
        }
        ?>
    </div>

</body>
<script type="js/script.js"></script>
</html>