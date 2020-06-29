<?php
    class controller_libary_connectDB{
        protected $servername = "localhost";
        protected $usernameDB = "root";
        protected $passwordDB = "";
        // protected $DBname = "db-manager";
        protected $DBname = "manager";
        protected $tablename = "";
        protected $conn;
        public function __construct()
        {
            # code...
            try{
                $this->conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->DBname, $this->usernameDB, $this->passwordDB);
                $this->connectDB();
            }catch(PDOException $error){
                echo "Connect failed: ".$error->getMessage();
            }
        }
        public function connectDB()
        {
            # code...
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connect is success";

        }
        public function addQueryParameter($param)
        {
            # code...
            $default = [
                "SELECT" => "",
                "FROM" => "",
                "WHERE" => "",
                "OTHER" => "",
                "PARAMS" => "",
                "FIELD" => ""
            ];
            // ghi đè mảng default lên mảng queryPara
            $this->queryParameter = array_merge($default,$param);
            return $this;
        }
    }
?>