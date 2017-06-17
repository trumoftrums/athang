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
                pattern: "2U",
                offsets: {          // optional, offsets for fullscreen init
                    top:    0,     // you can specify all four sides
                    right:  5,     // or only the side where you want to have an offset
                    bottom: 0,
                    left:   3
                },
                cells: [{id: "a", text: "Danh sách user"}, {id: "b",width: 500, text: "Thông tin chi tiết"}]
            });
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
            myToolbar.addButton("add", 0, "Thêm user", "../js/dhtmlx5/common/add.png", "add.png");
            myToolbar.addButton("delete",1, "Xóa user", "../js/dhtmlx5/common/delete.png", "delete.png");
            myToolbar.addButton("refresh",2, "Làm mới", "../js/dhtmlx5/common/refresh.png", "refresh.png");

            myToolbar.attachEvent("onClick", function (id) {
                dhtmlx.alert(id);
                if (id == "add") {
//                    add_baiviet(null);
                }


                if(id=="refresh"){
                    mygrid.loadXML("getusers");
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
            mygrid.attachEvent("onRowSelect", function(id,ind){
                // your code here
                if(can_change_selected && current_row_id != id){
//                    dhtmlx.alert(id+":"+ind);
                    current_row_id = id;
                    myLayout.cells("b").progressOn();
                    $.ajax({
                        url: '/admin/getuserinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: id
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {
                            myLayout.cells("b").progressOff();
                            if(data.result){
                                add_baiviet(data.data);


                            }else{
                                dhtmlx.alert(data.mess);
                            }
                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                            myLayout.cells("b").progressOff();
                        }
                    });
                }else{
                    return false;
                }

            })

            mygrid.setAwaitedRowHeight(25);
            mygrid.loadXML("getusers");

        }
        var can_change_selected = true;
        var current_row_id =0;
        var baiviet_form_tabbar;
        function add_baiviet(user) {



            wform = myLayout.cells("b").attachForm();
            var cfgform1 = [
                {type: "settings", position: "label-left"},
                {type: "block", offsetLeft: 10, inputWidth: 490, list: [
                    {type: "image", id:"photo", required:true,name: "photo",labelWidth: 80, label: "Avatar",inputWidth: 150, inputHeight: 150, imageHeight: 150, url: "./tool/dhtmlxform_photo_user", value:user.avatar},
                    {type: "input", name: "username",required:true, label: "Username", labelWidth: 80, inputWidth: 150, value:user.username},
                    {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 150, value:user.phone},
                    {type: "input", id:"email",name: "email", label: "Email", labelWidth: 80, inputWidth: 350, value: user.email},
                    {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 350, value: user.address},

                    {type: "combo",labelWidth: 80,  label: "Group", name: "group",inputWidth: 100,  options:[

                        <?php
                            if(!empty($groups)){
                                $i =1;
                                foreach ($groups as $g){
                                    $seletec = "";
                                    echo '{value: "'.$g['id'].'" , text: "'.$g['name'].'"}';
                                    if($i<count($groups)) echo ',';
                                    $i++;
                                }
                            }
                        ?>
                    ]},
                    {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"}
                ]},

                {type: "block", offsetLeft: 10, inputWidth: 490, list: [
                    {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"},
                    {type: "newcolumn"},
                    {type: "button", offsetLeft: 80, value: "Cancel", name: "btnCancel"}
                ]}
            ];
            wform.loadStruct(cfgform1);
            wform.disableItem('phone');
//            var dhxCombo = wform.getCombo("group");
//            console.log(user);
//            myForm.setItemValue(name, value);
            if(user != null && user !="undefined" && user != ''){
//                dhtmlx.alert("ok");
                wform.setItemValue('group',user.group);
//                wform.setItemValue('group',user.group);
                wform.checkItem('status');
            }else{
                wform.setItemValue('group',2);

            }


            wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

            });
            wform.attachEvent("onImageUploadFail", function(name, extra){
                console.log("onImageUploadFail::"+extra);
            });
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

