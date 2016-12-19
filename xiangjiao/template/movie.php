<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>电影资源</title>
    <meta name="keywords" content="视频资源,电影资源,电视剧,日剧,美剧,韩剧,云盘">
    <meta name="description" content="香蕉视频搜集来自互联网的最新的电影,电视剧资源">
    <meta name="author" content="rochestor">
    <link href="../css/layout.css" rel="stylesheet" type="text/css">
    <link href="../css/movie.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--顶部导航-->
<div class="navbar">
    <div class="navbar-container">
        <div class="logo"><a href="index.php" target="_blank" class="navbar-logo" title="香蕉影视">香蕉影视</a></div>
        <div class="menu">
            <ul>
                <li><a href="index.php">首页</a></li>
                <li><a href="movie.html" class="active">电影</a></li>
                <li><a href="drama.php">电视剧</a></li>
                <!--<li><a href="">综艺节目</a></li>-->
                <li><a href="about.php">关于我们</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <!--顶部轮播图-->
    <div class="slider">
        <ul class="carousel" id="carousel">
            <?if( $carousel_list ) {?>
                <?php foreach( $carousel_list as $k => $v ) {?>
                    <li style="background-image: url(<?php echo explode(",",$v['main_pic'])[0];?>);">
                        <div class="inner">
                            <h1><?php echo $v['movie_name'];?></h1>
                            <a class="btn" target="_blank" href="<?php echo $detail_url."?id=".$v['id'];?>">去百度云在线看</a>
                        </div>
                    </li>
                <?php }}?>

        </ul>
        <ol class="dots" id="dots">
            <li class="dot">1</li>
            <li class="dot">2</li>
            <li class="dot">3</li>
            <li class="dot">4</li>
            <li class="dot">5</li>
        </ol>

    </div>

    <!--搜索条件-->
    <div class="search-info clearfix" id="search-info">
        <dl>
            <dt>区域</dt>
            <?php foreach($zone_list as $k => $v ) {?>
                <dd class="zone <?php echo $v == $zone ? 'selected' : '';?>"><a href="<?php echo "movie.php?"."zone=".$v;?>"><?php echo $v;?></a></dd>
            <?php }?>
        </dl>
        <dl>
            <dt>年代</dt>
            <?php foreach($year_list as $k => $v ) {?>
                <dd class="show_time <?php echo $v == $year ? 'selected' : '';?>"><a href="<?php echo "movie.php?"."year=".$v;?>"><?php echo $v;?></a></dd>
            <?php }?>
        </dl>
        <dl>
            <dt>类型</dt>
            <?php foreach($movie_types as $k => $v ) {?>
                <dd class="movie_type <?php echo $v == $movie_type ? 'selected' : '';?>"><a href="<?php echo "movie.php?"."movie_type=".$v;?>"><?php echo $v;?></a></dd>
            <?php }?>
        </dl>
    </div>

    <!--内容主题-->
    <div class="main-content" id="main">
        <ul class="index-list clearfix">
            <?php foreach( $movie_info as $k => $v ) {?>
                <li class="clearfix">
                    <a  href="<?php echo $detail_url."?id=".$v['id'];?>" target="_blank" class="index-img">
                        <img src="<?php echo explode(",", $v['main_pic'])[0];?>" alt="三个女人的高潮" />
                        <div class="bottom-cover">
                            <span class="film-time"></span>
                        </div>
                    </a>
                    <div class="index-text">
                        <h1><a target="_blank" href="<?php echo $detail_url."?id=".$v['id'];?>"><?php echo $v['movie_name'];?> </a></h1>
                        <div class="index-con">
                            <div class="rating" data-score=""></div>
                        </div>
                        <div class="index-intro">
                            <?php echo $v['brief_desc'];?>
                        </div>
                        <div class="index-more"><a target="_blank" href="javascript:;">阅读全文...</a>
                        </div>
                        <div class="index-like clearfix"><span class="time"><?php echo date("Y-m-d");?></span>
                            <div class="post-ope"><span class="post-comment"></span> <span class="post-like"></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php }?>
        </ul>
    </div>
    <div class="side" id="right-side">
        <div class="post-right-item">
            <h4 class="post-right-title">百度云电影排行</h4>
            <ul class="hot-list">
                <?php if( $movie_rank && is_array( $movie_rank ) ) { ?>
                    <?php foreach( $movie_rank as $k => $v ) {?>
                        <li><a href="<?php echo $detail_url."?id=".$v['id'];?>" target="_blank" title="<?php echo $v['title']; ?>"><span class="hot-num"><?php echo $k + 1;?></span><?php echo $v['movie_name'];?></a></li>
                    <?php }}?>
            </ul>
        </div>
        <div class="post-right-item">
            <h4 class="post-right-title">百度云电影推荐</h4>
            <ul class="hot-list">
                <?php if( $movie_recommend && is_array( $movie_recommend ) ) { ?>
                    <?php foreach( $movie_recommend as $k => $v ) { ?>
                        <li><a href="<?php echo $detail_url."?id=".$v['id'];?>" target="_blank" title="<?php echo $v['title'];?>"><span class="hot-num"><?php echo $k + 1;?></span><?php echo $v['title'];?></a></li>
                    <?php  }}?>
            </ul>
        </div>
        <!--关注我们-->
        <div id="post-right-item" class="post-right-item">
            <h4 class="post-right-title">关注我们</h4>
            <div class="follow-title">
                <p>微信公众平台：</p>
                <p>扫描下方的二维码</p>
            </div>
            <div class="follow-2wm">
                <img src="../image/weixin.jpg" alt="微信二维码" width="224" height="240">
                <span></span>
            </div>
        </div>
        <!--打赏小编-->
        <div id="donate" class="post-right-item clearfix">
            <h4 class="post-right-title">捐赠站长</h4>
            <p>小额资助,站长跟你生猴子</p>
            <ul class="platform-type clearfix">
                <li class="active"><a href="javascript:;">微信</a></li>
                <li><a href="javascript:;">支付宝</a></li>
            </ul>
            <div class="money-range">
                <ul class="money-range">
                    <li><img src="../image/wechat_pay2_1.jpg" alt="微信2元"></li>
                    <li class="dn"><img src="../image/alipay2_1.jpg" alt="支付宝2元"></li>
                </ul>
            </div>
        </div>
    </div>


</div>
<!--页脚,版权信息-->
<div class="footer" id="footer">
    <a href="javascript:;" >关于我们</a>
    <a href="javascript:;" >联系我们</a>
    <a href="javascript:;" >版权声明</a>
    <a href="javascript:;" >网友投稿</a>
    <div class="tip">本站所有资源均来自于网络<br />如涉及版权问题,希望删除相关信息,请发送邮件到2276329692@qq.com,我们会在确认后尽快处理.<br />Copyright © 2015-2016 香蕉影视，百度云资源
    </div>
</div>
<!--回到顶部-->
<div class="go-top dn" id="go-top">
    <a href="javascript:;" class="uc-2wm"></a>
    <div class="uc-2wm-pop dn"></div>
    <a href="javascript:;" class="go"></a>
</div>


<script src="../script/movie.js"></script>
</body>
</html>


