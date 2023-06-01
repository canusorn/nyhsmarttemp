<?php

/**
 * User
 *
 * A person or entity that can log in to the site
 */
class User
{

    public $user_id;
    public $email;
    public $pass;
    public $pass2;
    public $terms_agreed;
    public $errors = [];

    /**
     * Authenticate a user by username and password
     *
     * @param object $conn Connection to the database
     * @param string $username Username
     * @param string $password Password
     *
     * @return user_id
     */

    public static function authenticate($conn, $email, $pass)
    {
        $sql = "SELECT *
                FROM user
                WHERE email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt->execute();

        if ($user = $stmt->fetch()) {
            // var_dump($user);
            if (password_verify($pass, $user->pass)) {
                return $user->user_id;
            } else {
                return "Wrong password";
            }
        } else {
            return "no email";
        }
    }

    protected function validate()
    {
        if ($this->email == '') {
            $this->errors[] = "ต้องระบุอีเมลล์";
        }
        if ($this->pass == '') {
            $this->errors[] = "ต้องระบุรหัสผ่าน";
        } else {
            if ($this->pass2 == '') {
                $this->errors[] = "ต้องระบุรหัสผ่านอีกครับ";
            } else if ($this->pass != $this->pass2) {
                $this->errors[] = "รหัสผ่านไม่ตรงกัน";
            }
        }
        if (is_null($this->terms_agreed)) {
            $this->errors[] = "โปรดอ่านเงื่อนไข และกดยอมรับ";
        }

        return empty($this->errors);
    }

    public function create($conn)
    {
        if ($this->validate()) {

            $sql = "INSERT INTO user(email, pass)
                    VALUES (:email, :pass)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $passhash = password_hash($this->pass, PASSWORD_DEFAULT);
            $stmt->bindValue(':pass', $passhash, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->user_id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }

    public function update($conn)
    {
        // var_dump($this->pass);
        // exit;
        $sql = "UPDATE user
                SET email = :email";

        if (!is_null($this->pass)) {
            $sql .= ", pass = :pass ";
        }

        $sql .= " WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);

        if (!is_null($this->pass)) {
            $passhash = password_hash($this->pass, PASSWORD_DEFAULT);
            $stmt->bindValue(':pass', $passhash, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public static function getEmail($conn, $user_id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM user
                WHERE user_id = $user_id";
        $result = $conn->query($sql);
        $email = $result->fetchAll(PDO::FETCH_ASSOC);
        return $email[0]['email'];
    }
}
