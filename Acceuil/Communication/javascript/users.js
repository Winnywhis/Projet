// Sélection des éléments HTML
const searchBar = document.querySelector(".search input"), // Barre de recherche
      searchIcon = document.querySelector(".search button"), // Icône de recherche
      usersList = document.querySelector(".users-list"); // Liste des utilisateurs

// Gestion de l'affichage de la barre de recherche
searchIcon.onclick = () => {
  // Toggle de la classe "show" pour afficher/masquer la barre de recherche
  searchBar.classList.toggle("show");
  // Toggle de la classe "active" pour l'icône de recherche
  searchIcon.classList.toggle("active");
  // Focus sur la barre de recherche
  searchBar.focus();
  // Si la barre de recherche est active, suppression de la valeur et de la classe "active"
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

// Gestion de la recherche
searchBar.onkeyup = () => {
  // Récupération du terme de recherche
  let searchTerm = searchBar.value;
  // Ajout de la classe "active" si le terme de recherche n'est pas vide
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    // Suppression de la classe "active" si le terme de recherche est vide
    searchBar.classList.remove("active");
  }
  // Envoi d'une requête POST à php/search.php avec le terme de recherche
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = () => {
    // Traitement de la réponse
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Récupération des données de la réponse
        let data = xhr.response;
        // Mise à jour de la liste des utilisateurs
        usersList.innerHTML = data;
      }
    }
  }
  // Définition du header de la requête
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // Envoi de la requête avec le terme de recherche
  xhr.send("searchTerm=" + searchTerm);
}

// Actualisation automatique de la liste des utilisateurs
setInterval(() => {
  // Envoi d'une requête GET à php/users.php
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = () => {
    // Traitement de la réponse
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Récupération des données de la réponse
        let data = xhr.response;
        // Mise à jour de la liste des utilisateurs si la barre de recherche n'est pas active
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
        }
      }
    }
  }
  // Envoi de la requête
  xhr.send();
}, 500); // Intervalle de 500 millisecondes