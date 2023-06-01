<?php
@include 'configg.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the "book" table
$sql = "SELECT * FROM book";
$result = $conn->query($sql);

// Prepare the liveData array
$liveData = array();

if ($result->num_rows > 0) {
    // Iterate over the rows and populate the liveData array
    while ($row = $result->fetch_assoc()) {
        $liveData[] = array(
            'id' => $row['id'],
            'type' => $row['type'],
            'niveau_scolaire' => $row['niveau_scolaire'],
            'annee_scolaire' => $row['annee_scolaire'],
            'matiere' => $row['matiere'],
            'etat' => $row['etat'],
            'categorie' => $row['categorie'],
            'image' => $row['image'],
            'phone_number' => $row['phone_number'],
            'name' => $row['name'],
            'email' => $row['email'],
        );
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST['type'];
    $niveau_scolaire = $_POST['niveau_scolaire'];
    $annee_scolaire = $_POST['annee_scolaire'];
    $matiere = $_POST['matiere'];
    $etat = $_POST['etat'];
    $categorie = $_POST['categorie'];
    $image = $_POST['image'];
    $phone_number = $_POST['phone_number'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Insert the book record into the database
    $insertSql = "INSERT INTO book (type, niveau_scolaire, annee_scolaire, matiere, etat, categorie, image, phone_number, name, email)
                  VALUES ('$type', '$niveau_scolaire', '$annee_scolaire', '$matiere', '$etat', '$categorie', '$image', '$phone_number', '$name', '$email')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Book added successfully";
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Live Consultation</title>
 <style>
   body {
      background-image: url("bookk.jpg");
      background-size: cover;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
  
  .main-container {
  background-color: #f2f2f2;
  padding: 20px;
  border-radius: 5px;
}

.main-container h1 {
  font-size: 22px;
  margin-bottom: 20px;
}

.main-container label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
}

.main-container input[type="text"],
.main-container select {
  width: 80%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 5px;
  font-size: 14px;
}

.main-container select {
  appearance: none;
  -webkit-appearance: none;
  background: url('arrow.png') no-repeat right center;

  background-size: 16px 16px;
  padding-right: 30px;
}

.main-container button {
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
}

.main-container button:hover {
  background-color: #ff5500;
}


  
   body {
  font-family: Arial, sans-serif;
  background-color: #f8f8f8;
  margin: 0;
  padding: 0;
}

.main-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 10px;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
}

.filter-container {
  margin-bottom: 20px;
}

.filter-container label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
}

.filter-container input[type="text"],
.filter-container select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 20px;
  font-size: 14px;
}

.filter-container select {
  appearance: none;
  -webkit-appearance: none;
  background: url('arrow.png') no-repeat right center;
  background-size: 16px 16px;
  padding-right: 30px;
}

.button-container {
  margin-top: 20px;
}

.button-container button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #ff7200;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  text-decoration: none;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.button-container button:hover {
  background-color: #ff5500;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 30px;
}

table th,
table td {
  padding: 8px;
  border: 1px solid #ccc;
}

table th {
  background-color: #f2f2f2;
  font-weight: bold;
  text-align: left;
}

table tr:nth-child(even) {
  background-color: #f9f9f9;
}

table tr:hover {
  background-color: #e5e5e5;
}


th, td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

