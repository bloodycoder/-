<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

<style type="text/css">
@charset "utf-8";
*{font:normal 12px/2em '微软雅黑';padding:0;margin:0}
ul,li{list-style:none}
a{ color:#09f;}
/*容器*/
#xzw_starBox{position:relative;width:120px;float:left}
/**/
#xzw_starSys .description{clear:both;padding:10px 0px}
#xzw_starSys .star{height:20px;width:120px;position:relative;background:url('http://localhost/application/views/pingke/images/123.png') repeat-x;cursor:pointer}
#xzw_starSys .star li{float:left;padding:0px;margin:0px}
#xzw_starSys .star li a{display:block;width:24px;height:20px;overflow:hidden;text-indent:-9999px;position:absolute;z-index:5}
#xzw_starSys .star li a:hover{background:url('http://localhost/application/views/pingke/images/123.png') 0 -25px repeat-x;z-index:3;left:0}
#xzw_starSys .star a.one-star{left:0}
#xzw_starSys .star a.one-star:hover{width:24px}
#xzw_starSys .star a.two-stars{left:24px}
#xzw_starSys .star a.two-stars:hover{width:48px}
#xzw_starSys .star a.three-stars{left:48px}
#xzw_starSys .star a.three-stars:hover{width:72px}
#xzw_starSys .star a.four-stars{left:72px}
#xzw_starSys .star a.four-stars:hover{width:96px}
#xzw_starSys .star a.five-stars{left:96px}
#xzw_starSys .star a.five-stars:hover{width:120px}
#xzw_starSys .current-rating{background:url('http://localhost/application/views/pingke/images/123.png') 0 -25px repeat-x;position:absolute;height:20px;z-index:1;top:0;left:0}

</style>

<script type="text/javascript">
//star
$(document).ready(function(){
    var stepW = 24;
    var description = new Array("很差","良","一般","好","优秀");
    var stars = $("#star > li");
    var descriptionTemp;
    $("#showb").css("width",0);

    stars.each(function(i){
        $(stars[i]).hover(
            function(){
                $(".description").text(description[i]);
            },
            function(){
                if(descriptionTemp != null)
                    $(".description").text(""+descriptionTemp);
                else 
                    $(".description").text(" ");
            }
        );
    });
});
function stopDefault(e){
    if(e && e.preventDefault)
           e.preventDefault();
    else
           window.event.returnValue = false;
    return false;
};
</script>

</head>
<body>
<div id="xzw_starSys">
    <div id="xzw_starBox">
        <ul class="star" id="star">
            <li><a href= <?php echo "\"/pingke_index/score/";echo $pig;echo "/1/\""?> title="1" class="one-star">1</a></li>
            <li><a href=<?php echo "\"/pingke_index/score/";echo $pig;echo "/2/\""?> title="2" class="two-stars">2</a></li>
            <li><a href=<?php echo "\"/pingke_index/score/";echo $pig;echo "/3/\""?> title="3" class="three-stars">3</a></li>
            <li><a href=<?php echo "\"/pingke_index/score/";echo $pig;echo "/4/\""?> title="4" class="four-stars">4</a></li>
            <li><a href=<?php echo "\"/pingke_index/score/";echo $pig;echo "/5/\""?> title="5" class="five-stars">5</a></li>
        </ul>
        <div class="current-rating" id="showb"></div>
    </div>
    <div class="description"></div>
</div>  


</body>
</html>