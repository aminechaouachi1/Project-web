<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/signup</title>
    <link rel="stylesheet" href="../Page d'accueil/accueil.css">
    <link rel="stylesheet" href="../Page d'actions/actions.css">
    <link rel="stylesheet" href="../connexion/connexion.css">
    <div class="menu">
        <a href="../Page d'accueil/accueil.php">Accueil</a>
        <a href="../Page d'accueil/accueil.php#a_propos">A propos</a>
        <a href="../Page boutique/Boutique.php">Notre Boutique</a>
        <a href="../Page d'actions/actions.php">Nos actions</a>
    </div>
    <body>
    <div class="logo"> <img src="../Sources/LOGO.png" alt="Logo"> </div>
    
    <!-- <div class="btn_admin">
        <a href="../connexion/connexion.html">Se connecter en tant qu'admin</a>
    </div> -->
    <title>Carte de Connexion/Inscription</title>
</head>
<body>

    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="../Sources/2.jpg" alt="Image 2">
        </div>
        <div class="mySlides fade">
            <img src="../Sources/3.jpg" alt="Image 3">
        </div>
        <div class="mySlides fade">
            <img src="../Sources/4.jpg" alt="Image 3">
        </div>
        <div class="mySlides fade">
            <img src="../Sources/5.jpg" alt="Image 3">
        </div>
    </div>
    <div class="sidebar">
        <a href="#">
        <img src="../Sources/icons/facebook1.png" alt="facebook">
    </a>
    <a href="#">
        <img src="../Sources/icons/instagramm.png" alt="Instagram">
    </a>
        <a href="#">
        <img src="../Sources/icons/linkedin.png" alt="linkedin">
    </a>
        <a href="#">
        <img src="../Sources/icons/whatsapp.png" alt="whatsapp">
    </a>
    </div>
    <div class="card-container">
        <div class="card">
            <div class="face front">
                <h2>Connexion</h2>
                <form id="login-form">
                    <input type="text" placeholder="Nom d'utilisateur">
                    <input type="password" placeholder="Mot de passe">
                    <button>
                    <a href="../formulaire organismes/index.php">Se connecter</a>
                    </button>
                </form>
                <p>Vous n'avez pas de compte ? <a href="#" id="switchToSignup">S'inscrire</a></p>
            </div>
            <div class="face back">
                <h2>Inscription</h2>
                <form id="signup-form">
                    <input type="text" placeholder="Nom d'utilisateur">
                    <input type="email" placeholder="E-mail">
                    <input type="password" placeholder="Mot de passe">
                    <button>
                    <a href="../formulaire organismes/index.php">S'inscrire</a>
                    </button>
                </form>
                <p>Déjà un compte ? <a href="#" id="switchToLogin">Se connecter</a></p>
            </div>
        </div>
    </div>
</html>

<script src="accueil.js"></script>
<script src="action.js"></script>
<script src="connexion.js"></script>
</body>
</head>