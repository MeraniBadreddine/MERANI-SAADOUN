<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
   header('Location: login_form.php');
   exit;
}

// Récupérer les informations de l'utilisateur depuis la session
$userName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : $_SESSION['user_name'];

@include 'configg.php';

$select = "SELECT * FROM user_form WHERE name = '$userName'";
$result = mysqli_query($conn, $select);

if ($result && mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   $name = $row['name'];
   $email = $row['email'];
   $userType = $row['user_type'];
} else {
   $errorMessage = "Impossible de récupérer le profil de l'utilisateur.";
   
}

// Fonctionnalité de déconnexion
if (isset($_POST['logout'])) {
   session_destroy();
   header('Location: login_form.php');
   exit;
}

// Mettre à jour les informations de l'utilisateur
if (isset($_POST['update'])) {
   $newName = mysqli_real_escape_string($conn, $_POST['new_name']);
   $newEmail = mysqli_real_escape_string($conn, $_POST['new_email']);
   $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);

   $update = "UPDATE user_form SET name = '$newName', email = '$newEmail', password = '$newPassword' WHERE name = '$userName'";
   $updateResult = mysqli_query($conn, $update);

   if ($updateResult) {
      $_SESSION['admin_name'] = $newName; 
      $_SESSION['user_name'] = $newName; 
      $successMessage = "Profil mis à jour avec succès.";
   } else {
      $errorMessage = "Échec de la mise à jour du profil.";
   }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil</title>
   <style>
      body {
         background-color: #f1f1f1;
         font-family: Arial, sans-serif;
         background: url("bookk.jpg") no-repeat center center fixed;
         background-size: cover;
         margin: 0;
      }

      .form-container {
         max-width: 400px;
         margin: 0 auto;
         padding: 40px;
         background-color: #fff;
         border-radius: 10px;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }

      h3 {
         text-align: center;
         margin-bottom: 30px;
         color: #333;
      }

      .error-msg {
         display: block;
         margin-bottom: 10px;
         color: red;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"],
      select {
         display: block;
         width: 100%;
         padding: 12px;
         margin-bottom: 20px;
         border: 1px solid #ccc;
         border-radius: 5px;
         font-size: 16px;
      }

      .form-btn {
         display: block;
         width: 100%;
         padding: 12px;
         background-color: #ff7200;
         color: #fff;
         border: none;
         border-radius: 5px;
         font-size: 16px;
         font-weight: bold;
         cursor: pointer;
      }

      .form-btn:hover {
         background-color: #ff5500;
      }

      p {
         text-align: ;
         margin-top: 20px;
         font-size: 14px;
         color: #555;
      }

      p a {
         color: #ff7200;
         text-decoration: none;
      }

      p a:hover {
         text-decoration: underline;
      }

      button {
         display: inline-block;
         padding: 10px 20px;
         background-color: #ff7200;
         color: #fff;
         font-size: 16px;
         font-weight: bold;
         text-decoration: none;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         transition: background-color 0.3s ease;
         border-radius: 50px;
      }

      button:hover {
         background-color: #ff5500;
      }
   </style>
</head>

<body>
   <br>
   <button onclick="goToHomepage()">Page d'accueil</button>

   <script>
      function goToHomepage() {
         window.location.href = "home.html";
      }
   </script>
   <div class="form-container">
      <h3>Profil</h3>
      <?php if (isset($errorMessage)) : ?>
         <p class="error-msg"><?php echo $errorMessage; ?></p>
      <?php elseif (isset($successMessage)) : ?>
         <p class="success-msg"><?php echo $successMessage; ?></p>
      <?php else : ?>
         <p>Nom : <?php echo $name; ?></p>
         <p>Email : <?php echo $email; ?></p><br>
         <form method="post" class="update-form">

            <input type="text" name="new_name" id="new_name" required placeholder="Entrez votre nouveau nom">
            <input type="email" name="new_email" id="new_email" required placeholder="Entrez votre nouvel email">
            <input type="password" name="new_password" id="new_password" required placeholder="Entrez votre nouveau mot de passe">

            <button type="submit" name="update" class="form-btn">Mettre à jour</button>
         </form> <br>
         <form method="post" action="logout.php">
            <button type="submit" name="logout" class="form-btn">Déconnexion</button>
         </form>
      <?php endif; ?>
   </div>
</body>

</html>
