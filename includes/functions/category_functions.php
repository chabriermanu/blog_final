<?php 
require_once __DIR__ . "/../connect.php";

function getCategoriesByArticle($id_article) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare(" SELECT c.id_categorie, c.nom_categorie, c.couleur, c.avatar, c.description
        FROM categorie c
        JOIN appartenance app ON c.id_categorie = app.id_categorie
        WHERE app.id_article = :id_article
        ORDER BY c.nom_categorie ASC
    ");
    $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllCategories(){
    $dbh=dbconnect();
    $stmt = $dbh->prepare("SELECT c.id_categorie, c.nom_categorie, c.description, c.avatar, c.couleur, COUNT(app.id_article) AS nb_articles FROM categorie c LEFT JOIN appartenance app ON c.id_categorie = app.id_categorie
            GROUP BY c.id_categorie, c.nom_categorie, c.description, c.avatar, c.couleur ORDER BY c.nom_categorie ASC");
    $stmt->execute();
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function addCategorie($nom, $description, $avatar, $couleur) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare(" INSERT INTO categorie (nom_categorie, description, avatar, couleur)VALUES (:nom, :description, :avatar, :couleur)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':couleur', $couleur);
    return $stmt->execute(); // renvoie true ou false
}
function updateArticleCategories($idArticle, $categories) {
    try {
        $dbh = dbconnect();
        
        // 1️⃣ Suppression des anciennes catégories
        $stmtDelete = $dbh->prepare("DELETE FROM appartenance WHERE id_article = :id_article");
        $stmtDelete->execute([':id_article' => $idArticle]);
        
        // 2️⃣ Ajout des nouvelles catégories
        $stmtInsert = $dbh->prepare("INSERT INTO appartenance (id_article, id_categorie) VALUES (:id_article, :id_categorie)");
        foreach ($categories as $idCategorie) {
            $stmtInsert->execute([
                ':id_article' => $idArticle,
                ':id_categorie' => $idCategorie
            ]);
        }
        return true;
    } catch (PDOException $e) {
        error_log("Erreur updateArticleCategories : " . $e->getMessage());
        return false;
    }
}
function deleteArticleCategories($idArticle) {
    try {
        $dbh = dbconnect();
        $stmt = $dbh->prepare("DELETE FROM appartenance WHERE id_article = :id_article");
        $stmt->execute([':id_article' => $idArticle]);
        return true;
    } catch (PDOException $e) {
        error_log("Erreur deleteArticleCategories : " . $e->getMessage());
        return false;
    }
}