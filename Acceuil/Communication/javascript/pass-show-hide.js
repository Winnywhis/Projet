// Sélectionne l'élément input de type password dans le formulaire
const pswrdField = document.querySelector(".form input[type='password']"),
// Sélectionne l'icône dans le formulaire
toggleIcon = document.querySelector(".form .field i");

// Définit la fonction à exécuter lors du clic sur l'icône
toggleIcon.onclick = () =>{
  // Vérifie si le champ de mot de passe est actuellement en mode mot de passe
  if(pswrdField.type === "password"){
    // Change le type du champ en mode texte
    pswrdField.type = "text";
    // Ajoute la classe "active" à l'icône
    toggleIcon.classList.add("active");
  }else{
    // Change le type du champ en mode mot de passe
    pswrdField.type = "password";
    // Supprime la classe "active" de l'icône
    toggleIcon.classList.remove("active");
  }
}