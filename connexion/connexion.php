<?php
    // Lampirkan db dan User
    require_once "db.php";
    require_once "User.php";

    // Buat object user
    $user = new User($db);

    // Jika sudah login
    if ($user->isLoggedIn()) {
        header("location: index.php"); // Redirect ke index
    }

    // Jika ada data dikirim
    if (isset($_POST['kirim'])) {
        // Check if the form is for login or registration
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Proses login user
            if ($user->login($email, $password)) {
                header("location: index.php");
            } else {
                // Jika login gagal, ambil pesan error
                $error = $user->getLastError();
            }
        } elseif (isset($_POST['register'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Registrasi user baru
            if ($user->register($name, $email, $password)) {
                // Jika berhasil set variable success ke true
                $success = true;
            } else {
                // Jika gagal, ambil pesan error
                $error = $user->getLastError();
            }
        }
    }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login" role="tabpanel">
                            <h2 class="text-center">Connexion</h2>
                            <form class="login-form" method="post">
                    <?php if (isset($error)): ?>
                        <div class="error">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <input type="email" name="email" placeholder="Email" required /><br>
                    <input type="password" name="password" placeholder="Mot de passe" required /><br>
                    <div class="form-group">
                                    <button type="submit" name="kirim" value="login" class="btn btn-primary btn-block">Se connecter</button>
                                </div>
                </form>
                <p class="text-center">Vous n'avez pas de compte ? <a href="#signup" data-toggle="tab">S'inscrire</a></p>
            </div>
            <div class="tab-pane fade" id="signup" role="tabpanel">
                            <h2 class="text-center">Inscription</h2>
                            <form class="register-form" method="post">
                    <?php if (isset($error)): ?>
                        <div class="error">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="success">
                            User created  <a href="login.php"> success</a>
                        </div>
                    <?php endif; ?>
                    <input type="text" name="name" placeholder="Nom" required /><br>
                    <input type="email" name="email" placeholder="Email" required /><br>
                    <input type="password" name="password" placeholder="Mot de passe" required /><br>
                    <div class="form-group">
                                    <button type="submit" name="kirim" value="register" class="btn btn-success btn-block">S'inscrire</button>
                                </div>
                </form>
                <p class="text-center">Déjà un compte ? <a href="#login" data-toggle="tab">Se connecter</a></p>
            </div>
        </div>
        </div>
    </div>
</div>
 </div>
</html>

<script src="accueil.js"></script>
<script src="action.js"></script>
<script src="connexion.js"></script>
</body>
</head>