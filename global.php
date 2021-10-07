<?php

function formatReal($val)
{
    return "R$ ".number_format($val, 2, ',', ' ');
}

?>