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
        $deleteStatement = $conn->prepare('DELETE FROM mac WHERE id = :id');
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
    <title>Gestion de Montants</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        th {
            border: 2px solid #3498db;
            padding: 12px;
            text-align: left;
            background-color: #f1c40f;
            color: #fff;
        }

        td {
            border: 2px solid #3498db;
            padding: 12px;
            text-align: left;
            position: relative;
            border-width: 3px; /* Épaisseur de la bordure */
        }

        .delete-button {
            background-color: #f1c40f;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .edit-field {
            border: none;
            padding: 8px 12px;
            width: 80%;
            box-sizing: border-box;
        }

        .edit-field:focus {
            outline: none;
            border: 1px solid #3498db;
        }

        #searchBar {
            margin-bottom: 20px;
            padding: 10px;
            width: 300px; /* Set the width as desired */
            font-size: 16px;
            border: 1px solid #3498db;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <h2>Gestion de Montants</h2>

    <!-- Barre de recherche -->
    <input type="text" id="searchBar" placeholder="Rechercher par nom" oninput="filterTable()">

    <table id="dataTable">
        <tr>
             <th> id</th>
            <th> nom </th>
            <th> email </th>
            <th> numero </th>
            <th> societe</th>
            <th> matricule </th>
            <th> pays </th>
            <th> region </th>
            <th> postcode </th>
            <th> categories</th>
            <th> Actions </th>
        </tr>
<?php
        foreach ($dolce as $ligne) {
            echo '<tr>';
            echo '<td contenteditable="true">' . $ligne['id'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['nom'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['email'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['numero'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['societe'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['matricule'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['pays'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['region'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['Postcode'] . '</td>';
            echo '<td contenteditable="true">' . $ligne['categories'] . '</td>';
            echo '<td>';
            echo '<form method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer?\');">';
            echo '<input type="hidden" name="delete_id" value="' . $ligne['id'] . '">';
            echo '<button type="submit" class="delete-button">Supprimer</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
            ?>
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

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Assuming the name is in the first column
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
