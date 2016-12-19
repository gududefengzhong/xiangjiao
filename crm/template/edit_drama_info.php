<?php include("header.php"); ?>

<div class="container main">
    <div class="row">

        <form id="edit_drama_info" class="form-horizontal edit-form" method="POST" action="/app/crm/app/edit_drama_info.php"
              enctype="multipart/form-data" role="form">
            <input type="hidden" name="id" type="text" value="<?php echo $id;?>">
            <div class="form-group">
                <label class="col-sm-2 control-label">电视剧名称</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['drama_name'];?>" class="form-control drama_name" name="drama_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">电视剧英文名称</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['english_name'];?>" class="form-control english_name" name="english_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">season</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['season'];?>" class="form-control season" name="season">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">episode</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['episode'];?>" class="form-control episode" name="episode">
                </div>
            </div>

<!--            <div class="form-group">-->
<!--                <label class="col-sm-2 control-label">所在区域</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <input type="text" value="--><?php //echo $edit_info['zone'];?><!--" class="form-control zone" name="zone">-->
<!--                </div>-->
<!--            </div>-->
            <div class="form-group">
                <label class="col-sm-2 control-label">百度云地址</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['url'];?>" class="form-control url" name="url">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">网盘密码</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['pan_code'];?>" class="form-control pan_code" name="pan_code">
                </div>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="col-sm-2 control-label">描述</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <textarea value="--><?php //echo $edit_info['brief_desc'];?><!--" class="form-control brief_desc" name="desc">--><?php //echo $edit_info['brief_desc'];?><!--</textarea>-->
<!--                </div>-->
<!--            </div>-->

            <div class="form-group">
                <label class="col-sm-2 control-label">导演</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['director'];?>" class="form-control director" name="director">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">演员</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $edit_info['actors'];?>" class="form-control actors" name="actors">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="javascript:;" id="submit" class="btn btn-info">提交</a>
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
        var show_time = $("input.show_time").val();
        var url = encodeURIComponent( $("input.url").val() );
        var drama_name = encodeURIComponent( $("input.drama_name").val() );
        var director = encodeURIComponent( $("input.director").val() );
        var actors = encodeURIComponent( $("input.actors").val() );

        var data = '';
        if (!drama_name) {
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

        $("#edit_drama_info").submit();



    });


</script>

</body>
