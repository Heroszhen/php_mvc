<?php

function dump(...$contents)
{
    echo "<pre>";
    foreach($contents as $content) {
        var_dump($content);
    }
    echo "</pre>";
}

function dd(...$contents)
{
    dump(...$contents);
    exit;
}