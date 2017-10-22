<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/30
 * Time: 16:39
 */
require 'lib/init.php';
$id = isset($_GET['id']) ? $_GET['id'] : '';
if($id == '')
{
    die("传值有问题");
}
$sql = "select * from article where id={$id}";

$article = $dao->fetchRow($sql);

require TMP_PATH .'article.html';
