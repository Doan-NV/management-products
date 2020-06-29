<?php
    class model_Category extends controller_libary_connectDB{
        // protected $tablename = "category";
        protected $tablename = "categories";
        protected $queryParameter = [];
        public $id; //id
        public $name; // name
        public $id_user; // id_user
        public function checkValue($value)
        {
            # code...
            if(trim($value)){
                return "WHERE ".$value;
            }else{
                return "";
            }
        }
        public function selectOne()
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

            return $result!=null ? $result[0] : null;
            $this->conn = null;
        }
        public function select()
        {
            # code...
            $sql = "SELECT ".$this->queryParameter["SELECT"]
            ." FROM ".$this->tablename." "
            .$this->checkValue($this->queryParameter["WHERE"])
            ." ".$this->queryParameter["OTHER"];
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result!=null ? $result : null;
            $this->conn = null;
        }
        public function selectEnd()
        {
            # code...
            $sql = "SELECT " . $this->queryParameter['SELECT']
            . " FROM " . $this->tablename . " "
            . " " . $this->queryParameter['OTHER'];
            // echo $sql;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result);

            return $result != null ? $result : null;
            $this->conn = null;
        }
        public function insert()
        {
            # code...
            $sql = "INSERT INTO ".$this->tablename." (id_user, name) VALUE ('".$this->id_user."','".$this->name."')";
            // echo $sql;
            // die();
            $this->conn->exec($sql);
            $this->conn = null;
        }
        public function delete()
        {
            # code...
            $sql = "DELETE FROM ".$this->tablename." WHERE id =".(int)$this->id;
            $this->conn->exec($sql);
            $this->conn = null;
        }
        public function update()
        {
            # code...
            $sql = "UPDATE ".$this->tablename." SET name = '".$this->name. "' WHERE id = ".(int)$this->id;
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $this->conn = null;
        }
    }

?>