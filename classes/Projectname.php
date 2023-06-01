<?php
class Projectname
{

    public static function getName($conn, $project_id)
    {
        $sql = "SELECT project_name
        FROM project_id
        WHERE project_id = :project_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result;
        }
    }

    public static function getAll($conn)
    {
        $sql = "SELECT * FROM project_id";
        $result = $conn->query($sql);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
