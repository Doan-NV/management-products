<?php
    session_start();
    class controller_libary_loginController
    {
        public $username;
        public $password;
        protected $id;
        public function __construct($username = "", $password = "")
        {
            # code...
            $this->username = $username;
            $this->password = $password;
        }
        public function login()
        {
            # code...
            $user = new model_User();
            $query = $user->addQueryParameter([
                "SELECT" => "*",
                "WHERE" => "username = '$this->username' AND password = '$this->password'"
            ])->select();
            var_dump($query);
            if($query){
                $_SESSION["id"] = $query["id"];
                $_SESSION["username"] = $query["username"];
                $_SESSION["password"] = $query["password"];
                $_SESSION["name"] = $query["name"];
                $_SESSION["email"] = $query["email"];
                $_SESSION["image"] = $query['image'];
            }
            return false;
        }
        public function logout()
        {
            # code...
            session_unset();
        }
        public function getSESSION($name)
        {
            # code...
            if($name !== null){
                return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
            }
            // return $_SESSION;
        }
        public function isLogin()
        {
            # code...
            if($this->getSESSION("name")){
                return true;
            }
        }
        public function getID()
        {
            # code...
            return $this->getSESSION("id");
    
        }
    }
?>