<?php
$page = "teeshirts";
include("commun/entete.inc.php");
include("lib/catalogue.lib.php");

// Intégrer le fichier JSON contenant les produits
$catalogue = json_decode(file_get_contents("data/teeshirts.json"));

// Langue pour le catalogue
$langueCatalogue = $langue;

if (!isset($catalogue->animaux->theme->$langue)) {
    $langueCatalogue = "fr";
}

// On crée deux tableaux pour stocker les thèmes et les produits
$themes = [];
$produits = [];
$filtre = $_GET["filtre"] ?? "tous";

// On parcourt le catalogue pour sortir les thèmes et fusionner les produits
foreach ($catalogue as $codeTheme => $detailTheme) {
    $themes[$codeTheme] = $detailTheme->theme->$langueCatalogue . " (" . count($detailTheme->produits) . ")";

    // Fusionner avec le tableau $produits
    if ($filtre == "tous" || $filtre == $codeTheme) {
        $produits = array_merge($produits, $detailTheme->produits);
    }
}

// Le tri des produits est fait à  la fin, après le filtrage.
$tri = obtenirCritereTri();
$produits = trierProduits($produits, $tri);
?>
<main class="page-produits page-teeshirts">
    <article class="amorce">
        <h1><?= $_->titrePage; ?></h1>
        <form class="controle" action="">
            <div class="filtre">
                <label for="filtre"><?= $_cat->etiquetteFiltre; ?></label>
                <select name="filtre" id="filtre" onchange="this.form.submit()">
                    <option value="tous" <?= ($filtre == "tous") ? "selected" : ""; ?>>
                        <?= $_cat->tousProduits . " (120)"; ?>
                    </option>
                    <!-- Générer les options des thèmes dynamiquement -->
                    <?php foreach ($themes as $codeTheme => $nomTheme) : ?>
                        <option value="<?= $codeTheme; ?>" <?= ($filtre == $codeTheme) ? "selected" : ""; ?>>
                            <?= $nomTheme; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="tri">
                <label for="tri"><?= $_cat->etiquetteTri; ?></label>
                <select name="tri" id="tri">
                    <option <?= ($tri=="aleatoire") ? "selected" : ""; ?> value="aleatoire"><?= $_cat->aleatoire; ?></option>
                    <option <?= ($tri=="ventesDesc") ? "selected" : ""; ?> value="ventesDesc"><?= $_cat->ventesDesc; ?></option> 
                    <option <?= ($tri=="prixAsc") ? "selected" : ""; ?> value="prixAsc"><?= $_cat->prixAsc; ?></option>
                    <option <?= ($tri=="prixDesc") ? "selected" : ""; ?> value="prixDesc"><?= $_cat->prixDesc; ?></option>
                    <!-- Pour les besoins du TP, nous ne gérons pas le tri par nom et par date d'ajout -->
                    <!-- 
                        <option <?= ($tri=="nomAsc") ? "selected" : ""; ?> value="nomAsc"><?= $_cat->nomAsc; ?></option>
                        <option <?= ($tri=="nomDesc") ? "selected" : ""; ?> value="nomDesc"><?= $_cat->nomDesc; ?></option>
                        <option <?= ($tri=="dacDesc") ? "selected" : ""; ?> value="dacDesc"><?= $_cat->dacDesc; ?></option>
                    -->
                </select>
            </div>
        </form>
    </article>
    <article class="principal" id="liste-produits">
        <!-- Gabarit -->
        <?php foreach ($produits as $prd) : ?>
            <div class="produit">
                <span class="image">
                    <?php
                        $image = "images/produits/teeshirts/" . $prd->id . ".webp";

                        if (!file_exists($image)) {
                            $image = "images/produits/teeshirts/ts-0000.webp";
                        }
                    ?>
                    <img src="<?= $image; ?>" alt="<?= $prd->nom->$langueCatalogue; ?>">
                </span>
                <span class="nom"><?= $prd->nom->$langueCatalogue; ?></span>
                <?php if ($prd->ventes > 0) : ?>
                    <span class="ventes"><?= $prd->ventes; ?> ventes</span>
                <?php endif; ?>
                <span class="prix"><?= MessageFormatter::formatMessage($langue, "{0, number, :: currency/CAD}", [$prd->prix]) ?></span>
            </div>
        <?php endforeach; ?>
    </article>
</main>

<!-- Gabarit à utiliser pour implémenter l'affichage asynchrone des produits -->
<!-- Adapter le gabarit ci-dessous pour répondre aux besoins du TP -->
<?php
include("commun/pied2page.inc.php");
?>