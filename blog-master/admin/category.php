<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/30
 * Time: 21:52
 */
require '../lib/init.php';
$action = isset($_GET['a']) ? $_GET['a'] : 'list';

if($action == 'list')
{
    $sql = "select * from category";
    $category_list = $dao->fetchAll($sql);

    require  ADMIN_TEMPLATE_PATH .'category_list.html';
}
elseif($action == 'delete')
{
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if($id == '')
    {
        echo '获取数据失败';
    }
    $sql = "delete from category where id = $id";
    $res = $dao->query($sql);
    if(!$res)
    {
        echo '删除失败';
    }
    header('Location:category.php?a=list');
}
elseif($action == 'add')
{
    require ADMIN_TEMPLATE_PATH .'category_add.html';
}
elseif($action == 'insert')
{
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $order_number = isset($_POST['order_number']) ? $_POST['order_number'] : '';
    if($title == '' || $order_number == '')
    {
        echo '数据传错';
        header('Location:category.php?a=list');
    }
    $sql = "insert into category values (null,'$title',$order_number)";
    $res = $dao->query($sql);
    if(!$res)
    {
        echo '添加失败';
    }
    header('Location:category.php?a=list');

}
elseif($action == 'edit')
{
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $sql = "select * from category where id = $id";
    $row = $dao->fetchRow($sql);
    require  ADMIN_TEMPLATE_PATH .'category_edit.html';
}
elseif($action == 'update')
{
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $order_number= isset($_POST['order_number']) ? $_POST['order_number'] : '';
    $sql = "update category set title='$title',order_number=$order_number where id=$id";
//    var_dump($sql);
//    die;
    $res = $dao->query($sql);
    if(!$res)
    {
        echo '更新失败';
    }
    header('Location:category.php?a=list');
}
