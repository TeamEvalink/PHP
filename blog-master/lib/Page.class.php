<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/5/7
 * Time: 16:10
 */
class Page{
/*
 * @param $page
 * @param $pagesize
 * @param $total
 * @param $url
 * @param $url_param
 */
public function show($page,$pagesize,$total,$url,$url_param=array())
{
    $url_info = parse_url($url);
    if(isset($url_info['query']))
    {
        $url .='&';
    }
    else
    {
        $url .='?';
    }
    $url_param['page'] ='';
    $url .=http_build_query($url_param);

    $total_page = ceil($total/$pagesize);

    $first_html =<<<HTML
    <li>
    <a href='{$url}1' aria-label="First">
    <span aria-hidden="true">&laquo;</span>
</a>
</li>
HTML;
    $begin = ($page-2) <1 ? 1 : ($page-2);
    $end = ($page+2) > $total_page ? $total_page : ($page+2);
    $number_html = '';
    for ($i =$begin ; $i<=$end ; ++$i) {
        $active = $page == $i ? 'active' : '';
        $number_html .= <<<HTML
        <li class="$active">
        <a href="$url$i">
        $i
</a>
</li>
HTML;
    }
     $end_html =<<<HTML
    <li>
    <a href="$url$total_page" aria-label="End">
    <span aria-hidden="true">&raquo;</span>
</a>
</li>
HTML;

    return '<ul class="pagination">'.$first_html .$number_html .$end_html .'</ul>';

}

}