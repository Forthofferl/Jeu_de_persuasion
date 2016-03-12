<?php

class Config {

    private static $database = array(
        'hostname' => 'localhost',
        'database' => 'persuasion_game',
        'login'    => 'root',
        'password' => ''
    );

    private static $debug = true;
	  private static $seed = "seed_que_vous_voulez";

    static public function getLogin() {
        return self::$database['login'];
    }

    static public function getHostname() {
        return self::$database['hostname'];
    }

    static public function getDatabase() {
        return self::$database['database'];
    }

    static public function getPassword() {
        return self::$database['password'];
    }

    static public function getDebug() {
        return self::$debug;
    }

	  static public function getSeed() {
        return self::$seed;

    }

}

?>
