<!--
* Created by PhpStorm.
 User: rochestor
 Date: 16/8/5
 Time: 上午2:00
 -->
<?php include("header.php");?>

<div class="container main">
    <div class="row">
        <?php include("left_side.php");?>
        <div class="col-sm-10 content">
            <div><a class="btn btn-info add" id="add_movie" target="_blank" href="add_movie.php">新建</a></div>
            <!--        查询条件-->
            <form action="index.php" method="get" class="form-inline search-form" role="form">
                <div class="form-group">
                    <label>区域</label>
                    <input type="text" name="zone" value="<?php echo $zone?>" placeholder="请输入区域">
                    <label>类型</label>
                    <input type="text" name="movie_type" value="<?php echo $movie_type;?>" placeholder="请输入电影类型">
                    <label>上映时间</label>
                    <input type="text" name="show_time" value="<?php echo $show_time;?>" placeholder="请输入电影上映时间">
                    <input type="submit" class="btn btn-info" value="查询">
                    <input id="clear" type="button" class="btn btn-info" value="重置">
                    <input type="button" class="btn btn-info" name="re_arrange" value="排序">
                </div>
            </form>

            <!--        电影展示-->
            <table class="table table-hover table-striped">
                <!--            <caption>悬停表格布局</caption>-->
                <thead>
                <tr>
                    <th>操作</th>
                    <th>名称</th>
                    <th>区域</th>
                    <th>类型</th>
                    <th>上映时间</th>
                    <th>导演</th>
                    <th>演员</th>
                    <th>创建时间</th>
                    <th>排序</th>
                </tr>
                </thead>
                <tbody>
                <?php if( $movie_info && is_array( $movie_info ) ) {?>
                <?php foreach ($movie_info as $k => $v) { ?>
                    <tr>
                        <td>
                            <a href="../app/edit_movie.php?id=<?php echo $v["id"];?>" title="编辑" data_id="<?php echo $v['id']; ?>"
                               class="btn btn-info edit">编辑</a>
                            <a href="javascript:;" title="删除" data_id="<?php echo $v['id']; ?>"
                               class="btn btn-info del">删除</a>
                        </td>
                        <td><?php echo $v["movie_name"]; ?></td>
                        <td><?php echo $v["zone"]; ?></td>
                        <td><?php echo $v["movie_type"]; ?></td>
                        <td><?php echo $v["show_time"]; ?></td>
                        <td><?php echo $v["director"]; ?></td>
                        <td><?php echo $v["actors"]; ?></td>
                        <td><?php echo $v["create_time"]; ?></td>
                        <td><input style="width: 50px;" type="text" name="display-order"
                                   value="<?php echo $v["display_order"]; ?>"></td>

                    </tr>
                <?php } }?>
                </tbody>
            </table>

            <!--            分页-->
            <div class="paging clearfix">
                <ul class="pagination">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>


            <!--        编辑or添加-->
        </div>
    </div>
</div>
<div class="footer" id="footer">
    <p>线上操作需谨慎</p>
    <p>Copyright &copy;2016 All rights reversed, yes all of them</p>
</div>


<script src="../js/jquery-3.1.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/index.js"></script>
<script>

    $(function () {

        $(".edit").each(function () {
            var row_id = $(this).attr("data_id");
            console.log(row_id);
            $(this).on("click", function () {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "/app/crm/app/index_ajax.php?action=get_info",
                    data: "row_id=" + row_id,
                    success: function (msg) {
                        if (msg.ok) {
                            console.log((msg.msg));
                            var movie_info = msg.msg;
                            var movie_type = movie_info.movie_type;
                            console.log(movie_type);
                            $("input.movie_type").prop("checked","");
                            //复选框勾选
                            $("input.movie_type").each(function () {
                                //检查this.val()  在不在  product_info.tuan_channel里面,在的话，默认其勾选状态
//                                            console.log( $(this).val() );
//                                            console.log( location_type );
                                if (movie_type.indexOf($(this).val()) !== -1) {
                                    $(this).prop("checked", "checked");
                                }

                            });
                            $("input.row_id").val(movie_info.id);
                            $("input.movie_name").val(movie_info.movie_name);
                            $("input.show_time").val(movie_info.show_time);
                            $("input.zone").val(movie_info.zone);
                            $("input.url").val(movie_info.url);
                            $("input.brief_desc").val(movie_info.brief_desc);
                            $("input.title").val(movie_info.title);
                            $("input.short_title").val(movie_info.short_title);
                            $("input.director").val(movie_info.director);
                            $("input.actors").val(movie_info.actors);


                        } else {
//                            autoLayer("获取信息失败", delay);
                            alert("操作失败!");
                        }
                    }
                });
            });
        });

        //新建
        $("#add_movie").on("click", function () {
            clear_all();
        });

        //删除
        $(".del").each(function () {
            var row_id = $(this).attr("data_id");
            $(this).on("click", function () {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "/app/crm/app/index_ajax.php?action=delete",
                    data: "row_id=" + row_id,
                    success: function (msg) {
                        if (msg.ok) {
                            console.log((msg.msg));
                            alert("删除成功!");
                            location.reload();
                        } else {
//                            autoLayer("获取信息失败", delay);
                            alert("删除失败!");
                        }
                    }
                });
            });
        });

        //取消
//        $("#cancel").on("click",function() {
//            clear_all();
//        });


        function clear_all() {
            $("input.row_id").val("");
            $("input.movie_name").val("");
            $("input.movie_type").prop("checked","");
            $("input.show_time").val("");
            $("input.zone").val("");
            $("input.url").val("");
            $("input.brief_desc").val("");
            $("input.main_pic").val("");
            $("input.title").val("");
            $("input.short_title").val("");
            $("input.director").val("");
            $("input.actors").val("");
        }

        //查询置空
        $("#clear").on("click", function() {
            $("input[name='zone']").val("");
            $("input[name='movie_type']").val("");
            $("input[name='show_time']").val("");
        });





    });

</script>
</body>

</html>