<!-- * Created by PhpStorm.-->
<!-- * User: rochestor-->
<!-- * Date: 16/8/7-->
<!-- * Time: 下午7:43-->
<?php include("header.php"); ?>

<div class="container main">
    <div class="row">

        <form id="add_drama" class="form-horizontal edit-form" method="POST" action="/app/crm/app/add_drama.php"
              enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">电视剧名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control drama_name" name="drama_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">电视剧英文名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control english_name" name="english_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">类型</label>
                <div class="col-sm-10">
                    <input class="drama_type" name="drama_type[]" type="checkbox" value="juqing"> 剧情
                    <input class="drama_type" name="drama_type[]" type="checkbox" value="love"> 爱情
                    <input class="drama_type" name="drama_type[]"type="checkbox" value="comedy"> 喜剧
                    <input class="drama_type" name="drama_type[]" type="checkbox" value="action"> 动作
                    <input class="drama_type" name="drama_type[]" type="checkbox" value="lunli"> 伦理
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="kehuan"> 科幻
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="kongbu"> 恐怖
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="jilu"> 记录
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="fanzui"> 犯罪
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="xuanyi"> 悬疑
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="donghua"> 动画
                    <input class="drama_type" type="checkbox" name="drama_type[]" value="zhanzheng"> 战争
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">所在区域</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control zone" name="zone">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">百度云地址</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control url" name="url">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">网盘密码</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control pan_code" name="pan_code">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">描述</label>
                <div class="col-sm-10">
                    <textarea class="form-control brief_desc" name="desc"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">图片</label>
                <div class="col-sm-10">
                    <!--                        一次上传多张图片-->
                    <input type="file" class="main_pic" name="main_pic[]" multiple="multiple">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">主标题</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control title" name="title">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">副标题</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control short_title" name="short_title">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">导演</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control director" name="director">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">演员</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control actors" name="actors">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="javascript:;" id="submit" class="btn btn-default submit">提交</a>
                </div>
            </div>

        </form>
    </div>
</div>
<script src="../js/jquery-3.1.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/index.js"></script>
<script>
    $("#submit").on("click",function(){

        var row_id = $("input.row_id").val();
        var title = encodeURIComponent($("input.title").val());
        var short_title = encodeURIComponent($("input.short_title").val());
        var zone = encodeURIComponent($("input.zone").val());
        var show_time = $("input.show_time").val();
        var main_pic = $("input.main_pic").val();
        var url = encodeURIComponent( $("input.url").val() );
        var drama_name = encodeURIComponent( $("input.drama_name").val() );
        var director = encodeURIComponent( $("input.director").val() );
        var actors = encodeURIComponent( $("input.actors").val() );
        var english_name = encodeURIComponent( $("input.english_name").val() );

        if (!drama_name || !english_name) {
            alert("电影名称不能为空");
            return false;
        }
        if (!url) {
            alert("百度云地址不能为空");
            return false;
        }
        if ( !title || !short_title ) {
            alert("标题不能为空");
            return false;
        }

//        var drama_type=[];
//        $("input.drama_type").each(function(){
//            if( $(this).attr("checked") === 'checked' ) {
//                tuan_channel.push( $(this).val() );
//            }
//        });
//        tuan_channel = tuan_channel.join(",");

        $("#add_drama").submit();



    });


</script>

</body>
