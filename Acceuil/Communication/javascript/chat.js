// Sélection des éléments du DOM
const form = document.querySelector(".typing-area"), // Formulaire de chat
      incoming_id = form.querySelector(".incoming_id").value, // ID de la conversation
      inputField = form.querySelector(".input-field"), // Champ de saisie du message
      sendBtn = form.querySelector("button"), // Bouton d'envoi du message
      chatBox = document.querySelector(".chat-box"); // Boîte de chat

// Empêcher le formulaire d'être soumis par défaut
form.onsubmit = (e) => {
  e.preventDefault();
}

// Mettre le focus sur le champ de saisie
inputField.focus();

// Ajouter un écouteur d'événements au champ de saisie pour activer/désactiver le bouton d'envoi
inputField.onkeyup = () => {
  if (inputField.value != "") {
    sendBtn.classList.add("active"); // Activer le bouton d'envoi si le champ de saisie n'est pas vide
  } else {
    sendBtn.classList.remove("active"); // Désactiver le bouton d'envoi si le champ de saisie est vide
  }
}

// Ajouter un écouteur d'événements au bouton d'envoi pour envoyer le message
sendBtn.onclick = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/insert-chat.php", true); // Envoyer une requête POST à la page de traitement des messages
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = ""; // Effacer le champ de saisie après l'envoi du message
        scrollToBottom(); // Faire défiler la boîte de chat jusqu'en bas
      }
    }
  }
  let formData = new FormData(form); // Créer un objet FormData à partir du formulaire
  xhr.send(formData); // Envoyer les données du formulaire
}

// Ajouter des écouteurs d'événements à la boîte de chat pour activer/désactiver la classe "active"
chatBox.onmouseenter = () => {
  chatBox.classList.add("active"); // Activer la classe "active" lorsque la souris est au-dessus de la boîte de chat
}

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active"); // Désactiver la classe "active" lorsque la souris quitte la boîte de chat
}

// Définir un intervalle pour mettre à jour la boîte de chat toutes les 500 millisecondes
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/get-chat.php", true); // Envoyer une requête POST à la page de traitement des messages
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response; // Récupérer les données de la réponse
        chatBox.innerHTML = data; // Mettre à jour la boîte de chat avec les nouvelles données
        if (!chatBox.classList.contains("active")) {
          scrollToBottom(); // Faire défiler la boîte de chat jusqu'en bas si elle n'est pas déjà active
        }
      }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Définir le type de contenu de la requête
  xhr.send("incoming_id=" + incoming_id); // Envoyer l'ID de la conversation avec la requête
}, 500);

// Fonction pour faire défiler la boîte de chat jusqu'en bas
function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight; // Définir la propriété scrollTop sur la propriété scrollHeight
}