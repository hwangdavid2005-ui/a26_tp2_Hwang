const filtre = document.querySelector("#filtre");
const liste = document.querySelector("#liste-produits");
const gabarit = document.querySelector("#gabarit-produit");

filtre.addEventListener("change", afficherProduits);
/**
 * Récupère les produits selon le thème sélectionné et update leur affichage.
 *
 * @returns {Promise<void>} Promesse terminé après l'affichage des produits.
 */
async function afficherProduits() {
    const reponse = await fetch("teeshirts-ajax.php?filtre=" + filtre.value);
    const produits = await reponse.json();

    liste.innerHTML = "";

    for (const produit of produits) {
        const copie = gabarit.content.cloneNode(true);

        const langue = document.documentElement.lang;
        const nom = produit.nom[langue] || produit.nom.fr;

        const image = copie.querySelector("img");
        image.src = "images/produits/teeshirts/" + produit.id + ".webp";
/**
 * Affiche l'image par défaut si l'image du produit est introuvable.
 */
        image.onerror = function() {
            image.onerror = null;
            image.src = "images/produits/teeshirts/ts-0000.webp";
        };

image.alt = nom;

        copie.querySelector(".nom").textContent = nom;

        if (produit.ventes > 0) {
            copie.querySelector(".ventes").textContent = produit.ventes + " ventes";
        }

        copie.querySelector(".prix").textContent =
            new Intl.NumberFormat(langue, {
                style: "currency",
                currency: "CAD"
            }).format(produit.prix);

        liste.appendChild(copie);
    }
}