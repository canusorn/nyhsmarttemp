<?php

class Custom_page
{
public $id;
public $user_id;
public $page;
public $url;

public static function getByUSERID($conn, $user_id, $columns = '*')
{
    $sql = "SELECT $columns FROM custom_page WHERE user_id = $user_id";

    $result = $conn->query($sql);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($data);
    return $data;
}

public static function getByID($conn, $id, $columns = '*')
{
    $sql = "SELECT $columns FROM custom_page WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


}