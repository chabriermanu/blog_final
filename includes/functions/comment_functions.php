<?php 
require_once __DIR__ . "/../connect.php";
function getCommentairesByArticle($id_article) {
    $dbh = dbconnect();
    try {
        $stmt = $dbh->prepare(" SELECT c.id_commentaire, c.id_article, c.id_user, c.pseudo_visiteur, c.contenu, c.date_parution as date_commentaire,  COALESCE(u.pseudo, c.pseudo_visiteur) AS auteur_commentaire, 
                u.avatar, CASE WHEN c.id_user IS NOT NULL THEN 'membre' ELSE 'visiteur' END AS type_auteur FROM commentaire c LEFT JOIN user u ON c.id_user = u.id_user WHERE c.id_article = :id_article
            ORDER BY c.date_parution DESC");
        
        $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erreur getCommentairesByArticle : " . $e->getMessage());
        return [];
    }
}
function addCommentaire($id_article, $contenu, $id_user , $pseudo_visiteur ) {   
    $dbh = dbconnect();
    try {
        $stmt = $dbh->prepare("INSERT INTO commentaire (id_article, id_user, pseudo_visiteur, contenu, date_parution) VALUES (:id_article, :id_user, :pseudo_visiteur, :contenu, NOW())");
        $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':pseudo_visiteur', $pseudo_visiteur, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur addCommentaire : " . $e->getMessage());
        return false;
    }
}