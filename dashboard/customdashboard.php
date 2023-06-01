<?php

require 'includes/header.php';

if (isset($_GET['p'])) {

  $page = Custom_page::getByID($conn, $_GET['p']);
  // var_dump($page);
  if (!empty($page)) {

    // no Authorization
    if ($page['user_id'] != $_SESSION['user_id']) {
      Auth::block();
    }

    require_once 'includes/custom/' . $page['url'];
  }
} else {
?>

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="d-flex flex-row bd-highlight mb-3">
            <h1 class="m-0 text-dark text-dark">ไม่พบหน้าที่ท่านต้องการ</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>




<?php require 'includes/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {
    $("a[href='customdashboard.php?p=<?= $_GET['p'] ?>']").addClass("active");
  });
</script>