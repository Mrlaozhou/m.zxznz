<?php if (!defined('THINK_PATH')) exit();?>
<?php require_once('/Public/Home/header.html');?>


<style type="text/css">
.pblh{

}

.pblh-content{
  width:1000px ;
  height:2160px;
  margin:0 auto;

}

.pblh-line{
  width:50px ;
  margin:10px 0;
  border-top:1px solid #aaa;
  border-bottom:1px solid #aaa;
}

.pblh-hover a {
    color:#444444;
}

.pblh-list2{display:none;width:100%;height:480px;margin-top:60px;}

.hover_type_1{width:190px;height:230px;padding:0 20px;position:absolute;top:0 ;left: 0;background:;}
.hover_type_2{width:190px;height:230px;padding:0 20px;position:absolute;top:0 ;right: 0;background:;}
.hover_type_3{width:190px;height:230px;padding:0 20px;position:absolute;bottom:0 ;right: 0;background:;}
.hover_type_4{width:190px;height:230px;padding:0 20px;position:absolute;bottom:0 ;left: 0;background:;}
</style>


<div class="pblh">
  <div class="pblh-top">
    <img style="width:100%;height:230px;" src="/Public/Home/images/pblh-bg.jpg">
  </div>
    <div class="pblh-content">
      <?php foreach( $data as $k => $v ):?>
        <div class="pblh-list<?php echo $k+1;?>" style="width:100%;height:480px;margin-top:60px;">
          <div class="floatL" style="width:480px;height:480px;background-image:url(/Public/Uploads/<?php echo $v[0]['bg'];?>);position: relative;">
            <div class="pblh-hover hover_type_<?php echo $v[0]['bg_type'];?>" style="">
                <p style="height:40px;font-size: 40px;padding-top:20px;"><?php echo date('Y.m',$v[0]['begin']);?></p>
                <div class="pblh-line"></div>
                <p style="line-height:20px;">
                    <a target="_blank" href="<?php echo U($v[0]['action']."?navNum=4");?>">
                      <span style="font-weight:bold;font-size:16px;">
                      <?php echo $v[0]['title'];?>
                      </span><br />
                      <?php echo $v[0]['intro'];?> 
                    </a>
                </p>
            </div>
          </div>
          <?php if( $v[1] ):?>
          <div class="floatR" style="width:480px;height:480px;background-image:url(/Public/Uploads/<?php echo $v[1]['bg'];?>);position: relative;">
            <div class="pblh-hover hover_type_<?php echo $v[1]['bg_type'];?>" style="">
                <p style="height:40px;font-size: 40px;padding-top:20px;"><?php echo date('Y.m',$v[1]['begin']);?></p>
                <div class="pblh-line"></div>
                <p style="line-height:20px;">
                    <a target="_blank" href="<?php echo U($v[1]['action']."?navNum=4");?>">
                      <span style="font-weight:bold;font-size:16px;">
                      <?php echo $v[1]['title'];?>
                      </span><br />
                      <?php echo $v[1]['intro'];?> 
                    </a>
                </p>
            </div>
          </div>
          <?php endif;?>
          <div class="clear"></div>
        </div>
        <?php endforeach;?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
      $(window).scroll(function(){
      var h = $(window).scrollTop();
      if(h >= 300)
      {
        $('.pblh-list2').show('slow');
      }
      if( h>=830 )
      {
        $('.pblh-list3').show('slow');
      }
      if( h>=1400 )
      {
        $('.pblh-list4').show('slow');    
      }
    });
      $('.pblh-hover').bind({'mouseover':function(){
          $(this).css('cursor','pointer');
          $(this).css('color','white');
          $(this).find('a').css('color','white');
          $(this).css('background','#444444');
      },'mouseout':function(){
          $(this).css('color','#444444');
          $(this).find('a').css('color','#444444');
          $(this).css('background','white');
      }});
  })
</script>



<?php require_once('/Public/Home/footer.html');?>