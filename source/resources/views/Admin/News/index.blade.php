@extends('Layouts.backend')

@section('title', $info["title"])
<style>
    html, body {
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow: hidden;
    }
    #layoutObj{
        width: 100%;
    }
    .dashboard-header{
        padding: 0px !important;

    }
    .dhxlayout_base_material div.dhxcelltop_toolbar{
        padding-bottom: 2px !important;
    }
    div.dhxform_control input.dhxform_textarea{
        border: 1px solid #DDDDDD !important;
    }
    .dhxform_label label{
        font-weight: normal !important;
    }
    .dhxtabbar_tab_actv .dhxtabbar_tab_text{
        background-color: #0c834a !important;
        color: #FFFFFF !important;
    }
    .dhxform_obj_material .dhxform_textarea{
        border-width: 1px 1px 1px 1px !important;
    }
    div.gridbox table.row20px tr  td img{
        max-height:60px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="../js/dhtmlx5/dhtmlx.css"/>
<link rel="stylesheet" type="text/css" href="../js/dhtmlx5/fonts/font_roboto/roboto.css"/>
<script src="../js/dhtmlx5/dhtmlx.js"></script>
<script src="../js/ckeditor/ckeditor.js"></script>
<script src="../js/ckeditor/samples/js/sample.js"></script>
@section('content')
    <div id="layoutObj" class="row  border-bottom white-bg dashboard-header"></div>
    <script>
        var myLayout;
        var myWins = new dhtmlXWindows();
        myWins.attachEvent("onContentLoaded", function(win){
//            console.log("onContentLoaded");
            if(win.getId()=="w_add"){

            }
        });
        function doOnLoad() {
            myLayout = new dhtmlXLayoutObject({
                parent: "layoutObj",
                pattern: "1C",
                offsets: {          // optional, offsets for fullscreen init
                    top:    0,     // you can specify all four sides
                    right:  5,     // or only the side where you want to have an offset
                    bottom: 0,
                    left:   3
                }
            });
            myLayout.cells("a").setText("Tất cả tin tức");
            var myToolbar = myLayout.attachToolbar({
                parent: "toolbar",
                mode:   "top",
                align:  "left",
                height:35,
                offsets: {          // optional, offsets for fullscreen init
                    top:    0,     // you can specify all four sides
                    right:  0,     // or only the side where you want to have an offset
                    bottom: 0,
                    left:   0
                }
            });
            myToolbar.setIconPath = "../js/dhtmlx5/common";
            myToolbar.addButton("add", 0, "Đăng tin tức", "../js/dhtmlx5/common/add.png", "add.png");
            myToolbar.addButton("edit",1, "Sửa tin tức", "../js/dhtmlx5/common/edit.png", "edit.png");
            myToolbar.addButton("delete",2, "Xóa tin tức", "../js/dhtmlx5/common/delete.png", "delete.png");
            myToolbar.addButton("refresh",3, "Làm mới", "../js/dhtmlx5/common/refresh.png", "refresh.png");

            myToolbar.attachEvent("onClick", function (id) {
                if (id == "add") {
                    add_baiviet(null);
                }
                if (id == "edit") {
                    if (mygrid.getSelected() != null &&  mygrid._selectionArea) {
                        dhtmlx.alert("Please select 1 row!");
                    } else {
                        var bvid =  mygrid.getSelectedRowId();
                        var token = "{{csrf_token()}}";

                        $.ajax({
                            url: '/admin/getnewsedit',
                            dataType: "json",
                            cache: false,
                            type: 'post',
                            data: {
                                bvid: bvid
                            },
                            beforeSend: function(xhr){

                                xhr.setRequestHeader('X-CSRF-TOKEN', token);
                            },
                            success: function (data) {
                                if(data.result){
                                    add_baiviet(data.data);

                                }else{
                                    dhtmlx.alert(data.mess);
                                }
                            },
                            error: function () {
                                dhtmlx.alert("Error,Please try again!");
                            }
                        });


                    }
                }

                if(id=="delete"){
                    var selectedId = mygrid.getSelectedRowId();
                    if (selectedId == null) {
                        dhtmlx.alert("Vui lòng chọn 1 bài viết");
                    }
                     else {
                        var bvid = mygrid.getSelectedRowId();
                        dhtmlx.confirm({
                            title: "Xóa bài viết",
                            type:"confirm-warning",
                            text: "Bạn chắc chắn muốn xóa bài viết này?",
                            callback: function(ok) {
                                if(ok){
                                    delete_baiviet(bvid)
                                }

                            }
                        });
                    }

                }

                if(id=="refresh"){
                    mygrid.loadXML("getnews");
                }


            });
            mygrid = myLayout.cells("a").attachGrid();
            mygrid.setImagePath("../js/dhtmlx5/imgs/");
            mygrid.init();
            mygrid.attachEvent("onXLE", function(grid_obj,count){
                myLayout.cells("a").progressOff();
            });
            mygrid.attachEvent("onXLS", function(grid_obj){
                myLayout.cells("a").progressOn();
            });
            mygrid.setAwaitedRowHeight(25);
            mygrid.loadXML("getnews");

        }
        var baiviet_form_tabbar;
        function add_baiviet(baiviet) {

            var viewportWidth = $(window).width();
            var viewportHeight = $(window).height();
            var wd = 1020;
            var hg = $("#layoutObj").height()-50;
            var left = (viewportWidth / 2) - (wd / 2) ;
            var top = (viewportHeight / 2) - (hg / 2);
            var win = myWins.createWindow("w_add", left, top, wd, hg);
            var itemid = null;
            if(baiviet !== null && baiviet !=="undefined"){
                itemid = {type: "hidden", name:"id", value:baiviet.id};
                win.setText("Sửa tin tức ... ");
            }else{
                win.setText("Đăng tin tức ... ");
                baiviet = new Object();
                baiviet.title = "";
                baiviet.summary = "";
                baiviet.description = "";
                baiviet.thumnail = "";
                baiviet.status = "";
            }
//            console.log(baiviet);
            win.setModal(true);
            win.button("minmax").disable();
            win.button("park").disable();


            wform = win.attachForm();
            var cfgform1 = [
                {type: "settings", position: "label-left"},
                {type: "block", offsetLeft: 10, inputWidth: 980, list: [
                    {type: "input", name: "title",required:true, label: "Tiêu đề", labelWidth: 70, inputWidth: 800, value:baiviet.title},
                    {type: "input", name: "summary", required:true,label: "Tóm tắt", labelWidth: 70, rows: 5, inputWidth: 800, value:baiviet.summary},
                    {type: "input", id:"editor",name: "description", label: "Nội dung", rows: 12,labelWidth: 70, inputWidth: 800}

                ]},
                {type: "block", offsetLeft: 10, inputWidth: 980, list: [
                    {type: "image", id:"photo", required:true,name: "photo",labelWidth: 70, label: "Hình đại diện",inputWidth: 221, inputHeight: 65, imageHeight: 65, url: "./tool/dhtmlxform_image", value:baiviet.img},
                    {type: "newcolumn"},
                    {type: "image", id:"thumbnail", required:true, offsetLeft:100 , name: "thumbnail",labelWidth: 80, label: "Thumbnail",inputWidth: 100, inputHeight: 65, imageHeight: 65, url: "./tool/dhtmlxform_image", value:baiviet.thumbnail}
                ]},
                {type: "block", offsetLeft: 10, inputWidth: 980, list: [
                    {type: "button", offsetLeft: 70, value: "Save", name: "btnSave"}
                ]}
            ];
            wform.loadStruct(cfgform1);
            if(itemid != null){
                wform.addItem(null,itemid,0,0);
            }

            wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

            });
            wform.attachEvent("onImageUploadFail", function(name, extra){
                console.log("onImageUploadFail::"+extra);
            });
