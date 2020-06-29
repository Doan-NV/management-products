<?php
    class model_User extends controller_libary_connectDB{
        // protected $tablename = "user";
        protected $tablename = "users";
        protected $queryParameter = [];
        public $id;
        public $username;
        public $password="";
        public $email="";
        public $fullname="";
        public $image;


        public function checkValue($value)
        {
            # code...
            if(trim($value)){
                return "WHERE ".$value;
            }else{
                return "";
            }
        }
        public function select()
        {
            # code...
            $sql = "SELECT DISTINCT ".$this->queryParameter["SELECT"]
            ." FROM ".$this->tablename." "
            .$this->checkValue($this->queryParameter["WHERE"])
            ." ".$this->queryParameter["OTHER"];
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result!=null ? $result[0] : null;
            $this->conn = null;
        }
        public function insert()
        {
             # code...
             $sql = "INSERT INTO ".$this->tablename." (name, username, password, email) VALUE ('".$this->fullname."','".$this->username."','".$this->password."','".$this->email."')";
             echo $sql;
            //  die();
             $this->conn->exec($sql);
             $this->conn = null;
        }
        public function insertAvatar()
        {
            # code...
            $sql = "INSERT INTO ".$this->tablename." (name, username, password, email) VALUE ('".$this->fullname."','".$this->username."','".$this->password."','".$this->email."')";
             echo $sql;
        }
        public function updatePassword()
        {
            # code...
            $sql = "UPDATE ".$this->tablename." SET password = '".$this->password."' WHERE id = ".(int)$this->id;
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $this->conn = null;

            
        }
        public function updateAvata()
        {
            # code...
            $sql = "UPDATE ".$this->tablename." SET image = '".$this->image."' WHERE id = ".(int)$this->id;
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $this->conn = null;

        }
    }
