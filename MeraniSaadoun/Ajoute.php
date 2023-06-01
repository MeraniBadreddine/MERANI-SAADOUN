<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['user_name'])) {
   // User is not logged in, redirect to the login page
   header('Location: login_form.php');
   exit;
}

// Include your database connection file (configg.php)
@include 'configg.php';

// Retrieve form data
$type = isset($_POST['type']) ? $_POST['type'] : '';

// Check the selected type and retrieve additional form data accordingly
if ($type === "livre-scolaire") {
    $niveauScolaire = isset($_POST['niveau-scolaire']) ? $_POST['niveau-scolaire'] : '';
    $anneeScolaire = isset($_POST['annee-scolaire']) ? $_POST['annee-scolaire'] : '';
    $matiere = isset($_POST['matiere']) ? $_POST['matiere'] : '';
    $etatS = isset($_POST['etat-s']) ? $_POST['etat-s'] : '';
    $categorie = '';
    $imageS = $_FILES['image-s']['name'];
    $phoneNumberS = isset($_POST['phone-number-s']) ? $_POST['phone-number-s'] : '';
    // Move the uploaded file to a desired location
    move_uploaded_file($_FILES['image-s']['tmp_name'], "uploads/" . $imageS);

    // Prepare and execute the SQL statement for inserting into the book table
    $stmt = $conn->prepare("INSERT INTO book (id, type, niveau_scolaire, annee_scolaire, matiere, etat, categorie, image, phone_number, user_form_email) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $type, $niveauScolaire, $anneeScolaire, $matiere, $etatS, $categorie, $imageS, $phoneNumberS, $_SESSION['user_form_email']);
    $stmt->execute();

    // Check for errors
    if ($stmt->affected_rows > 0) {
      $bookId = $stmt->insert_id; // Get the book_id of the inserted book

  
      // Insert into the user_books table
      $userFormEmail = $_SESSION['user_form_email'];
      $userBooksStmt = $conn->prepare("INSERT INTO user_books (user_form_email, book_id) VALUES (?, ?)");
      $userBooksStmt->bind_param("si", $userFormEmail, $bookId);
      $userBooksStmt->execute();
  
      if ($userBooksStmt->affected_rows > 0) {
          echo "Livre ajouté avec succès et associé à l'utilisateur : " . $_SESSION['user_form_email'];
      } else {
          echo "Erreur lors de l'ajout du livre dans la table user_books : " . $userBooksStmt->error;
      }
  
      $userBooksStmt->close();
  } 
  
  else {
      echo "Erreur lors de l'ajout du livre : " . $stmt->error;
  }

    $stmt->close();
  } elseif ($type === "livre-non-scolaire") {
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $etat = isset($_POST['etat']) ? $_POST['etat'] : '';
    $niveauScolaire = '';
    $anneeScolaire = '';

    $matiere = '';
    $image = $_FILES['image']['name'];
    $phoneNumber = isset($_POST['phone-number']) ? $_POST['phone-number'] : '';

    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);

    // Prepare and execute the SQL statement for inserting into the book table
    $stmt = $conn->prepare("INSERT INTO book (id, type, niveau_scolaire, annee_scolaire, matiere, etat, categorie, image, phone_number, user_form_email) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $type, $niveauScolaire, $anneeScolaire, $matiere, $etat, $categorie, $image, $phoneNumber, $_SESSION['user_form_email']);
    $stmt->execute();

    // Check for errors 
    if ($stmt->affected_rows > 0) {
      $bookId = $stmt->insert_id; // Get the book_id of the inserted book

  
      // Insert into the user_books table
      $userFormEmail = $_SESSION['user_form_email'];
      $userBooksStmt = $conn->prepare("INSERT INTO user_books (user_form_email, book_id) VALUES (?, ?)");
      $userBooksStmt->bind_param("si", $userFormEmail, $bookId);
      $userBooksStmt->execute();
  
      if ($userBooksStmt->affected_rows > 0) {
          echo "Livre ajouté avec succès et associé à l'utilisateur : " . $_SESSION['user_form_email'];
      } else {
          echo "Erreur lors de l'ajout du livre dans la table user_books : " . $userBooksStmt->error;
      }
  
      $userBooksStmt->close();
  } 
   else {
        echo "Erreur lors de l'ajout du livre : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un livre à échanger</title>

  <style>
    * {
     box-sizing: border-box;
     font-family: Arial, sans-serif;
   }
   body {
     background: url("bookk.jpg") no-repeat center center fixed; 
     background-size: cover;
     margin: 0;
   }
   h1 {
     font-size: 32px;
     text-align: center;
     margin-top: 50px;
     color: #ff7200;
   }
   form {
     display: flex;
     flex-direction: column;
     align-items: center;
     justify-content: center;
     margin: 20px auto;
     width: 50%;
     background-color: #f0f0f0;
     padding: 20px;
     border-radius: 10px;
     box-shadow: 0 0 1rem rgba(0, 0, 0, 0.2);
   }
   label {
     font-size: 20px;
     margin-bottom: 10px;
     color: #333;
   }
   select, input[type="submit"] {
     font-size: 20px;
     padding: 10px;
     margin-bottom: 20px;
     width: 100%;
     border-radius: 5px;
     border: none;
     background-color: #fff;
     color: #333;
   }
   input[type="submit"] {
     font-size: 24px;
     padding: 10px 20px;
     background-color: #ff7200;
     color: #fff;
     cursor: pointer;
     transition: all 0.3s ease;
   }
   input[type="submit"]:hover {
     background-color: #ff5500;
   }
   #livre-non-scolaire-fields,
   #livre-scolaire-fields,
    {
     display: none;
   }

   /* Style for image upload button */
   input[type="file"] {
     display: none;
   }

   .upload-btn {
     background-color: #fff;
     border: 1px solid #ccc;
     color: #333;
     font-size: 20px;
     padding: 10px;
     width: 100%;
     border-radius: 5px;
     text-align: center;
     cursor: pointer;
     transition: all 0.3s ease;
   }

   .upload-btn:hover {
     background-color: #f5f5f5;
   }

   .file-name {
     margin: 10px 0;
     font-size: 16px;
     color: #333;
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

  .phone-input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.phone-input:focus {
  outline: none;
  border-color: #3498db;
  box-shadow: 0 0 5px #3498db;
}


 </style>
</head>
<body>
  <br>
  <button onclick="goToHomepage()">Page d'accueil</button>

  <script>
    function goToHomepage()
    {
  window.location.href = "home.html";
}
  </script>

<h1>Ajouter des livres</h1><br>
<form name="livre-form" method="POST" enctype="multipart/form-data">
  <label for="type">Type de transaction :</label>
  <select id="type" name="type" onchange="showFields()">
    <option value="">--Choisir--</option>
    <option value="livre-scolaire">livre scolaire</option>
    <option value="livre-non-scolaire">livre non scolaire</option>
  </select>

  <?php
    if (isset($error)) {
      foreach ($error as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
      };
    };
    ?>

  <div id="livre-scolaire-fields" style="display:none">
    <label for="niveau-scolaire">Cursus :</label>
    <select id="niveau-scolaire" name="niveau-scolaire">
      <option value="">--Choisir--</option>
      <option value="primaire">Primaire</option>
      <option value="moyenne">Moyenne</option>
      <option value="secondaire">Secondaire</option>
    </select>
    <br>


    <label for="annee-scolaire">Niveau :</label>
    <select id="annee-scolaire" name="annee-scolaire">
      <option value="">--Choisir--</option>
      <option value="première">Première</option>
      <option value="deuxième">Deuxième</option>
      <option value="troisième">Troisième</option>
      <option value="quatrième">Quatrième</option>
      <option value="cinquième">Cinquième</option>

    </select>
    <br>

  
  
    <label for="matiere">Matière :</label>
    <select id="matiere" name="matiere">
      <option value="">--Choisir--</option>
    </select>
    <br>
  
    <label for="etat-s">État :</label>
    <select id="etat-s" name="etat-s">
      <option value="">--Choisir--</option>
      <option value="neuf">Neuf</option>
      <option value="bon">Bon</option>
    </select>
    <br>

    <label for="phone-number-s">Phone Number:</label>
<input type="text" name="phone-number-s" id="phone-number-s">

<br><br>

  
    <label for="image-s">Image de couverture</label>
    <input type="file" id="image-s" name="image-s" accept="image/*">
    <br>
  </div>

  <div id="livre-non-scolaire-fields" style="display:none">
    <br>
    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie">
      <option value="">--Choisir--</option>
      <option value="roman">Roman</option>
      <option value="Poésie">Poésie</option>
      <option value="histoire">Histoire</option>
      <option value="cuisine">Cuisine</option>
      <option value="voyage">Voyage</option>
      <option value="art">Art</option>
      <option value="Biographie / Autobiographie">Biographie / Autobiographie</option>
      <option value="Policier / thriller">Policier / thriller</option>
    </select>
    <br>
    <label for="etat">État :</label>
    <select id="etat" name="etat">
      <option value="">--Choisir--</option>
      <option value="neuf">Neuf</option>
      <option value="bon">Bon</option>
    </select>

    <label for="phone-number">Phone Number:</label>
<input type="text" name="phone-number" id="phone-number">

<br><br>

    <label for="image">Image de couverture</label>
    <input type="file" id="image" name="image" accept="image/*">
    <br>
  </div>

  <br>
  <input type="submit" value="Ajouter">
</form>

<script>
  var niveauSelect = document.getElementById('niveau-scolaire');
  var matiereSelect = document.getElementById('matiere');

  niveauSelect.addEventListener('change', function() {
    matiereSelect.innerHTML = '';

    if (niveauSelect.value === 'primaire') {
      addOption('--Choisir--', '--Choisir--');
      addOption('arabe', 'Arabe');
      addOption('mathematiques',      'Mathématiques');
      addOption('islamique', 'Islamique');
      addOption('francais', 'Français');
      addOption('anglais', 'Anglais');
      addOption('histoire', 'Histoire');
    } else if (niveauSelect.value === 'moyenne') {
      addOption('--Choisir--', '--Choisir--');
      addOption('arabe', 'Arabe');
      addOption('mathematiques', 'Mathématiques');
      addOption('islamique', 'Islamique');
      addOption('francais', 'Français');
      addOption('anglais', 'Anglais');
      addOption('histoire', 'Histoire');
      addOption('geographie', 'Géographie');
      addOption('science', 'Science');
      addOption('physique', 'Physique');
    }else if (niveauSelect.value === 'secondaire') {
      addOption('--Choisir--', '--Choisir--');      
      addOption('arabe', 'Arabe');
      addOption('mathematiques', 'Mathématiques');
      addOption('islamique', 'Islamique');
      addOption('francais', 'Français');
      addOption('anglais', 'Anglais');
      addOption('histoire', 'Histoire');
      addOption('geographie', 'Géographie');
      addOption('science', 'Science');
      addOption('physique', 'Physique');
      addOption('philosophique', 'Philosophique');

    }

    // Helper function to add options
    function addOption(value, text) {
      var option = document.createElement('option');
      option.value = value;
      option.text = text;
      matiereSelect.add(option);
    }
  });

  var niveauSelect = document.getElementById('niveau-scolaire');
  var anneeSelect = document.getElementById('annee-scolaire');

  niveauSelect.addEventListener('change', function() {
    anneeSelect.innerHTML = '';

    if (niveauSelect.value === 'primaire') {
      addOption('--Choisir--', '--Choisir--');
      addOption('première', 'Première');
      addOption('deuxième',      'Deuxième');
      addOption('troisième', 'Troisième');
      addOption('quatrième', 'Quatrième');
      addOption('cinquième', 'Cinquième');

      

    } else if (niveauSelect.value === 'moyenne') {
      addOption('--Choisir--', '--Choisir--');
      addOption('première', 'Première');
      addOption('deuxième', 'Deuxième');
      addOption('troisième', 'Troisième');
      addOption('quatrième', 'Quatrième');

      
      
    }else if (niveauSelect.value === 'secondaire') {
      addOption('--Choisir--', '--Choisir--');      
      addOption('première', 'Première');
      addOption('deuxième', 'Deuxième');
      addOption('troisième', 'Troisième');
      
      

    }

    // Helper function to add options
    function addOption(value, text) {
      var option = document.createElement('option');
      option.value = value;
      option.text = text;
      anneeSelect.add(option);
    }
  });



  function showFields() {
    var selectElement = document.getElementById('type');
    var livreScolaireFields = document.getElementById('livre-scolaire-fields');
    var livreNonScolaireFields = document.getElementById('livre-non-scolaire-fields');

    livreScolaireFields.style.display = 'none';
    livreNonScolaireFields.style.display = 'none';

    if (selectElement.value === 'livre-scolaire') {
      livreScolaireFields.style.display = 'block';
    } else if (selectElement.value === 'livre-non-scolaire') {
      livreNonScolaireFields.style.display = 'block';
    }
  }
</script>
</body>
</html>
