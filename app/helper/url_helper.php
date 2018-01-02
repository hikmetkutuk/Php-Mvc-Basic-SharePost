<?php
/**
 * Created by PhpStorm.
 * User: hikmetis
 * Date: 12/31/17
 * Time: 8:14 PM
 */

//Simple page
function redirect($page)
{
    header('location: '.URLROOT.'/'.$page);
}