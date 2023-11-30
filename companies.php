<?php
include 'ConnexionBD.php';

// Si la requête est de type POST, c'est-à-dire si le formulaire de suppression est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_company'])) {
    $companyIdToDelete = $_POST['delete_company'];

    // Utiliser une requête préparée pour éviter les injections SQL
    $stmtDeleteCompany = $conn->prepare("DELETE FROM société WHERE ID_Soc = :companyId");
    $stmtDeleteCompany->bindParam(':companyId', $companyIdToDelete, PDO::PARAM_INT);

    // Exécuter la requête de suppression
    if ($stmtDeleteCompany->execute()) {
        // Rediriger vers la même page après la suppression
        header("Location: companies.php");
        exit();
    } else {
        // Gérer l'échec de la suppression, par exemple, afficher un message d'erreur
        echo "Failed to delete company.";
    }
}

// Récupérer la liste des entreprises après la suppression
$stmtSociete = $conn->prepare("SELECT s.*, o.Nom_Org AS Nom_Association FROM société s LEFT JOIN organisations o ON s.organisation_aff = o.ID_Organisation");
$stmtSociete->execute();
$rowsSociete = $stmtSociete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies List</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- You can keep your custom styles in a separate file -->
    <!-- Add Font Awesome CSS link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<div class="logo"> <img src="Sources/LOGO.png" alt="Logo"> </div>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="Consulter_profil.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="associations.php">
                            Associations
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
<div class="container">
    <h1 class="mt-4">Sociétés</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Matricule</th>
                <th>Organisation affiliée</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rowsSociete as $row) : ?>
                <tr>
                    <td><?= $row['Nom_Soc'] ?></td>
                    <td><?= $row['Desc_Soc'] ?></td>
                    <td><?= $row['matricule'] ?></td>
                    <td><?= $row['Nom_Association'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_company" value="<?= $row['ID_Soc'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
#sidebar {
            position: fixed;
            top: 200px;
            left: 0;
            height: 100%;
            width: 260px;
            z-index: 1;
            background-color: #f8f9fa; /* Bootstrap default background color */
            padding-top: 20px;
            padding-right: 10px;
            overflow-x: hidden;
        }

        #sidebar a {
            text-decoration: none;
            color: #495057; /* Bootstrap default text color */
        }

        #sidebar .nav-link {
            padding: 8px 15px;
            font-size: 16px;
        }

        #sidebar .nav-link:hover {
            background-color: #007bff; /* Bootstrap primary color */
            color: #fff;
        }

        #sidebar .active {
            background-color: #007bff;
            color: #fff;
        }

        /* Content Styles */
        .container {
            margin-top: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #sidebar {
                position: relative;
                width: 100%;
                margin-bottom: 20px;
                height: auto;
                padding: 10px;
            }

            #sidebar a {
                text-align: center;
            }
        }
        .logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 180px;
    height: 180px;
    background-color: #D7B20B;
    border-radius: 50%;
    border :1px solid #000000;
    position: fixed;
    top: 20px;
    left: 20px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    z-index: 3;
}

.logo img {
    width: 150px;
    height: 70px;
}
    </style>
</body>
</html>

