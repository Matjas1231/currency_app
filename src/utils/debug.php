<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

function dump($data)
{
    echo('</br><div style="
            display: inline-block;
            border: 1px dashed gray;
            padding: 5px;
            background:lightgray;">
            <pre>');

    print_r($data);

    echo('</pre> </div> </br>');
}
function dd($data)
{
    echo('</br><div style="
            display: inline-block;
            border: 1px dashed gray;
            padding: 5px;
            background:lightgray;">
            <pre>');

    print_r($data);

    echo('</pre> </div> </br>');
    exit('STOP');
}
