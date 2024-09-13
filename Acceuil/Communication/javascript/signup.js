// Sélection des éléments du formulaire et du bouton "Continuer"
const form = document.querySelector(".signup form"), // Formulaire d'inscription
      continueBtn = form.querySelector(".button input"), // Bouton "Continuer"
      errorText = form.querySelector(".error-text"); // Élément de texte d'erreur

// Empêche la soumission du formulaire de manière standard
form.onsubmit = (e) => {
  e.preventDefault();
}

// Gestion du clic sur le bouton "Continuer"
continueBtn.onclick = () => {
  // Création d'une nouvelle requête XMLHttpRequest
  let xhr = new XMLHttpRequest();
  
  // Ouverture d'une requête POST vers le fichier "signup.php"
  xhr.open("POST", "php/signup.php", true);
  
  // Gestion de la réponse de la requête
  xhr.onload = () => {
    // Vérification de la réussite de la requête
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Récupération des données de réponse
        let data = xhr.response;
        
        // Vérification du succès de l'inscription
        if (data === "success") {
          // Redirection vers la page "users.php"
          location.href = "users.php";
        } else {
          // Affichage du message d'erreur
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      }
    }
  }
  
  // Création d'un nouvel objet FormData avec les données du formulaire
  let formData = new FormData(form);
  
  // Envoi de la requête avec les données du formulaire
  xhr.send(formData);
}