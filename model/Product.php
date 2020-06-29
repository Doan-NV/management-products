<?php
    class model_Product extends controller_libary_connectDB{
        // protected $tablename = "product";
        protected $tablename = "products";
        protected $queryParameter = [];
        public $id;
        public $name; #tên sản phẩm
        public $cate_id; #id của loại sản phẩm
        public $quantity; # số lượng
        public $price; # giá bán
        public $product_sold; # sản phẩm đã bán được, mặc định = 0.
        public $image; // tên hình ảnh

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
            return $result!=null ? $result : null;
            $this->conn = null;
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
            // var_dump($result);
            return $result!=null ? $result[0] : null;
            $this->conn = null;
        }

        // lấy số lượng bản ghi của 1 trường
        public function selectCount()
        {
            # code...
            $sql = "SELECT COUNT(".$this->queryParameter["SELECT"]
            .") FROM ".$this->tablename." "
            .$this->checkValue($this->queryParameter["WHERE"])
            ." ".$this->queryParameter["OTHER"];
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result != null ? $result[0]['COUNT(id)'] : null;
            $this->conn = null;
        }

        // lấy số lượng bản ghi hiện ra trang : (giới hạn sản phẩm)
        public function selectRecord()
        {
            # code...
            $sql = "SELECT " . $this->queryParameter['SELECT']
            . " FROM " . $this->tablename . " "
            . $this->checkValue($this->queryParameter['WHERE'])
            . " LIMIT " . $this->queryParameter['OTHER'];
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result);
            // die();
            return $result != null ? $result : null;
            $this->conn = null;
        }
        public function insert()
        {
             # code...
             $sql = "INSERT INTO ".$this->tablename." (id_cate, name, quantity, price, productssold, image) VALUE (".$this->cate_id.",'".$this->name."',".$this->quantity.",".$this->price.",".$this->product_sold.",'".$this->image."')";
            //  echo $sql;
            //  die();
             $this->conn->exec($sql);
             $this->conn = null;
        }
        public function update()
        {
            # code...
            $sql = "UPDATE ".$this->tablename." SET id_cate = ".$this->cate_id.", name = '".$this->name."', quantity = ".$this->quantity.", price = ".$this->price.", image = '".$this->image."' WHERE id = ".(int)$this->id;
            // echo $sql;
            // die();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $this->conn = null;

        }
        public function delete()
        {
            # code...
            $sql = "DELETE FROM ".$this->tablename." WHERE id =".(int)$this->id;
            $this->conn->exec($sql);
            $this->conn = null;
        }
        public function deleteAll()
        {
            # code...
            $sql = "DELETE FROM ".$this->tablename." WHERE id_cate =".(int)$this->cate_id;
            $this->conn->exec($sql);
            $this->conn = null;
        }
    }

?>