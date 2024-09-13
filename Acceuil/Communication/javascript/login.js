// Sélection du formulaire de connexion, du bouton de continuation et de l'élément de texte d'erreur
const form = document.querySelector(".login form"),
      continueBtn = form.querySelector(".button input"),
      errorText = form.querySelector(".error-text");

// Empêche le comportement de soumission de formulaire par défaut
form.onsubmit = (e) => {
  e.preventDefault();
}

// Gestion du clic sur le bouton de continuation
continueBtn.onclick = () => {
  // Création d'une nouvelle requête HTTP
  let xhr = new XMLHttpRequest();
  
  // Ouverture de la requête POST vers le script PHP de connexion
  xhr.open("POST", "php/login.php", true);
  
  // Gestion de la réponse du serveur
  xhr.onload = () => {
    // Vérification du statut de la requête
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Vérification du code de statut de la réponse
      if (xhr.status === 200) {
        // Récupération de la réponse du serveur
        let data = xhr.response;
        
        // Vérification de la réponse
        if (data === "success") {
          // Redirection vers la page des utilisateurs
          location.href = "users.php";
        } else {
          // Affichage du message d'erreur
          errorText.style.display = "block";
          errorText.textContent = data;
        }
      }
    }
  }
  
  // Création d'un objet FormData à partir du formulaire
  let formData = new FormData(form);
  
  // Envoi de la requête avec les données du formulaire
  xhr.send(formData);
}