<?php
class Auth
{

    public static function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {

            if (!isset($_SESSION['skey'])) {
                $_SESSION['skey'] = self::randomString();
            }

            return true;
        } else if (isset($_COOKIE["user_id"])) {
            self::login($_COOKIE["user_id"]);

            if (!isset($_SESSION['skey'])) {
                $_SESSION['skey'] = self::randomString();
            }

            return true;
        }
    }


    public static function canView($esp_id, $devicelist)
    {
        if ($devicelist[0]['position'] == "admin") return true;

        foreach ($devicelist as $d) {
            if (array_search($esp_id, $d)) return true;
        }
        return false;
    }


    public static function requireLogin()
    {
        if (!static::isLoggedIn()) {
            require '../classes/Url.php';
            Url::redirect('/login.php');
        }
    }


    public static function login($user_id)
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user_id;
        $_SESSION['skey'] = self::randomString();

        setcookie("user_id", $user_id, time() + 3600 * 24 * 7); // Expire 7 day
    }


    public static function logout()
    {
        $_SESSION = [];

        setcookie("user_id", 0, time() - 100); // delete

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public static function getUserIP()
    {
        //check ip from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //to check ip is pass from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function block()
    {

        self::saveLogNoAuth();

        header("HTTP/1.1 403 Forbidden");
        exit;
    }

    public static function saveLogNoAuth($ps = "nodata")
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/log.db");
        self::createAuthTableLog($pdo);

        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new DateTime();
        $time = $dateTime->format('Y-m-d H:i:s');

        $ip = self::getUserIP();

        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST)) {
            $request = "";
            foreach ($_POST as $key => $value) {
                $request .= $value . ", ";
            }
        } else if (isset($_SERVER['REQUEST_URI'])) {
            $request = $_SERVER['REQUEST_URI'];
        } else {
            $request = "no data";
        }

        $sql = "INSERT INTO 'auth' VALUES(:time,:ip,:request,:ps)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':time', $time, PDO::PARAM_STR);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindValue(':request', $request, PDO::PARAM_STR);
        $stmt->bindValue(':ps', $ps, PDO::PARAM_STR);
        return $stmt->execute();
    }

    private static function createAuthTableLog($pdo)
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'auth' . '\'(
	                                    time TEXT NOT NULL,
                                        ip TEXT,
                        	            request	TEXT,
                        	            ps	TEXT
                                        )',
        ];
        //var_dump($commands);

        // execute the sql commands to create new tables
        $error = [];
        foreach ($commands as $command) {
            if (!$pdo->exec($command)) {
                $error[] = 1;
            }
        }
        if (empty($error)) {
            return true;
        }
    }

    public static function randomString($length = 10)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
