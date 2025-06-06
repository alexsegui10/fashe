<?php
    class Conf {
        private $_userdb;
        private $_passdb;
        private $_hostdb;
        private $_db;
        static $_instance;

        private function __construct() {
            //return 'hola __construct Conf';
            // $cnfg = parse_ini_file(UTILS."db.ini");
            // $this->_userdb = $cnfg['user'];
            // $this->_passdb = $cnfg['pass'];
            // $this->_hostdb = $cnfg['host'];
            // $this->_db = $cnfg['db'];

        $dbConfig = parse_ini_file(
            $_SERVER['DOCUMENT_ROOT'] . '/Fashe/model/db.ini',
            true
        );

        if (! $dbConfig) {
            throw new \Exception('No se pudo leer db.ini');
        }
        $this->_userdb = $dbConfig['database']['user'];
        $this->_passdb = $dbConfig['database']['password'];
        $this->_hostdb = $dbConfig['database']['host'];
        $this->_db      = $dbConfig['database']['db'];

        }

        private function __clone() {

        }

        public static function getInstance() {
            //return 'hola getInstance Conf';
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }

        public function getUserDB() {
            $var = $this->_userdb;
            return $var;
        }

        public function getHostDB() {
            $var = $this->_hostdb;
            return $var;
        }

        public function getPassDB() {
            $var = $this->_passdb;
            return $var;
        }

        public function getDB() {
            $var = $this->_db;
            return $var;
        }
    }
