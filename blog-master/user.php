<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/29
 * Time: 21:46
 */
require  'lib/init.php';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = "status = 'publish'";
if($id)
{
    $where .=" and category_id = $id";
}

$page = isset($_GET['page']) ? $_GET['page'] : '';
if($page <= 0)
{
    $page = 1;
}
$pagesize = 1;
$offset = ($page -1) * $pagesize;
$limit_str = "LIMIT $offset,$pagesize";

$sql = "select * from article where $where $limit_str";

$article_list = $dao->fetchAll($sql);

$sql = "select count(*) as article_count from article where $where";
$row = $dao->fetchRow($sql);
$total = $row['article_count'];
//$total_page = ceil($total/$pagesize);
require LIB_PATH .'Page.class.php';
$tool_page = new Page;
$url_param = [];
if($id !== '')
{
    $url_param['id'] = $id;
}
$page_html = $tool_page->show($page,$pagesize,$total,'user.php',$url_param);
$sql = "select * from category";
$category_list = $dao->fetchAll($sql);

require TMP_PATH .'index.html';