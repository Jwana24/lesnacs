<?php

    class Manager
    {
        protected $_bdd;

        function __construct()
        {
            try
            {
                $this->_bdd = new PDO('mysql:host=localhost;dbname=projet_lesnacs;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                die('Erreur : '.$e->getMesssage());
            }
        }
    }
