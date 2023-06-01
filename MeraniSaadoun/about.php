<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>À Propos</title>
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

.about-card {
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

.about-info {
  margin-bottom: 30px;
  text-align: justify;
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
    <div class="about-card">
      <h2>À Propos</h2>
      <div class="about-info">
        <p> Bienvenue sur notre site web d'échange de livres!</p>
        <p>Notre site a été créée dans le but de faciliter l'échange de livres entre les passionnés de lecture. Que vous souhaitiez partager vos livres avec d'autres lecteurs ou découvrir de nouvelles œuvres, notre site est là pour vous aider.</p>
        <p>Sur notre site, vous pouvez créer un compte, ajouter les livres que vous souhaitez échanger à votre profil et parcourir la liste des livres disponibles des autres utilisateurs. Vous pouvez contacter les propriétaires des livres qui vous intéressent et organiser des échanges.</p>
        <p>Nous croyons en la valeur de la communauté de lecteurs et espérons que notre site facilitera les échanges littéraires, permettant ainsi à davantage de personnes de découvrir de nouvelles histoires et de partager leurs recommandations.</p>
        <p>Explorez notre site, trouvez de nouveaux livres à lire et connectez-vous avec d'autres passionnés de lecture!</p>
      
      </div>
      <div class="back-link">
        <a href="home.html">Retour à la page d'accueil</a>
      </div>
    </div>
  </div>
</body>
</html>