td img {
  width: 80px;
  height: 80px;
  object-fit: cover;
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
.filter-options {
    display: none;
  }

  .show {
    display: block;
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




  <div class="main-container">
    <h1>Live Consultation</h1>

    



    <div>
    <button onclick="toggleAllFilterOptions()"> Filter </button>
    <div id="filterOptions" class="filter-options">
      <label for="idFilter">ID:</label>
      <input type="text" id="idFilter">

      <label for="typeFilter">Type:</label>
      <select id="typeFilter">
        <option value="">--Choisir--</option>
        <option value="livre-scolaire">livre scolaire</option>
        <option value="livre-non-scolaire">livre non scolaire</option>
      </select>

      <label for="niveauFilter">Niveau Scolaire:</label>
      <select id="niveauFilter">
        <option value="">--Choisir--</option>
        <option value="primaire">Primaire</option>
        <option value="moyenne">Moyenne</option>
        <option value="secondaire">Secondaire</option>
      </select>

      <label for="anneeFilter">Année Scolaire:</label>
      <select id="anneeFilter">
        <option value="">--Choisir--</option>
        <option value="première">Première</option>
      <option value="deuxième">Deuxième</option>
      <option value="troisième">Troisième</option>
      <option value="quatrième">Quatrième</option>
      <option value="cinquième">Cinquième</option>
      </select>

      <label for="matiereFilter">Matiere:</label>
      <select id="matiereFilter">
        <option value="">--Choisir--</option> 
        <option value="arabe">Arabe</option>
        <option value="mathematiques">Mathematiques</option>
        <option value="islamique">Islamique</option>
        <option value="francais">Francais</option>
        <option value="anglais">Anglais</option>
        <option value="histoire">Histoire</option>
        <option value="geographie">Géographie</option>
        <option value="science">Science</option>
        <option value="physique">Physiquer</option>
        <option value="philosophique">Philosophique</option>   
      </select>

      <label for="etatFilter">Etat:</label>
      <select id="etatFilter">
        <option value="">--Choisir--</option>
        <option value="neuf">Neuf</option>
        <option value="bon">Bon </option>
      </select>

      <label for="categorieFilter">Categorie:</label>
      <select id="categorieFilter">
        <option value="">--Choisir--</option>
        <option value="roman">Roman</option>
        <option value="Poésie">Poésie</option>
        <option value="histoire">Histoire</option>
        <option value="cuisine">cuisine</option>
        <option value="voyage">voyage</option>
        <option value="art">art</option>
        <option value="Biographie / Autobiographie">Biographie / Autobiographie</option>
        <option value="Histoire">Histoire</option>
        <option value="Policier / thriller">Policier / thriller</option>
        <option value="art">art</option>
      </select>  <br><br>
      <button onclick="applyFilters()">Apply Filters</button> 
      <button onclick="resetFilters()">Reset Filters</button>   </div>
  
     </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Type</th>
          <th>Cursus Scolaire</th>
          <th>Niveau Scolaire</th>

          <th>Matiere</th>
          <th>Etat</th>
          <th>Categorie</th>
          <th>Image</th>
          <th>Numéro De Téléphone</th>
        </tr>
      </thead>
      <tbody id="liveItemsList">
      </tbody>
    </table>
  </div>


  


  <script>
  function toggleAllFilterOptions() {
    const filterOptions = document.getElementById('filterOptions');
    filterOptions.classList.toggle('show');
  }

  var liveData = <?php echo json_encode($liveData); ?>;

  // Function to populate the live items table
  function populateLiveItems() {
    var liveList = document.getElementById("liveItemsList");
    liveList.innerHTML = ""; 

    for (var i = 0; i < liveData.length; i++) {
      var liveItem = liveData[i];

      var row = document.createElement("tr");

      var idCell = document.createElement("td");
      idCell.textContent = liveItem.id;
      row.appendChild(idCell);

      var typeCell = document.createElement("td");
      typeCell.textContent = liveItem.type;
      row.appendChild(typeCell);

      var niveauScolaireCell = document.createElement("td");
      niveauScolaireCell.textContent = liveItem.niveau_scolaire;
      row.appendChild(niveauScolaireCell);

      var anneeScolaireCell = document.createElement("td");
      anneeScolaireCell.textContent = liveItem.annee_scolaire;
      row.appendChild(anneeScolaireCell);

      var matiereCell = document.createElement("td");
      matiereCell.textContent = liveItem.matiere;
      row.appendChild(matiereCell);

      var etatCell = document.createElement("td");
      etatCell.textContent = liveItem.etat;
      row.appendChild(etatCell);

      var categorieCell = document.createElement("td");
      categorieCell.textContent = liveItem.categorie;
      row.appendChild(categorieCell);

      var imageCell = document.createElement("td");
      var imageElement = document.createElement("img");
      imageElement.src = liveItem.image;
      imageCell.appendChild(imageElement);
      row.appendChild(imageCell);

      var phoneNumberCell = document.createElement("td");
      phoneNumberCell.textContent = liveItem.phone_number;
      row.appendChild(phoneNumberCell);

      var nameCell = document.createElement("td");
      nameCell.textContent = liveItem.name;
      row.appendChild(nameCell);

      var emailCell = document.createElement("td");
      emailCell.textContent = liveItem.email;
      row.appendChild(emailCell);

      var exchangeCell = document.createElement("td");
      var exchangeButton = document.createElement("button");
  exchangeButton.textContent = "Exchange";
  exchangeButton.addEventListener("click", function(item) {
    return function() {
      exchangeItem(item);
    };
  }(liveItem));

      exchangeCell.appendChild(exchangeButton);
      row.appendChild(exchangeCell);

      liveList.appendChild(row);
    }
  }

  function exchangeItem(liveItem) {
  var userId = liveItem.id; // Assuming the "id" property exists in the liveItem object
  var userName = liveItem.name; // Assuming the "name" property exists in the liveItem object
  var userEmail = liveItem.email;
  alert("ID of the user: " + userId + "\nName of the user who added the book: " + userName + "\nEmail of the user: " + userEmail);
}


  function applyFilters() {
    
    var idFilter = document.getElementById("idFilter").value;
    var typeFilter = document.getElementById("typeFilter").value;
    var niveauFilter = document.getElementById("niveauFilter").value;
    var anneeFilter = document.getElementById("anneeFilter").value;
    var matiereFilter = document.getElementById("matiereFilter").value;
    var etatFilter = document.getElementById("etatFilter").value;
    var categorieFilter = document.getElementById("categorieFilter").value;

    var filteredData = liveData.filter(function(item) {
      return (
        (idFilter === "" || item.id.toString().includes(idFilter)) &&
        (typeFilter === "" || item.type === typeFilter) &&
        (niveauFilter === "" || item.niveau_scolaire === niveauFilter) &&
        (anneeFilter === "" || item.annee_scolaire === anneeFilter) &&
        (matiereFilter === "" || item.matiere === matiereFilter) &&
        (etatFilter === "" || item.etat === etatFilter) &&
        (categorieFilter === "" || item.categorie === categorieFilter)
      );
    });

    // Update the liveData variable with filtered data
    liveData = filteredData;
    populateLiveItems();
  }

  // Function to reset all filters 
  function resetFilters() {
    document.getElementById("idFilter").value = "";
    document.getElementById("typeFilter").value = "";
    document.getElementById("niveauFilter").value = "";
    document.getElementById("anneeFilter").value = "";
    document.getElementById("matiereFilter").value = "";
    document.getElementById("etatFilter").value = "";
    document.getElementById("categorieFilter").value = "";

    // Reload the page to fetch all live 
    window.location.reload();
  }

  populateLiveItems();
</script>





  </body>
</html>