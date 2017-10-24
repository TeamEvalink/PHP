
<div class="col-sm-3 col-md-2 sidebar">
          <?php
          foreach($menu_left as $key => $menu_1) {
             foreach($menu_1['low_title'] as $key2 => $menu_2) {
              if($menu_2[2]==0) continue;//隐藏菜单不显示
          ?>
          <ul class="nav nav-sidebar">
            <li><a href="<?php echo $menu_2[1];?>"><?php echo $menu_2[0];?></a></li>
            
            <?php
            foreach($menu_1[$key2] as $key3 => $menu_3) {
              //echo $menu_3[3];
            if($menu_3[3]==0) continue;//隐藏菜单不显示
            ?>
            <li <?php if($menu_3[1]==$this->uri->rsegment(1) && $menu_3[2]==$this->uri->rsegment(2)){echo "class='active'";}?>><a href="<?php echo site_url("/".$menu_3[1]."/".$menu_3[2])?>"><?php echo $menu_3['0'];?></a></li>
             <?php }?>

          </ul>
          <?php }}?>
</div>
<script type="text/javascript">

  $(document).ready(function(){
    $(".nav li:first-child").click(function(){
        $(this).nextAll().slideToggle();
    });
  });
</script>