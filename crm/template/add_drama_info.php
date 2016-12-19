<!-- * Created by PhpStorm.-->
<!-- * User: rochestor-->
<!-- * Date: 16/8/7-->
<!-- * Time: 下午7:43-->
<?php include("header.php"); ?>

<div class="container main">
    <div class="row">

        <form id="add_drama_info" class="form-horizontal edit-form" method="POST" action="/app/crm/app/add_drama_info.php"
              enctype="multipart/form-data" role="form">
            <input type="hidden" name="drama_id" value="<?php echo $drama_id;?>">
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
                <label class="col-sm-2 control-label">season</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control season" name="season">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">episode</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control episode" name="episode">
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
<!--            <div class="form-group">-->
<!--                <label class="col-sm-2 control-label">图片</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <!--                        一次上传多张图片-->
<!--                    <input type="file" class="main_pic" name="main_pic[]" multiple="multiple">-->
<!--                </div>-->
<!--            </div>-->

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


//        var drama_type=[];
//        $("input.drama_type").each(function(){
//            if( $(this).attr("checked") === 'checked' ) {
//                tuan_channel.push( $(this).val() );
//            }
//        });
//        tuan_channel = tuan_channel.join(",");

        $("#add_drama_info").submit();



    });


</script>

</body>
