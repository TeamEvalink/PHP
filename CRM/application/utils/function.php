<?php
//获取客户端ip
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

function ajaxreturn($data,$info='',$status=1){
    $result['status']  =  $status;
    $result['info'] =  $info;
    $result['data'] = $data;
    header('Content-Type:text/html; charset=utf-8');
    exit(json_encode($result));
}

function useracl()
{

    $acl_inc = array(); 
    $i=0;
    $acl_inc[$i]['low_title'][] = '选择管理权限';
    $acl_inc[ $i ]['low_leve']['sysadmin'] = array(
        
        "后台设置" =>array(
           "主页"       => 'br1',
        ),
        "data" => array(
            'eqaction_index'  => 'br1',
        )
    );
        
    $acl_inc[$i]['low_leve']['sysuser']= array(
      "管理员管理" =>array(
         "列表"       => 'br1',
         "添加"       => 'br2',
         "修改"       => 'br3',
         "删除"       => 'br4'
         ),
      "data" => array(

          'eqaction_index'  => 'br1',
          'eqaction_getActiveByParam' =>'br1',
          'eqaction_add' =>'br2',
          'eqaction_addActive' =>'br2',
          'eqaction_update' =>'br3',
          'eqaction_Act_update' =>'br3',
          'eqaction_deleteActive' =>'br4',
          )
    );

    $acl_inc[ $i ]['low_leve']['sysacl'] = array(
        
        "用户组管理" =>array(
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4'
        ),
        "data" => array(
            'eqaction_index'  => 'br1',
            'eqaction_getActiveByParam' =>'br1',
            'eqaction_add' =>'br2',
            'eqaction_addActive' =>'br2',
            'eqaction_update' =>'br3',
            'eqaction_Act_update' =>'br3',
            'eqaction_deleteActive' =>'br4',
        )
    );

    $acl_inc[ $i ]['low_leve']['sysmarket'] = array(
        
        "市场渠道模块" =>array( 
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4'
        ),
        "data" => array(
            'eqaction_index'  => 'br1',
            'eqaction_add' =>'br2',
            'eqaction_addActive' =>'br2',
            'eqaction_update' =>'br3',
            'eqaction_updatemarket' =>'br3',
            'eqaction_delete' =>'br4',
        )
    );

    $acl_inc[ $i ]['low_leve']['sysclient'] = array(
        
        "客户管理模块" =>array( 
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4',
           "分配"       => 'br5',
           "小朋友"       => 'br6',
        ),
        "data" => array(
            'eqaction_index'  => 'br1',
            'eqaction_indexForTrue'  => 'br1',
            'eqaction_addClient' =>'br2',
            'eqaction_addActive' =>'br2',
            'eqaction_update' =>'br3',
            'eqaction_updateclient' =>'br3',
            'eqaction_delete' =>'br4',
            'eqaction_share' =>'br5',
            'eqaction_shareActive' =>'br5',
            'eqaction_child' =>'br6',
            'eqaction_childAdd' =>'br6',
            'eqaction_childAddActive' =>'br6',
            'eqaction_delChild' =>'br6',
            'eqaction_updateChild' =>'br6',
            'eqaction_childUpdateActive' =>'br6',
        )
    );

    $acl_inc[ $i ]['low_leve']['sysconnect'] = array(
        
        "联系记录模块" =>array( 
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4',
           "客户列表"   => 'br5',
        ),
        "data" => array(
            'eqaction_indexList'  => 'br1',
            'eqaction_clientConnect'  => 'br1',
            'eqaction_addconnect'  => 'br2',
            'eqaction_addActive'  => 'br2',
            'eqaction_update'  => 'br3',
            'eqaction_updateActive'  => 'br3',
        )
    );
    
    $acl_inc[ $i ]['low_leve']['sysconstract'] = array(
        
        "合同模块" =>array( 
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4',
           "客户列表"   => 'br5',
        ),
        "data" => array(
            'eqaction_index'  => 'br1',
            'eqaction_clientConstract'  => 'br1',
            'eqaction_addConstract'  => 'br2',
            'eqaction_addActive'  => 'br2',
            'eqaction_update'  => 'br3',
            'eqaction_updateActive'  => 'br3',
        )
    );

    $acl_inc[ $i ]['low_leve']['syschild'] = array(
        
        "客户管理模块" =>array( 
           "列表"       => 'br1',
           "添加"       => 'br2',
           "修改"       => 'br3',
           "删除"       => 'br4',
        ),
        "data" => array(            
            'eqaction_index' =>'br1',
            'eqaction_child' =>'br1',
            'eqaction_childAdd' =>'br2',
            'eqaction_childAddActive' =>'br2',            
            'eqaction_updateChild' =>'br3',
            'eqaction_childUpdateActive' =>'br3',
            'eqaction_delChild' =>'br4',
        )
    );



    return $acl_inc;
}

function adminmenu(){
    $i=0;
    $j=0;
    $menu_left = array();
    $menu_left[$i]=array('后台管理菜单','#',1);
    $menu_left[$i]['low_title'][$i."-".$j] = array('系统','javascript:void(0)',1);
    
    $menu_left[$i][$i."-".$j][] = array('用户管理',"sysuser","index",1);
    $menu_left[$i][$i."-".$j][] = array('用户组权限管理',"sysacl","index",1);

    $j++;
    $menu_left[$i]['low_title'][$i."-".$j] = array('市场管理','javascript:void(0)',1);
    $menu_left[$i][$i."-".$j][] = array('市场渠道管理',"sysmarket","index",1);

    $j++;
    $menu_left[$i]['low_title'][$i."-".$j] = array('小朋友管理','javascript:void(0)',1);
    $menu_left[$i][$i."-".$j][] = array('合同管理',"sysconstract","index",1);
    $menu_left[$i][$i."-".$j][] = array('小朋友信息',"syschild","index",1);

    $j++;
    $menu_left[$i]['low_title'][$i."-".$j] = array('客户管理','javascript:void(0)',1);
    $menu_left[$i][$i."-".$j][] = array('Leads管理',"sysclient","index",1);
    $menu_left[$i][$i."-".$j][] = array('客户卡管理',"sysclient","indexForTrue",1);

    $j++;
    $menu_left[$i]['low_title'][$i."-".$j] = array('联系记录','javascript:void(0)',1);
    $menu_left[$i][$i."-".$j][] = array('联系计划',"sysconnect","indexList",1);
    // $menu_left[$i][$i."-".$j][] = array('联系结果',"sysacl","index",1);

    

    return $menu_left;
}

?>
