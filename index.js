// Sélectionner toutes les cartes de recettes
const recipeCards = document.querySelectorAll("#recipe-cards .card");

// Parcourir chaque carte de recette et ajouter un gestionnaire d'événements de clic
recipeCards.forEach((card) => {
  card.addEventListener("click", () => {
    // Récupérer les informations de la recette à partir de la carte cliquée
    const title = card.querySelector(".card-title").textContent;
    const description = card.querySelector(".card-text").textContent;
    const imagePath = card.querySelector(".card-img-top").getAttribute("src");

    // Ouvrir une nouvelle fenêtre avec les détails de la recette
    const newWindow = window.open("", "_blank");
    newWindow.document.write(`
      <html>
      <head>
        <title>Détails de la recette</title>
        <style>
          /* Ajoutez votre propre CSS pour personnaliser le style de la page */
        </style>
      </head>
      <body>
        <h2>${title}</h2>
        <img src="${imagePath}" alt="${title}">
        <p>${description}</p>
      </body>
      </html>
    `);
  });
});

// Sélectionner toutes les cartes de recettes
const recipeCardss = document.querySelectorAll("#recipe-cards .card");

// Sélectionner la zone d'affichage des détails de la recette
const recipeDetails = document.getElementById("recipe-details");

// Parcourir chaque carte de recette et ajouter un gestionnaire d'événements de clic
recipeCardss.forEach((card, index) => {
  const accessButton = card.querySelector(".access-button");

  // Ajouter un gestionnaire d'événements de clic au bouton d'accès
  accessButton.addEventListener("click", () => {
    // Vérifier si l'utilisateur est connecté (vous pouvez personnaliser cette vérification selon votre système d'authentification)
    const userIsLoggedIn = checkUserLoggedIn();

    // Si l'utilisateur est connecté, afficher les détails de la recette
    if (userIsLoggedIn) {
      // Récupérer les informations de la recette à partir de la carte cliquée
      const title = card.querySelector(".card-title").textContent;
      const description = card.querySelector(".card-text").textContent;
      const imagePath = card.querySelector(".card-img-top").getAttribute("src");

      // Afficher les détails de la recette dans la zone d'affichage des détails
      recipeDetails.innerHTML = `
        <h2>${title}</h2>
        <img src="${imagePath}" alt="${title}">
        <p>${description}</p>
      `;
    } else {
      // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion (vous pouvez personnaliser l'URL de redirection)
      window.location.href = "page_connexion.html";
    }
  });
});

function checkUserLoggedIn() {
  // Vérifier ici si l'utilisateur est connecté (vous pouvez personnaliser cette fonction selon votre système d'authentification)
 
}