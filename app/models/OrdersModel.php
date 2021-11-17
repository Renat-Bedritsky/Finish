<?php require_once 'app/core/Model.php';

class OrdersModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'orders';
    }

    function AddOrder($user_id, $name, $phone, $email, $products) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)
        $line = $this->getLine();

        $id = $line + 1;
        $operator = '';
        $status = 'get';
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $sql = "INSERT INTO $this->tablename VALUES ('$id', '$user_id', '$name', '$phone', '$email', '$operator', '$products', '$status', '$created_at', '$updated_at')";
        $this->general($sql);
    }

    function GetOrders($operator_name) {
        $result = [];
        $new_orders = $this->getList(['id, name, phone, email, products, status, created_at'], ['status' => 'get']);
        if (!empty($new_orders)) {
            foreach ($new_orders as $key => $path) {
                $new_orders[$key]['products'] = (array)json_decode($path['products']);
            }
        }
        $result['new_orders'] = $new_orders;
        $done_orders = $this->getList(['id, name, phone, email, products, status, updated_at'], ['operator' => $operator_name]);
        if (!empty($done_orders)) {
            foreach ($done_orders as $key => $path) {
                $done_orders[$key]['products'] = (array)json_decode($path['products']);
            }
            $done_orders = array_reverse($done_orders);
        }
        $result['done_orders'] = $done_orders;
        return $result;
    }

    function DoneOrder($operator, $id) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $updated_at = date("Y-m-d H:i:s");
        $sql = "UPDATE $this->tablename SET operator = '$operator' WHERE id = '$id'";
        $this->general($sql);
        
        $sql = "UPDATE $this->tablename SET status = 'done' WHERE id = '$id'";
        $this->general($sql);

        $sql = "UPDATE $this->tablename SET updated_at = '$updated_at' WHERE id = '$id'";
        $this->general($sql);
    }

    function CanceledOrder($operator, $id) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $updated_at = date("Y-m-d H:i:s");
        $sql = "UPDATE $this->tablename SET operator = '$operator' WHERE id = '$id'";
        $this->general($sql);
        
        $sql = "UPDATE $this->tablename SET status = 'canceled' WHERE id = '$id'";
        $this->general($sql);

        $sql = "UPDATE $this->tablename SET updated_at = '$updated_at' WHERE id = '$id'";
        $this->general($sql);
    }

}