<?php

require_once ROOT . DS . 'config' . DS . 'Config.php';
class Modele {

    public static $pdo;

    public static function set_static() {
        $host = Config::getHostname();
        $dbname = Config::getDatabase();
        $login = Config::getLogin();
        $pass = Config::getPassword();

        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            if (Config::getDebug()) {
                echo $ex->getMessage();
                die ("Problème lors de la connexion à la base de données");
            } else {
                echo "Une erreur est survenue.";
            }
            die();
        }
    }

    public static function insertion($data) {
      try {
        $table = static::$table;
        $indices = "";
        $values = "";
        foreach ($data as $key => $value) {
          $indices .= "$key, ";
          $values .= ":$key, ";
        }
        $indices = '(' . rtrim($indices, ', ') . ')';
        $values = '(' . rtrim($values, ', ') . ')';
        $sql = "INSERT INTO $table $indices VALUES $values";
        $req = self::$pdo->prepare($sql);
        $req->execute($data);
        return self::$pdo->lastInsertId(); //retourne le dernier id insérer dans la BDD sur cette session
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de l'insertion dans la BDD " . static::$table);
      }
    }

    public static function suppression($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $sql = "DELETE FROM $table WHERE $table.$primary = :$primary";
        $req = self::$pdo->prepare($sql);
        return $req->execute($data);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la suppression dans la BDD " . static::$table);
      }
    }

    public static function suppressionWhere($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $where = "";
        foreach ($data as $key => $value)
        $where .= " $table.$key=:$key AND";
        $where = rtrim($where, 'AND');
        $sql = "DELETE FROM $table WHERE $where";
        $req = self::$pdo->prepare($sql);
        return $req->execute($data);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la suppression dans la BDD " . static::$table);
      }
    }

    public static function selectAll() {
      try {
        $sql = "SELECT * FROM " . static::$table;
        $req = self::$pdo->query($sql);
        return $req->fetchAll(PDO::FETCH_OBJ);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche de tous les objets de la BDD " . static::$table);
      }
    }

    public static function select($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $sql = "SELECT * FROM $table WHERE $table.$primary = :$primary";
        $req = self::$pdo->prepare($sql);
        $req->execute($data);
        if ($req->rowCount() != 0)
        return $req->fetch(PDO::FETCH_OBJ);
        return null;
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la BDD " . static::$table);
      }
    }

    public static function selectWhere($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $where = "";
        foreach ($data as $key => $value)
        $where .= " $table.$key=:$key AND";
        $where = rtrim($where, 'AND');
        $sql = "SELECT * FROM $table WHERE $where";
        $req = self::$pdo->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la BDD " . static::$table);
      }
    }

    public static function selectWhereOr($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $where = "";
        foreach ($data as $key => $value)
        $where .= " $table.$key=:$key OR";
        $where = rtrim($where, 'OR');
        $sql = "SELECT * FROM $table WHERE $where";
        $req = self::$pdo->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la BDD " . static::$table);
      }
    }

    public static function update($data) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        $update = "";
        foreach ($data as $key => $value)
        $update .= "$key=:$key, ";
        $update = rtrim($update, ', ');
        $sql = "UPDATE $table SET $update WHERE $primary=:$primary";
        $req = self::$pdo->prepare($sql);
        return $req->execute($data);
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la mise à jour dans la BDD " . static::$table);
      }
    }
}

Modele::set_static();

?>
