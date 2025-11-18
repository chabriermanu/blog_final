<?php 
require_once "connect.php";
//////////////////////////////////////////////////////////////////////////////////////
function signUp($email, $password, $pseudo, $type_user) {  
    $dbh = dbconnect();
    try {
        $avatar = null;
        $date_inscription = date('Y-m-d');
        $stmt = $dbh->prepare("INSERT INTO user (email, password, pseudo, type_user, avatar, date_inscription) VALUES (:email, :password, :pseudo, :type_user, :avatar, :date_inscription)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':pseudo', $pseudo); 
        $stmt->bindParam(':type_user', $type_user);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':date_inscription', $date_inscription);
        return $stmt->execute();  // ✅ Retourne true/false
    } catch (PDOException $e) {
        error_log("Erreur SQL signUp : " . $e->getMessage());
        return false;
    }
}
////////////////////////////////////////////////////Functions get//////////////////////////////////////////
function getUserByEmail($email) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
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
function getAllArticle() {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT a.id_article AS id, COALESCE(a.titre, '') AS titre, COALESCE(a.date_creation, '') AS date_creation, COALESCE(a.date_parution, '') AS date_parution, COALESCE(a.picture, '') AS picture,
            COALESCE(a.contenu, '') AS contenu, COALESCE(u.pseudo, u.email, '') AS auteur FROM article a JOIN user u ON a.id_user = u.id_user ORDER BY a.date_creation DESC ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getArticleById($id) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT a.id_article AS id, COALESCE(a.titre, '') AS titre, COALESCE(a.date_creation, '') AS date_creation, COALESCE(a.date_parution, '') AS date_parution, COALESCE(a.picture, '') AS picture,
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
////////////////////////////////////////////////////////Functions add///////////////////////////////////////////////////////////////////////////
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

function addCategorie($nom, $description, $avatar, $couleur) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare(" INSERT INTO categorie (nom_categorie, description, avatar, couleur)VALUES (:nom, :description, :avatar, :couleur)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':couleur', $couleur);
    return $stmt->execute(); // renvoie true ou false
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
////////////////////////////////////////////////////////////Functions update/////////////////////////////////////////////////////////////////////////
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

function deleteArticle($id, $cheminImage = null) {
    $dbh = dbconnect();
    
    try {
        // Démarrer une transaction
        $dbh->beginTransaction();
        
        // 1. Supprimer d'abord les commentaires
        $stmt = $dbh->prepare("DELETE FROM commentaire WHERE id_article = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // 2. Supprimer l'article (vérifie le nom exact de ta colonne !)
        $stmt = $dbh->prepare("DELETE FROM article WHERE id = :id");  // ou id_article
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Valider la transaction
        $dbh->commit();
        
        // 3. Si succès en BDD, supprimer l'image du serveur
        if (!empty($cheminImage) && is_file($cheminImage)) {
            if (!unlink($cheminImage)) {
                error_log("Échec de suppression de l'image : $cheminImage");
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


