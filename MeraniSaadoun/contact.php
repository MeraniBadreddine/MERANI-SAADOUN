<?php
@include 'configg.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the database
    $query = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Retrieve data from the database
$query = "SELECT * FROM contact_form";
$result = mysqli_query($conn, $query);

 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous Contacter</title>

    <style>
    body {
      background-color: #f1f1f1;
      font-family: Arial, sans-serif;
      background: url("bookk.jpg") no-repeat center center fixed;
      background-size: cover;
      margin: 0;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .contact-card {
      width: 400px;
      padding: 40px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .contact-form {
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 16px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    button[type="submit"] {
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

    button[type="submit"]:hover {
      background-color: #ff5500;
    }

    .back-link {
      text-align: center;
      font-size: 14px;
      color: #555;
    }

    .back-link a {
      color: #ff7200;
      text-decoration: none;
    }

    .back-link a:hover {
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

    <div class="container">
        <div class="contact-card">
            <h2>Nous Contacter</h2>
            <form class="contact-form" action="" method="post">
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" placeholder="Entrez votre nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Entrez votre message" required></textarea>
                </div>
                <button type="submit">Envoyer</button>
            </form>
            <p class="back-link">Retour à la <a href="home.html">page d'accueil</a></p>
        </div>
    </div>
</body>

</html>
