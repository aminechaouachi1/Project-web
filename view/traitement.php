
<?php
include 'config.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $numero = htmlspecialchars($_POST['numero']);
    $societe = isset($_POST['societe']) ? htmlspecialchars($_POST['societe']) : '';
    $matricule = htmlspecialchars($_POST['matricule']);
    $pays = htmlspecialchars($_POST['pays']);
    $region = htmlspecialchars($_POST['region']);
    $postcode = htmlspecialchars($_POST['Postcode']);
    $categories = htmlspecialchars($_POST['categories']);

    // Assurez-vous de mettre à jour la requête SQL pour inclure toutes les colonnes nécessaires
    $stmt = $conn->prepare("INSERT INTO mac (nom, email, numero, societe, matricule, pays, region, postcode, categories) VALUES (:nom, :email, :numero, :societe, :matricule, :pays, :region, :postcode, :categories)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':societe', $societe);
    $stmt->bindParam(':matricule', $matricule);
    $stmt->bindParam(':pays', $pays);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':postcode', $postcode);
    $stmt->bindParam(':categories', $categories);

    if ($stmt->execute()) {
        // Affichez le message avec JavaScript
        echo '<script>alert("Votre don est confirmé. Merci pour votre confiance. Nous vous contacterons le plus tôt possible.");</script>';
        
        // Redirigez après un court délai
        echo '<script>setTimeout(function(){ window.location.href = "traitement.php"; }, 3000);</script>';
        exit();
    } else {
        // Gérer les erreurs d'insertion ici
        echo "Erreur lors de l'insertion dans la base de données.";
    }
    
    header('Location: traitement.php');
}
?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos actions</title>

    <link rel="stylesheet" href="style.css">
    <style>
        .btn {
            text-align: center;
            margin-top: 20px;
        }

        .btn input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 18px 50px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
    <div class="menu">
        <a href="/page publication/accueil.php">Accueil</a>
        <a href="#publications">Nos publications</a>
        <a href="/Page boutique/Boutique.php">Notre Boutique</a>
        <a href="/Page d'actions/actions.php">Nos actions</a>
    </div>
</head>

<body>
    <div class="imageprincipale">
        <a href="#">
            <img src="Sources\325419967_696149255327245_880955397294937651_n.jpg" alt="facebook">
        </a>
    </div>
    <div class="rectanglecover">
        <h1>Le Blog Des Dons</h1>
    </div>
    <div class="logo"> <img src="Sources\LOGO.png" alt="Logo"> </div>
    <div class="btn_admin">
        <a href="/connexion/connexion.php">Se connecter en tant qu'admin</a>
    </div>
    <div id="prestations">
        <div class="imagesprestations ">
            <h2>Partager vos publications et rejoindre notre famille </h2>
            <div class="center-container">
                <header>Detail du Donnateur</header>
                <form id="registrationForm" method="POST" action="">
                    <div class="form first">
                        <div class="detail personal">
                            <span class="title"></span>
                            <div class="fields">
                                <div class="input-field">
                                    <label for="nom">Nom complet</label>
                                    <input type="text" name="nom" placeholder="enter your name" id="nom">
                                    <span id="nomError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="email">Adresse email</label>
                                    <input type="email" name="email" placeholder="enter your email" id="email">
                                    <span id="emailError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="numero">Numero</label>
                                    <input type="number" name="numero" placeholder="enter your phone number" id="numero">
                                    <span id="numeroError" style="color: red;"></span>
                                </div>
                                <div class="input-field">
                                    <label for="societe">Nom de la société</label>
                                    <input type="text" name="societe" placeholder="enter your company name" id="societe">
                                </div>
                                <div class="input-field">
                                    <label for="matricule">Matricule de la société</label>
                                    <input type="text" name="matricule" placeholder="enter your company registration number" id="matricule">
                                </div>
                                <div class="input-field">
                                    <label for="pays">Pays</label>
                                    <input type="text" name="pays" placeholder="enter your country" id="pays">
                                </div>
                                <div class="input-field">
                                    <label for="region">Région</label>
                                    <input type="text" name="region" placeholder="enter your region" id="region">
                                </div>
                                <div class="input-field">
                                    <label for="Postcode">Postcode</label>
                                    <input type="text" name="Postcode" placeholder="enter your Postcode" id="Postcode">
                                </div>
                                <div class="input-field">
                                    <label for="categories">Categories</label>
                                    <input type="text" name="categories" placeholder="argent/nourriture/habits/fourniture" id="categories">
                                    <span id="categoriesError" style="color: red;"></span>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="btn">
                        <input type="submit" value="valider" name="ok" id="submitButton">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button id="scrollToTopBtn">↑</button>
    <script src="accueil.js"></script>
    <script src="action.js"></script>
    <script src="connexion.js"></script>
    <script>
        document.getElementById("registrationForm").addEventListener("submit", function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Empêche l'envoi du formulaire si la validation échoue
            }
        });

        function validateForm() {
            var nom = document.getElementById("nom").value;
            var email = document.getElementById("email").value;
            var numero = document.getElementById("numero").value;
            var categories = document.getElementById("categories").value;

            var isValid = true;

            // Validation pour le numéro de téléphone ne dépassant pas 8 chiffres
            if (numero.length > 8) {
                document.getElementById("numeroError").innerHTML = "Le numéro ne peut pas dépasser 8 chiffres";
                isValid = false;
            } else {
                document.getElementById("numeroError").innerHTML = "";
            }

            // Validation de l'e-mail
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById("emailError").innerHTML = "Veuillez entrer une adresse e-mail valide";
                isValid = false;
            } else {
                document.getElementById("emailError").innerHTML = "";
            }

            // Validation du champ nom
            if (nom.trim() === "") {
                document.getElementById("nomError").innerHTML = "Veuillez entrer votre nom";
                isValid = false;
            } else {
                document.getElementById("nomError").innerHTML = "";
            }

            // Validation du champ categories
            if (!categories.match(/^(argent|nourriture|habits|fourniture)$/)) {
                document.getElementById("categoriesError").innerHTML = "Veuillez choisir une catégorie valide";
                isValid = false;
            } else {
                document.getElementById("categoriesError").innerHTML = "";
            }

            return isValid; // Si toutes les validations réussissent
        }
    </script>
    <div class="sidebarannonce">
        <a href="/connexion/connexion.php">Ajouter une Reclammation </a>
    </div>
</body>

</html>