//            console.log("OK");
            wform.attachEvent("onButtonClick", function (id) {
                console.log("Click button"+id);
                if(id=="btnSave"){

                    if(wform.validate()){
                        var formData = wform.getFormData();
                        var description = CKEDITOR.instances[des_id].getData();
                        formData.description = description;
                        //console.log(formData);
                        $.ajax({
                            url: '/admin/save_news',
                            dataType: "json",
                            cache: false,
                            type: 'post',
                            data: {
                                formData: formData
                            },
                            beforeSend: function(xhr){

                                //xhr.setRequestHeader('X-CSRF-TOKEN', token);
                            },
                            success: function (data) {
                                wform.clear();
                                CKupdate();
                                dhtmlx.alert(data.mess);

                            },
                            error: function () {
                                dhtmlx.alert("Error,Please try again!");
                            }
                        });
                    }else {
                        dhtmlx.alert("Vui lòng nhập đầy đủ thông tin bắt buộc (có dấu sao màu đỏ) ");
                    }

                }
            });
            des_id = $( "textarea[name='description']" ).attr("id");
            console.log(des_id);
            initSample(des_id);
            CKEDITOR.instances[des_id].setData(baiviet.description);

        }
        function CKupdate(){
            for ( instance in CKEDITOR.instances ){
                CKEDITOR.instances[des_id].updateElement();
                CKEDITOR.instances[des_id].setData('');
            }
        }
        $(document ).ready(function() {

            adjust_size();
            doOnLoad();




        });
        $( window ).resize(function() {
            adjust_size();
        });
        function adjust_size(){
            var pr = $( window );
            var h = pr.height() - $("#toolbar_top").height()-5;
            var w = pr.width() - $("#menu-left").width();
            $("#layoutObj").css("height",h);
            $("#layoutObj").css("width",w);


        }


        function delete_baiviet(baivietID) {
            if(baivietID != null && baivietID != "undefined"){
                $.ajax({
                    url: '/admin/delnews',
                    dataType: "json",
                    cache: false,
                    type: 'post',
                    data: {
                        baivietID: baivietID
                    },
                    beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    },
                    success: function (data) {
                        mygrid.loadXML("getnews");
                        dhtmlx.alert(data.mess);
                    },
                    error: function () {
                        dhtmlx.alert("Error,Please try again!");
                    }
                });
            }

        }

    </script>

@endsection

