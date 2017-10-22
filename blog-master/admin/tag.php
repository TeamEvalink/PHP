<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/5/1
 * Time: 15:05
 */
require  '../lib/init.php';
$action = isset($_GET['a']) ? $_GET['a'] : 'list';
if($action == 'list')
{
    require ADMIN_TEMPLATE_PATH .'tag_list.html';
}