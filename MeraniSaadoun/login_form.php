<?php

@include 'configg.php';

session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$password' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="refresh" content="60">
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <style>

body {
      background-image: url("bookk.jpg");
      background-size: cover;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
body {
  background-color: #f1f1f1;
  font-family: Arial, sans-serif;
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
  text-align: center;
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
      <form action="" method="post">
         <h3>Connexion</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="entrez votre email">
         <input type="password" name="password" required placeholder="entrez votre mot de passe">
         <input type="submit" name="submit" value="Se connecter" class="form-btn">
         <p>Pas encore de compte ? <a href="register_form.php">S'inscrire</a></p>
      </form>
   </div>

</body>

</html>