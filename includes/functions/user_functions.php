<?php 
require_once __DIR__ . "/../connect.php";

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
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur SQL signUp : " . $e->getMessage());
        return false;
    }
}

function getUserByEmail($email) {
    $dbh = dbconnect();
    $stmt = $dbh->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}