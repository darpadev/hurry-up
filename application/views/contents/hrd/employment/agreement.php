<?php
    $f_name = $agreement->name;
    $f_type = $agreement->doc_type;

    header("Content-Length: " . strlen($agreement->doc));
    header("Content-Type: $f_type");
    header("Content-Disposition:inline; filename=$f_name");

    echo $agreement->doc;
?>