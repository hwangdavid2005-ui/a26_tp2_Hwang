<?php
$page = "panier";
include("commun/entete.inc.php");
?>

<main class="page-panier">
    <h1><?= $_->titrePage; ?></h1>

    <section class="contenu-panier">

        <div class="produit-panier">
            <div class="nom-produit">
                <img src="images/produits/teeshirts/ts0004.webp" alt="Monstre douillet">
                <span>Monstre douillet</span>
            </div>

            <span class="couleur vert"></span>
            <span class="taille">M</span>
            <input type="number" value="5" min="1">
            <span class="prix">29.50 $</span>
            <span class="supprimer">▣</span>
        </div>

        <div class="produit-panier">
            <div class="nom-produit">
                <img src="images/produits/teeshirts/ts0005.webp" alt="Bleu comme une orange">
                <span>Bleu comme une orange</span>
            </div>

            <span class="couleur rose"></span>
            <span class="taille">XS</span>
            <input type="number" value="2" min="1">
            <span class="prix">19.99 $</span>
            <span class="supprimer">▣</span>
        </div>

        <div class="total-panier">
            <span>(<?= $_->totalArticles; ?>: 7)</span>
            <span><?= $_->sousTotal; ?>: 187.48 $</span>
            <button><?= $_->commander; ?></button>
        </div>

    </section>
</main>

<?php
include("commun/pied2page.inc.php");
?>