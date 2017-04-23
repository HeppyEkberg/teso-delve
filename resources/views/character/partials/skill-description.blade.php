<?php
    $description = str_ireplace('|cffffff', '<span class="text-white">', $description);
    $description = str_ireplace('|r', '</span>', $description);
    $description = str_ireplace('\n', '', $description);
?>

{!! nl2br($description) !!}