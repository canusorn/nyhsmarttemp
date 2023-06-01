<?php

require 'includes/header.php';

$all_projects = Projectname::getAll($conn);
// var_dump($all_projects);

foreach ($data as $key => $value) {
    $this_projects = explode(",", $value["project_id"]);
    // var_dump($projects);
    foreach ($all_projects as $project_id => $project) {
        foreach ($this_projects as $this_project) {
            if ($project["project_id"] == $this_project) {
                $all_projects[$project_id]['esp_id'][] =  ["esp_id"=>$value['esp_id'],"name"=>$value['device_name']];
            }
        }
    }
}
// var_dump($all_projects);

?>




<?php require 'includes/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("a[href='group.php']").addClass("active");
        $("a[href='group.php']").parent().addClass("menu-open");
    });
</script>