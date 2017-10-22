<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/30
 * Time: 19:04
 */
require '../lib/init.php';
$action = isset($_GET['a']) ? $_GET['a'] : 'list';

if($action == 'list')
{
    $sql = "select a.id,a.title,a.status,a.create_time,c.title as c_title from
    article as a LEFT JOIN category as c on a.category_id = c.id";
    $article_list = $dao->fetchALL($sql);
    require ADMIN_TEMPLATE_PATH .'article_list.html';
}
elseif($action == 'add')
{
    $sql = "select * from category";
    $category_list = $dao->fetchAll($sql);
    require ADMIN_TEMPLATE_PATH . 'article_add.html';
}
elseif($action == 'insert')
{
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $title = isset($_POST['subject']) ? $_POST['subject'] : '';
    //$cover = isset($_POST['cover']) ? $_POST['cover'] : 'Koala.jpg';
    $summary = isset($_POST['summary']) ? $_POST['summary'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $status = isset($_POST['submit']) ? $_POST['submit'] : '';
    $user_id = $_SESSION['user']['id'];

    require LIB_PATH .'Upload.class.php';
    $tool_upload = new Upload();
    $tool_upload->setUploadPath(UPLOAD_PATH .'cover/');
    $tool_upload->setPrefix('cover_');
    $upload_result = $tool_upload->uploadfile($_FILES['cover']);
    if($upload_result)
    {
        $cover = $upload_result;
    }
    else
    {
        header('Refresh: 3 ;URL=article.php?add');
        echo 'upload error,reupload';
        die;
    }

    if ($category_id == '' || $title =='' || $content =='' || $summary=='')
    {
        die('不能为空');
    }
    $sql = "insert into article values (null,'$title','$content',unix_timestamp(),$user_id,$category_id,'$summary','$cover','$status',0,' ')";
    $res = $dao->query($sql);

    if (!$res)
    {
        echo '插入失败';
        header("Location:article.php?a=add");
    }

    header("Location:article.php?a=list");
}
elseif($action == 'delete')
{
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if($id == '')
    {
        echo '数据获取失败';
    }
    $sql = "delete  from article where id ={$id}";
//    var_dump($sql);
//    die;
    $res = $dao->query($sql);
    if(!$res)
    {
        echo '删除失败';
    }
    header('Location:article.php?a=list');
}
elseif($action == 'edit')
{
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if($id == '')
    {
        echo '获取数据失败';
        exit;
    }
    $sql = "select c.title as category_title,a.id,a.title,a.summary,a.content from category as c LEFT JOIN article as a on c.id = a.category_id where a.id = $id";
    $row = $dao->fetchRow($sql);
    require  ADMIN_TEMPLATE_PATH . 'article_edit.html';
}
elseif($action == 'update')
{
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $title = isset($_POST['subject']) ? $_POST['subject'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $user_id = $_SESSION['user']['id'];
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $summary = isset($_POST['summary']) ? $_POST['summary'] : '';
    $cover = isset($_POST['cover']) ? $_POST['cover'] : 'Koala.jpg';
    $status = isset($_POST['submit']) ? $_POST['submit'] : '';
    if ($category_id == '' || $title =='' || $content =='' || $summary=='')
    {
        die('不能为空');
    }
    //var_dump($id,$title,$content,$user_id,$category_id,$summary,$cover,$status);
    $sql = "update article set title='{$title}',content='{$content}',
            create_time=unix_timestamp(),user_id = $user_id,category_id = $category_id,summary='$summary',
            cover='$cover',status = '$status',is_delete=0,tags=' '  where id=$id";
//    var_dump($sql);
//    die;
    $res = $dao->query($sql);
    if(!$res)
    {
        echo '编辑失败';
    }
    header('Location:article.php?a=list');
}