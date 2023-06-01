<?php
require '../includes/init.php';

if (!empty($_REQUEST)) {  //get code
    // var_dump($_REQUEST);
    if (isset($_REQUEST['id'])) {

        Linenotify::getCode($_REQUEST['id']);
    } else if (isset($_REQUEST['code']) && isset($_REQUEST['state'])) {  // get access token

        $line = Linenotify::getAccessToken();
        // var_dump($line);exit;
        if ($line['status'] == 200) {

            $db = new Database();
            $conn = $db->getConn();

            $esp_id = Esp_ID::getByESPID($conn, $_REQUEST['state']);
?>



            <!DOCTYPE html>
            <html lang="en">

            <head>
            </head>

            <!-- jQuery -->
            <script src="includes/plugins/jquery/jquery.min.js"></script>

            <script type="text/javascript">
                $.post('ajax/setting.php', {
                        id: <?= $_REQUEST['state'] ?>,
                        p_id: <?= $esp_id->project_id ?>,
                        linetoken: "<?= $line['access_token']; ?>",
                        dailynotify: 1
                    })
                    .done(function(response) {

                        if (response) {
                            alert('บันทึก Line token สำเร็จแล้ว');
                            window.close();
                        } else {
                            alert('! บันทึก Line token ไม่สำเร็จ โปรดลองใหม่อีกครั้งครับ');
                            window.close();
                        }
                    })
                    .fail(function() {
                        alert('! บันทึก Line token ไม่สำเร็จ โปรดลองใหม่อีกครั้งครับ');
                        window.close();
                    });
            </script>

            </body>

            </html>



<?php
        }
    }
}
