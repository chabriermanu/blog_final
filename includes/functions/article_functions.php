<?php 
require_once __DIR__ . "/../connect.php";
function getLastPosts($limit = 10) {  
    $dbh = dbconnect(); 
        try {
        $stmt = $dbh->prepare(" SELECT a.id_article, a.titre, a.contenu, a.picture, a.date_creation, a.date_parution, COALESCE(u.pseudo, 'Anonyme') AS auteur FROM article a LEFT JOIN
         user u ON a.id_user = u.id_user ORDER BY a.date_creation DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    } catch (PDOException $e) {
        error_log("Erreur SQL getLastPosts : " . $e->getMessage());
        return [];
    }
}
function getAllArticle() {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT a.id_article AS id, COALESCE(a.titre, '') AS titre, COALESCE(a.date_creation, '') AS date_creation, COALESCE(a.date_parution, '') AS date_parution, COALESCE(a.picture, '') AS picture,
            COALESCE(a.contenu, '') AS contenu, COALESCE(u.pseudo, u.email, '') AS auteur FROM article a JOIN user u ON a.id_user = u.id_user ORDER BY a.date_creation DESC ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getArticleById($id) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT a.id_article AS id, a.id_user, COALESCE(a.titre, '') AS titre, COALESCE(a.date_creation, '') AS date_creation, COALESCE(a.date_parution, '') AS date_parution, COALESCE(a.picture, '') AS picture,
                           COALESCE(a.contenu, '') AS contenu, COALESCE(u.pseudo, u.email, '') AS auteur FROM article a JOIN user u ON a.id_user = u.id_user WHERE a.id_article = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
 function getArticlesByUser($id_user) {
    $dbh = dbconnect();
    try {
        $stmt = $dbh->prepare(" SELECT id_article, titre, contenu, picture, DATE_FORMAT(date_creation, '%d/%m/%Y') as date_creation, DATE_FORMAT(date_parution, '%d/%m/%Y') as date_parution
            FROM article WHERE id_user = :id_user ORDER BY date_creation DESC");
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getArticlesByUser : " . $e->getMessage());
        return [];
    }
}
function addArticle($titre, $dateCreation, $dateParution, $id_user, $picture, $contenu) {
    $dbh = dbconnect();
    try {
        $stmt = $dbh->prepare("INSERT INTO article (titre, date_creation, date_parution, id_user, picture, contenu) VALUES (:titre, :date_creation, :date_parution, :id_user, :picture, :contenu)");  
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':date_creation', $dateCreation);
        $stmt->bindParam(':date_parution', $dateParution);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':picture', $picture);
        $stmt->bindParam(':contenu', $contenu);
        if ($stmt->execute()) {
            return $dbh->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        error_log("Erreur addArticle : " . $e->getMessage());
        return false;
    }
}
function getArticlesByCategory($id_categorie) {
    $dbh = dbconnect();
    try {
        $stmt = $dbh->prepare(" SELECT DISTINCT  a.id_article,  a.titre, a.contenu, a.picture, a.date_creation,  a.date_parution, COALESCE(u.pseudo, u.email, '') AS auteur
         FROM article a JOIN user u ON a.id_user = u.id_user JOIN appartenance app ON a.id_article = app.id_article  WHERE app.id_categorie = :id_categorie ORDER BY a.date_creation DESC ");
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getArticlesByCategory : " . $e->getMessage());
        return [];
    }
}
function updateArticle($id_article,$titre, $contenu, $picture) {
    // var_dump($id_article,$titre, $contenu, $picture);
    // die;
    $dbh = dbconnect();
    try {
       if ($picture) {
            $sql = "UPDATE article  SET titre = :titre, contenu = :contenu, picture = :picture    WHERE id_article = :id";
               } else {
            $sql = "UPDATE article  SET titre = :titre, contenu = :contenu WHERE id_article = :id";
        }
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id_article, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        
        if ($picture) {
            $stmt->bindParam(':picture', $picture);
        }
        
        return $stmt->execute();
        
    } catch (PDOException $e) {
        error_log("Erreur updateArticle : " . $e->getMessage());
        return false;
    }
}
function deleteArticle($id, $picture = null) {
    $dbh = dbconnect();
    
    try {
        // Démarrer une transaction
        $dbh->beginTransaction();
        
        // 1. Supprimer d'abord les catégories (table appartenance)
        $stmt = $dbh->prepare("DELETE FROM appartenance WHERE id_article = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 2. Supprimer d'abord les commentaires
        $stmt = $dbh->prepare("DELETE FROM commentaire WHERE id_article = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // 3. Supprimer l'article (vérifie le nom exact de ta colonne !)
        $stmt = $dbh->prepare("DELETE FROM article WHERE id_article = :id");  // ou id_article
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Valider la transaction
        $dbh->commit();
        
        // 4. Si succès en BDD, supprimer l'image du serveur
        if (!empty($picture) && is_file($picture)) {
            if (!unlink($picture)) {
                error_log("Échec de suppression de l'image : $picture");
            }
        }
        
        return true;
        
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $dbh->rollBack();
        error_log("Erreur deleteArticle : " . $e->getMessage());
        return false;
    }
}
