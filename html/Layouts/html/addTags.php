<?php
$result = $this->model->selectTags();
echo "<form action=\"#\" method=\"post\">";
for($j=0;$j<3;$j++) {
    echo "<select>";
    echo "<option value=\"none\">Select a Tag</option>";
    foreach ($result as $item) {
        echo "<option value=\"" . $item['name'] . "\">" . $item['name'] . "</option>";
    }
    echo "</select>";
}