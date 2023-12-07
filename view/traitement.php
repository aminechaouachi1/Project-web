<?php
$host = 'localhost';
$dbname = 'dolce';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        // Supprimer la ligne de la base de données
        $delete_id = $_POST['delete_id'];
        $deleteStatement = $conn->prepare('DELETE FROM mac WHERE id_mac = :id');
        $deleteStatement->bindParam(':id', $delete_id);
        $deleteStatement->execute();
    }

    $pdostat = $conn->prepare('SELECT * FROM mac');
    $executeisok = $pdostat->execute();
    $dolce = $pdostat->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap');


    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8; /* Light gray background */
    }

    header {
        background-color: #f1c40f; /* Yellow background */
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    #dashboard {
        display: flex;
        background-color: #001f3f; /* Dark blue background for the dashboard */
        color: #fff; /* White text color */
    }

    nav {
        width: 250px;
        background-color: #2980b9; /* Dark blue background for the navigation sidebar */
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    #content {
        flex: 1;
        padding: 20px;
        background-color: #ecf0f1; /* Light blue background for the content area */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th  {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
        background-color: #3498db; /* Light blue background for table headers and cells */
        color: #fff; /* White text color */
    }
    td {
        border: 1px solid #3498db;
        padding: 12px;
        text-align: left;
       /* Light blue background for table headers and cells */
        color: #000000; /* White text color */
    }

    .delete-button {
        background-color: #f1c40f; /* Yellow background for delete button */
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
    }

    .delete-button:hover {
        background-color: #e74c3c; /* Darker red background on hover */
    }

    .edit-field {
        border: none;
        padding: 8px 12px;
        width: 80%;
        box-sizing: border-box;
    }

    #searchBar {
        margin-bottom: 20px;
        padding: 10px;
        width: 80%;
        font-size: 16px;
        border: 1px solid #3498db;
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* Additional Styles for Dashboard Links */
    #dashboard a {
        color: #fff; /* White text color for links */
        text-decoration: underline; /* Underline for links */
        font-size: 18px; /* Larger font size for links */
    }
</style>


</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <div id="dashboard">
        <nav>
            <!-- Navigation links for different sections of the dashboard -->
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="categories.php">Gestion des Categories</a></li> <!-- Updated link for Categories -->
                <li><a href="#">Users</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>

        <div id="content">
            <!-- Barre de recherche -->
            <input type="text" id="searchBar" placeholder="Search by name" oninput="filterTable()">

            <table id="dataTable">
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Numero</th>
                    <th>Societe</th>
                    <th>Matricule</th>
                    <th>Pays</th>
                    <th>Region</th>
                    <th>Postcode</th>
                    <th>Categories</th>
                    <th>Actions</th>
                </tr>
                <?php
                foreach ($dolce as $ligne) {
                    echo '<tr>';
                    echo '<td contenteditable="true">' . $ligne['id_mac'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['nom'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['email'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['numero'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['societe'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['matricule'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['pays'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['region'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['Postcode'] . '</td>';
                    echo '<td contenteditable="true">' . $ligne['categorie_id'] . '</td>';
                    echo '<td>';
                    echo '<form method="post" onsubmit="return confirm(\'Are you sure you want to delete?\');">';
                    echo '<input type="hidden" name="delete_id" value="' . $ligne['id_mac'] . '">';
                    echo '<button type="submit" class="delete-button">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>

