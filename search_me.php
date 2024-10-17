<?php
// Charger la configuration
$config = require 'config.php';

// Récupérer la requête de recherche
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Vérifier si la requête de recherche est vide
if (empty($query)) {
    echo "Please enter a search query.";
    exit;
}

// Exemple de recherche avec DuckDuckGo
$searchUrl = "https://duckduckgo.com/?q=" . urlencode($query);

// Rediriger vers le moteur de recherche
header("Location: $searchUrl");
exit;
?>

