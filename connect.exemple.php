 <?php
function dbconnect(){
    try{
        $dsn = 'mysql:dbname=ecf_tp;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        return $dbh;
    }catch(PDOException $e){ 
        echo "erreur de connection à la base";  
    }
}