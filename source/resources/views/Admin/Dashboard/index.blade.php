@extends('Layouts.backend')

@section('title', $info["title"])

@section('content')
<script>
    var live_site_index = "<?php echo URL::to('/'); ?>/";
    var myWins = new dhtmlXWindows();
    myWins.attachEvent("onContentLoaded", function(win){
        if(win.getId()=="w_add"){

        }
        win.progressOff();
    });
    function doOnLoad() {


        myLayout = new dhtmlXLayoutObject({
            parent: "layoutBody",
            pattern: "3J",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Avatar",width:200,height:200}, {id: "b", text: "Data"}, {id: "c",width:200, text: "Menu"}]
        });
        myLayout.setSkin("dhx_web");
        myLayout.cells("a").hideHeader();
        myToolbar = myLayout.attachToolbar();
        myToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        myToolbar.setAlign("right");
        var cfg_button = [
            {id: "home", text: "Home Page", type: "button", img: "ico-home.png"},

            {type: "separator"},
            {id: "logout", text: "Logout", type: "button", img: "ico-logout.png"}

        ];
        myToolbar.loadStruct(cfg_button);

        myToolbar.attachEvent("onClick", function (id) {
            if(id=='home'){
                var win = window.open('/', '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    dhtmlx.alert('Please allow popups for this website');
                }
            }
            if(id=='logout'){
                window.location = '/logout';
            }

        });
        myFilter = myLayout.cells("c").attachAccordion({
            icons_path: live_site_index + "backend/dhtmlx5/common/icons/",
            items: [
                {id: "report", text: "Tổng quan", icon: "report.png"}
                <?php if(in_array(2,$menuPermission)) echo ',{id: "users", text: "Người dùng ('.count($listUsers).') ", icon: "ico-users.png"}'; ?>
                <?php if(in_array(3,$menuPermission)) echo ',{id: "posts", text: "Bài viết ('.$tt_baiviet.')", icon: "ico-post.png"}'; ?>
                <?php if(in_array(4,$menuPermission)) echo ',{id: "news", text: "Tin tức ('.$tt_news.')", icon: "ico-news.png"}'; ?>
                <?php if(in_array(5,$menuPermission)) echo ',{id: "salon", text: "Salon('.$tt_salons.')", icon: "icon-ser01.png"}'; ?>
                <?php if(in_array(6,$menuPermission)) echo ',{id: "suaxe", text: "Sửa xe ('.$tt_suaxes.')", icon: "icon-ser02.png"}'; ?>
                <?php if(in_array(7,$menuPermission)) echo ',{id: "cuuho", text: "Cứu hộ ('.$tt_cuuhos.')", icon: "icon-ser03.png"}'; ?>
                <?php if(in_array(8,$menuPermission)) echo ',{id: "baixe", text: "Bãi giữ Xe ('.$tt_giuxes.')", icon: "icon-ser04.png"}'; ?>
                <?php if(in_array(9,$menuPermission)) echo ',{id: "videos", text: "Videos ('.$ttvd.')", icon: "icon-ser04.png"}'; ?>
                <?php if(in_array(10,$menuPermission)) echo ',{id: "thuexe", text: "Thuê xe ('.$tttx.')", icon: "icon-ser04.png"}'; ?>
                <?php if(in_array(11,$menuPermission)) echo ',{id: "phutung", text: "Bán phụ tùng ('.$ttpt.')", icon: "icon-ser04.png"}'; ?>
            ]
        });
        current_menu = "report";


        init_profile(myLayout.cells("a"));

        myFilter.attachEvent("onActive", function(id, state){
            current_menu = id;
            init_dashboard(current_menu);

        });
        myLayout.cells("b").attachStatusBar({
            text: '<div style="width: 100%;"><span id="pagingArea" style="display: inline-flex"></span>&nbsp;<span id="infoArea"></span></div>',
            paging: true
        });

//        init_users(myFilter.cells("users"),myLayout.cells("b"));
        init_dashboard(current_menu);

    }
    $(document ).ready(function() {
        doOnLoad();

    });
    function  init_dashboard(current_menu) {

        switch (current_menu){
            case 'users':
                init_users(myFilter.cells("users"),myLayout.cells("b"));

                break;

            case 'posts':
                init_form_posts(myFilter.cells("posts"),myLayout.cells("b"));
                break;
            case 'news':
                init_form_news(myFilter.cells("news"),myLayout.cells("b"));
                break;
            case 'salon':
                init_salon(myFilter.cells("salon"),myLayout.cells("b"));
                break;

            case 'suaxe':
                init_suaxe(myFilter.cells("suaxe"),myLayout.cells("b"));
                break;
            case 'cuuho':
                init_cuuho(myFilter.cells("suaxe"),myLayout.cells("b"));
                break;
            case 'baixe':
                init_baixe(myFilter.cells("suaxe"),myLayout.cells("b"));
                break;
            case 'videos':
                init_videos(myFilter.cells("videos"),myLayout.cells("b"));
                break;
            case 'thuexe':
                init_thuexe(myFilter.cells("thuexe"),myLayout.cells("b"));
                break;

            case 'phutung':
                init_phutung(myFilter.cells("phutung"),myLayout.cells("b"));
                break;
        }
    }
    function init_profile(Dhxcell){
        Dhxcell.attachURL("/admin/profile");

    }
    function CKupdate(CKEDITOR){
        for ( instance in CKEDITOR.instances ){
            CKEDITOR.instances[des_id].updateElement();
            CKEDITOR.instances[des_id].setData('');
        }
    }
    var formPost,formNews,formUsers ;
    var can_change_selected = true;
    var current_row_id =0;
    var baiviet_form_tabbar;

    /* begin post */
    function init_form_posts(Dhxcell,DhxLayoutToolbar){
        if(Dhxcell!=null){
            var childLayout = DhxLayoutToolbar.attachLayout({
                pattern: "1C",
                offsets: {          // optional, offsets for fullscreen init
                    top:    0,     // you can specify all four sides
                    right:  5,     // or only the side where you want to have an offset
                    bottom: 0,
                    left:   3
                },
                cells: [{id: "a", text: "Danh sách bài viết"}]
            });
            var formPost = Dhxcell.attachForm();
            var userToolbar = childLayout.attachToolbar();
            userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");

            userToolbar.setAlign("left");
            var cfg_button = [
                {id: "publish", text: "Publish", type: "button", img: "ico-check.png"},
                {type: "separator"},
                {id: "add", text: "Add", type: "button", img: "ico-add.png"},
                {type: "separator"},
                {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
                {type: "separator"},
                {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
                {type: "separator"},
                {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

            ];
            userToolbar.loadStruct(cfg_button);

            userToolbar.attachEvent("onClick", function (id) {
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
                            url: '/admin/getbaivietedit',
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
                                    var bv = data.data.id+'-'+data.data.tieu_de.replace(" ","-");
                                    add_baiviet(bv);

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

                if(id=="reload"){
                    postGetDT(formPost,childLayout.cells("a"));
                }
                if(id == "publish"){
                    var selectedId = mygrid.getSelectedRowId();
                    if (selectedId == null) {
                        dhtmlx.alert("Vui lòng chọn 1 bài viết");
                    }
                    else {
                        var bvid = mygrid.getSelectedRowId();
                        dhtmlx.confirm({
                            title: "Public bài viết",
                            type:"confirm-warning",
                            text: "Bạn chắc chắn muốn public bài viết này?",
                            callback: function(ok) {
                                if(ok){
                                    pub_baiviet(bvid,formPost,childLayout.cells("a"));
                                }

                            }
                        });
                    }
                }

            });


            var cfgform = [
                {type: "settings", position: "label-left"},
                {type: "block", offsetLeft: 0, inputWidth: 190, list: [

                    {type: "calendar", name: "date_fr", enableTime: false, labelAlign: "right", showWeekNumbers: true, label: "Từ", labelWidth: 20, inputWidth: 100, dateFormat: "%Y-%m-%d", value: "<?php echo date("Y-m-d",strtotime("- 7 days")); ?>"},
                    {type: "calendar", name: "date_to", enableTime: false, labelAlign: "right", showWeekNumbers: true, label: "Đến", labelWidth: 20, inputWidth: 100, dateFormat: "%Y-%m-%d", value: "<?php echo date("Y-m-d"); ?>"},

                    {type: "button", offsetLeft: 20, value: "Apply", name: "btnApply"}

                ]}];
            formPost.loadStruct(cfgform);
            formPost.attachEvent("onButtonClick", function (name) {
                if (name == "btnApply") {
                    postGetDT(formPost,childLayout.cells("a"));
                }

            });
            postGetDT(formPost,childLayout.cells("a"));

        }

    }
    function postGetDT(formFilter, LayoutCell){
        mygrid = LayoutCell.attachGrid();
        mygrid.setImagePath(live_site_index + "backend/dhtmlx5/imgs/");
        mygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
//        mygrid.enablePaging(true,50,3,"recinfoArea");
//        mygrid.setPagingSkin("toolbar","dhx_skyblue");
        mygrid.enableBlockSelection();
        mygrid.setPagingSkin("bricks");

        mygrid.init();
        mygrid.attachEvent("onXLE", function(grid_obj,count){
            LayoutCell.progressOff();
        });
        mygrid.attachEvent("onXLS", function(grid_obj){
            LayoutCell.progressOn();
        });
//        var h = mygrid.attachEvent("onPaging",function(){
//            this.aToolBar.setAlign("right");
//            this.detachEvent(h);
//        });
        mygrid.setAwaitedRowHeight(25);
        var date_fr = formFilter.getItemValue("date_fr", true);
        var date_to = formFilter.getItemValue("date_to", true);

        mygrid.loadXML("/admin/getbaiviet?"+"&date_fr="+date_fr+"&date_to="+date_to);
    }

    function add_baiviet(baiviet) {
        var baiviet_thongso;
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = viewportWidth -100;
        var hg = viewportHeight-100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var url = "/admin/posts/add_bai_viet";
        if(baiviet !== null && baiviet !=="undefined"){
            win.setText("Sửa bài viết ... ");
            url += "/"+baiviet;
        }else{
            win.setText("Đăng bài viết ... ");
        }

        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();
        win.attachURL(url);


    }
    function delete_baiviet(baivietID) {
        if(baivietID != null && baivietID != "undefined"){
            $.ajax({
                url: '/admin/delbaiviet',
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
                    postGetDT(myLayout.cells("b"));
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    function pub_baiviet(baivietID,formFilter, LayoutCell) {
        if(baivietID != null && baivietID != "undefined"){
            $.ajax({
                url: '/admin/pubbaiviet',
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
                    postGetDT(formFilter, LayoutCell);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* begin post */

    /* begin news */
    function init_form_news(Dhxcell,DhxLayoutToolbar){
        if(Dhxcell!=null){
            var childLayout = DhxLayoutToolbar.attachLayout({
                pattern: "1C",
                offsets: {          // optional, offsets for fullscreen init
                    top:    0,     // you can specify all four sides
                    right:  5,     // or only the side where you want to have an offset
                    bottom: 0,
                    left:   3
                },
                cells: [{id: "a", text: "Danh sách tin tức"}]
            });
            var formPost = Dhxcell.attachForm();
            var userToolbar = childLayout.attachToolbar();
            userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");

            userToolbar.setAlign("left");
            var cfg_button = [
                {id: "add", text: "Add", type: "button", img: "ico-add.png"},
                {type: "separator"},
                {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
                {type: "separator"},
                {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
                {type: "separator"},
                {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

            ];
            userToolbar.loadStruct(cfg_button);

            userToolbar.attachEvent("onClick", function (id) {
                if (id == "add") {
                    add_news(null);
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
                                    add_news(data.data);

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
                        dhtmlx.alert("Vui lòng chọn 1 tin tức");
                    }
                    else {
                        var bvid = mygrid.getSelectedRowId();
                        dhtmlx.confirm({
                            title: "Xóa tin",
                            type:"confirm-warning",
                            text: "Bạn chắc chắn muốn xóa tin này?",
                            callback: function(ok) {
                                if(ok){
                                    delete_news(bvid)
                                }

                            }
                        });
                    }

                }

                if(id=="reload"){
                    newsGetDT(formPost,childLayout.cells("a"));
                }

            });
            var cfgform = [
                {type: "settings", position: "label-left"},
                {type: "block", offsetLeft: 0, inputWidth: 190, list: [

                    {type: "calendar", name: "date_fr", enableTime: false, labelAlign: "right", showWeekNumbers: true, label: "Từ", labelWidth: 20, inputWidth: 100, dateFormat: "%Y-%m-%d", value: "<?php echo date("Y-m-d",strtotime("- 7 days")); ?>"},
                    {type: "calendar", name: "date_to", enableTime: false, labelAlign: "right", showWeekNumbers: true, label: "Đến", labelWidth: 20, inputWidth: 100, dateFormat: "%Y-%m-%d", value: "<?php echo date("Y-m-d"); ?>"},

                    {type: "button", offsetLeft: 20, value: "Apply", name: "btnApply"}

                ]}];
            formPost.loadStruct(cfgform);
            formPost.attachEvent("onButtonClick", function (name) {
                if (name == "btnApply") {
                    newsGetDT(formPost,childLayout.cells("a"));
                }

            });
            newsGetDT(formPost,childLayout.cells("a"));

        }

    }
    function newsGetDT(formFilter, LayoutCell){
        mygrid = LayoutCell.attachGrid();
        mygrid.setImagePath(live_site_index + "backend/dhtmlx5/imgs/");
        mygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
//        mygrid.enablePaging(true,50,3,"recinfoArea");
//        mygrid.setPagingSkin("toolbar","dhx_skyblue");
        mygrid.enableBlockSelection();
        mygrid.setPagingSkin("bricks");

        mygrid.init();
        mygrid.attachEvent("onXLE", function(grid_obj,count){
            LayoutCell.progressOff();
        });
        mygrid.attachEvent("onXLS", function(grid_obj){
            LayoutCell.progressOn();
        });
//        var h = mygrid.attachEvent("onPaging",function(){
//            this.aToolBar.setAlign("right");
//            this.detachEvent(h);
//        });
        mygrid.setAwaitedRowHeight(25);
        var date_fr = formFilter.getItemValue("date_fr", true);
        var date_to = formFilter.getItemValue("date_to", true);

        mygrid.loadXML("/admin/getnews?"+"&date_fr="+date_fr+"&date_to="+date_to);
    }
    function add_news(baiviet) {

        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
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
                {type: "input", name: "summary", required:true,label: "Tóm tắt", labelWidth: 70, rows: 5, inputWidth: 800, value:baiviet.summary},
                {type: "input", id:"editor",name: "description", label: "Nội dung", rows: 12,labelWidth: 70, inputWidth: 800}

            ]},
            {type: "block", offsetLeft: 10, inputWidth: 980, list: [
                {type: "image", id:"photo", required:true,name: "photo",labelWidth: 70, label: "Hình đại diện",inputWidth: 221, inputHeight: 65, imageHeight: 65, url: "/admin/tool/dhtmlxform_image", value:baiviet.img},
                {type: "newcolumn"},
                {type: "image", id:"thumbnail", required:true, offsetLeft:100 , name: "thumbnail",labelWidth: 80, label: "Thumbnail",inputWidth: 100, inputHeight: 65, imageHeight: 65, url: "/admin/tool/dhtmlxform_image", value:baiviet.thumbnail}
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
            //console.log("Click button"+id);
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
                            CKupdate(CKEDITOR);
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
    function delete_news(baivietID) {
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
                    newsGetDT(myLayout.cells("b"));
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end news */


    /* begin user */
    function init_users(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "2U",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách user"}, {id: "b",width: 510, text: "Thông tin chi tiết"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);

        userToolbar.attachEvent("onClick", function (id) {
            dhtmlx.alert("Sorry, This function is not available!");
//            if (id == "add") {
//
//            }
//
//
//            if(id=="reload"){
//                usermygrid.loadXML("/admin/getusers");
//            }


        });
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();
        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });
        usermygrid.attachEvent("onRowSelect", function(id,ind){
            // your code here
            if(can_change_selected && current_row_id != id){
//                    dhtmlx.alert(id+":"+ind);
                current_row_id = id;
                userLayout.cells("b").progressOn();
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
                        userLayout.cells("b").progressOff();
                        if(data.result){
                            add_user(data.data,userLayout.cells("b"));


                        }else{
                            dhtmlx.alert(data.mess);
                        }
                    },
                    error: function () {
                        dhtmlx.alert("Error,Please try again!");
                        userLayout.cells("b").progressOff();
                    }
                });
            }else{
                return false;
            }

        });

        usermygrid.setAwaitedRowHeight(25);
        usermygrid.loadXML("/admin/getusers");

    }
    function add_user(user,Dhxcell) {



        var wform = Dhxcell.attachForm();
        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 10, inputWidth: 480, list: [
                {type: "image", id:"photo", required:true,name: "photo",labelWidth: 80, label: "Avatar",inputWidth: 150, inputHeight: 150, imageHeight: 150, url: "/admin/tool/dhtmlxform_image_user", value:user.avatar},
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

        });
        wform.attachEvent("onButtonClick", function (id) {

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
                            CKupdate(CKEDITOR);
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
    /* end user */


    /* begin salon */
    function init_salon(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách salon"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_salon(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getsaloninfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_salon(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn xóa salon này?",
                        callback: function(ok) {
                            if(ok){
                                delete_salon(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                usermygrid.loadXML("/admin/getsalons");
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        usermygrid.loadXML("/admin/getsalons");

    }
    function add_salon(salon,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(salon !== null && salon !=="undefined"){
            itemid = {type: "hidden", name:"id", value:salon.id};
            win.setText("Sửa thông tin salon  ... ");
        }else{
            win.setText("Thêm mới salon ... ");
            salon = new Object();
            salon.title = "";
            salon.phone = "";
            salon.description = "";
            salon.thumb = "";
            salon.status = "";
            salon.address = "";
        }
//            console.log(salon);
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [
                {type: "combo",labelWidth: 80, required:true, label: "Username", readonly:true,name: "user_id",inputWidth: 860,  options:[
                    {value: "" , text: "Select user"}
                    <?php
                    if(!empty($listUsers)){
                        foreach ($listUsers as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['username'].'-'.$g['phone'].'-'.$g['email'].'"}';

                        }
                    }
                    ?>
                ]},
                {type: "image", name: "images",required:true,labelWidth: 80, label: "Cover image",inputWidth: 860, inputHeight: 137, imageWidth: 860, imageHeight: 137, url: "/admin/tool/dhtmlxform_image_user", value:salon.images},
                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:salon.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:salon.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:salon.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: salon.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"},
                {type: "input", id:"editor",name: "description", label: "Description", rows: 12,labelWidth: 70, inputWidth: 860}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(salon != null && salon !="undefined" && salon != ''){
            wform.setItemValue('city',salon.cityID);
            wform.setItemValue('user_id',salon.user_id);
            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();
                    var description = CKEDITOR.instances[des_id].getData();
                    formData.description = description;
                    //console.log(formData);

                        $.ajax({
                            url: '/admin/save_salon',
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
                                dhtmlx.alert(data.mess);
                                if(data.result){
                                    win.close();
                                    getSalons(Dhxgrid);
                                }


                            },
                            error: function () {
                                dhtmlx.alert("Error,Please try again!");
                            }
                        });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });

        des_id = $( "textarea[name='description']" ).attr("id");
//        console.log(des_id);
        initSample(des_id);
        CKEDITOR.instances[des_id].setData(salon.description);

    }
    function getSalons(Dhxgrid){
        Dhxgrid.loadXML("/admin/getsalons");
    }
    function delete_salon(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delsalon',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getSalons(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }

    /* end salon */
    /* begin suaxe */
    function init_suaxe(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách điểm sửa xe"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_suaxe(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getsuaxeinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_suaxe(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn xóa điểm sửa xe này?",
                        callback: function(ok) {
                            if(ok){
                                delete_suaxe(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getSuaxes(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getSuaxes(usermygrid);

    }
    function add_suaxe(item,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.id};
            win.setText("Sửa thông tin điểm sủa xe  ... ");
        }else{
            win.setText("Thêm mới điểm sủa xe ... ");
            item = new Object();
            item.title = "";
            item.phone = "";
            item.description = "";
            item.thumb = "";
            item.status = "";
            item.address = "";
        }
//            console.log(salon);
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [

                {type: "image", name: "images",required:true,labelWidth: 80, label: "Cover image",inputWidth: 860, inputHeight: 137, imageWidth: 860, imageHeight: 137, url: "/admin/tool/dhtmlxform_image_user", value:item.images},
                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:item.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:item.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: item.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"},
                {type: "input", id:"editor",name: "description", label: "Description", rows: 12,labelWidth: 70, inputWidth: 860}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('city',item.cityID);

            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();
                    var description = CKEDITOR.instances[des_id].getData();
                    formData.description = description;
                    //console.log(formData);

                    $.ajax({
                        url: '/admin/save_suaxe',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getSuaxes(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });

        des_id = $( "textarea[name='description']" ).attr("id");
//        console.log(des_id);
        initSample(des_id);
        CKEDITOR.instances[des_id].setData(item.description);

    }
    function getSuaxes(Dhxgrid){
        Dhxgrid.loadXML("/admin/getsuaxes");
    }
    function delete_suaxe(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delsuaxe',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getSuaxes(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end suaxe */

    /* begin cuuho */
    function init_cuuho(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách thông tin cứu hộ"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_cuuho(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getcuuhoinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_cuuho(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn thông tin cứu hộ này?",
                        callback: function(ok) {
                            if(ok){
                                delete_cuuho(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getCuuhos(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getCuuhos(usermygrid);

    }
    function add_cuuho(item,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.id};
            win.setText("Sửa thông tin cứu hộ  ... ");
        }else{
            win.setText("Thêm mới thông tin cứu hộ ... ");
            item = new Object();
            item.title = "";
            item.phone = "";
//            item.description = "";
            item.thumb = "";
            item.status = "";
            item.address = "";
        }
//            console.log(salon);
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [

//                {type: "image", name: "images",required:true,labelWidth: 80, label: "Cover image",inputWidth: 860, inputHeight: 137, imageWidth: 860, imageHeight: 137, url: "/admin/tool/dhtmlxform_image_user", value:item.images},
                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:item.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:item.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: item.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('city',item.cityID);

            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();

                    $.ajax({
                        url: '/admin/save_cuuho',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getCuuhos(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });


    }
    function getCuuhos(Dhxgrid){
        Dhxgrid.loadXML("/admin/getcuuhos");
    }
    function delete_cuuho(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delcuuho',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getCuuhos(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end cuuho */

    /* begin baixe */
    function init_baixe(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách bãi giữ xe"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_baixe(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getbaixeinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_baixe(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn thông tin cứu hộ này?",
                        callback: function(ok) {
                            if(ok){
                                delete_baixe(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getBaixes(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getBaixes(usermygrid);

    }
    function add_baixe(item,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.id};
            win.setText("Sửa thông tin bãi xe  ... ");
        }else{
            win.setText("Thêm mới bãi xe ... ");
            item = new Object();
            item.title = "";
            item.phone = "";
            item.thumb = "";
            item.status = "";
            item.address = "";
        }
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [


                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:item.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:item.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: item.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('city',item.cityID);

            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();

                    $.ajax({
                        url: '/admin/save_baixe',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getBaixes(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });


    }
    function getBaixes(Dhxgrid){
        Dhxgrid.loadXML("/admin/getbaixes");
    }
    function delete_baixe(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delbaixe',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getBaixes(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end baixe */

    /* begin videos */
    function init_videos(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách videos"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_videos(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getvideosinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_videos(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn xóa video này?",
                        callback: function(ok) {
                            if(ok){
                                delete_videos(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getVideos(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getVideos(usermygrid);

    }
    function add_videos(item,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.videoID};
            win.setText("Sửa thông tin video  ... ");
        }else{
            win.setText("Thêm mới video ... ");
            item = new Object();
            item.title = "";
            item.description = "";
            item.keyword = "";
            item.catID = "";
            item.embedID = "";
            item.vID = "";
            item.url = "";

        }
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [
                {type: "combo",labelWidth: 80, required:true, label: "Category", readonly:true,name: "catID",inputWidth: 200,  options:[
                    {value: "" , text: "Select Category"}
                    <?php
                    if(!empty($listVideoCats)){

                        foreach ($listVideoCats as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['catName'].'"}';

                        }
                    }
                    ?>
                ]},
                {type: "combo",labelWidth: 80, required:true, label: "Nguồn Video", readonly:true,name: "embedID",inputWidth: 200,  options:[
                    {value: "" , text: "Select source"}
                    <?php
                    if(!empty($listVideoEmbeds)){

                        foreach ($listVideoEmbeds as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type: "input", name: "url",required:true, label: "URL", labelWidth: 80, inputWidth: 860, value:item.url},
                {type: "input", name: "vID",required:false, label: "Video ID", labelWidth: 80, inputWidth: 100, value:item.vID},
                {type: "input", name: "title",required:true, label: "Title", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "description",label: "Description", labelWidth: 80, inputWidth: 860,rows:5,  value:item.description},

                {type: "input", id:"keyword",name: "keyword", label: "Keyword", labelWidth: 80,rows:5,  inputWidth: 860, value: item.keyword}



            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('catID',item.catID);
            wform.setItemValue('embedID',item.embedID);
            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();

                    $.ajax({
                        url: '/admin/save_videos',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getVideos(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });


    }
    function getVideos(Dhxgrid){
        Dhxgrid.loadXML("/admin/getvideos");
    }
    function delete_videos(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delvideos',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getVideos(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end videos */
    /* begin thuexe */
    function init_thuexe(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách thông tin thuê xe"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_thuexe(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getthuexeinfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_thuexe(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn xóa thông tin này?",
                        callback: function(ok) {
                            if(ok){
                                delete_thuexe(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getthuexe(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getthuexe(usermygrid);

    }
    function add_thuexe(item,Dhxgrid) {
//        console.log(salon);
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.id};
            win.setText("Sửa thông tin thuê xe  ... ");
        }else{
            win.setText("Thêm mới thông tin thuê xe ... ");
            item = new Object();
            item.title = "";
            item.phone = "";
//            item.description = "";
            item.thumb = "";
            item.status = "";
            item.address = "";
        }
//            console.log(salon);
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [

//                {type: "image", name: "images",required:true,labelWidth: 80, label: "Cover image",inputWidth: 860, inputHeight: 137, imageWidth: 860, imageHeight: 137, url: "/admin/tool/dhtmlxform_image_user", value:item.images},
                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:item.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:item.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: item.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('city',item.cityID);

            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();

                    $.ajax({
                        url: '/admin/save_thuexe',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getthuexe(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });


    }
    function getthuexe(Dhxgrid){
        Dhxgrid.loadXML("/admin/getthuexe");
    }
    function delete_thuexe(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delthuexe',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getthuexe(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end thuexe */
    /* begin phutung */
    function init_phutung(formFilter, LayoutCell) {
        var userLayout = LayoutCell.attachLayout({
            pattern: "1C",
            offsets: {          // optional, offsets for fullscreen init
                top:    0,     // you can specify all four sides
                right:  5,     // or only the side where you want to have an offset
                bottom: 0,
                left:   3
            },
            cells: [{id: "a", text: "Danh sách cửa hàng bán phụ tùng"}]
        });
        var userToolbar = userLayout.attachToolbar();
        userToolbar.setIconsPath(live_site_index + "backend/dhtmlx5/common/icons/");
        userToolbar.setAlign("left");
        var cfg_button = [
            {id: "add", text: "Add", type: "button", img: "ico-add.png"},
            {type: "separator"},
            {id: "edit", text: "Edit", type: "button", img: "ico-edit.png"},
            {type: "separator"},
            {id: "delete", text: "Delete", type: "button", img: "ico-del.png"},
            {type: "separator"},
            {id: "reload", text: "Reload", type: "button", img: "ico-reload.png"}

        ];
        userToolbar.loadStruct(cfg_button);
        var usermygrid = userLayout.cells("a").attachGrid();
        usermygrid.setImagePath("../js/dhtmlx5/imgs/");
        usermygrid.enablePaging(true,50,10,"pagingArea",true,"infoArea");
        usermygrid.enableBlockSelection();
        usermygrid.setPagingSkin("bricks");
        usermygrid.init();

        userToolbar.attachEvent("onClick", function (id) {
            //dhtmlx.alert("Sorry, This function is not available!");
            if (id == "add") {
                add_phutung(null,usermygrid);
            }
            if(id=="edit"){
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{


                    $.ajax({
                        url: '/admin/getphutunginfo',
                        dataType: "json",
                        cache: false,
                        type: 'post',
                        data: {
                            id: selectedId
                        },
                        beforeSend: function(xhr){

//                            xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        },
                        success: function (data) {

                            if(data.result){
                                add_phutung(data.data,usermygrid);


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
                var selectedId = usermygrid.getSelectedRowId();
                if (selectedId == null) {
                    dhtmlx.alert("Please select 1 row!");
                }else{
                    dhtmlx.confirm({
                        title: "Xóa tin",
                        type:"confirm-warning",
                        text: "Bạn chắc chắn muốn xóa thông tin này?",
                        callback: function(ok) {
                            if(ok){
                                delete_phutung(selectedId,usermygrid);
                            }

                        }
                    });
                }
            }
            if(id=="reload"){
                getphutung(usermygrid);
            }


        });

        usermygrid.attachEvent("onXLE", function(grid_obj,count){
            userLayout.cells("a").progressOff();
        });
        usermygrid.attachEvent("onXLS", function(grid_obj){
            userLayout.cells("a").progressOn();
        });


        usermygrid.setAwaitedRowHeight(25);
        getphutung(usermygrid);

    }
    function add_phutung(item,Dhxgrid) {
        var viewportWidth = $(window).width();
        var viewportHeight = $(window).height();
        var wd = 1050;
        var hg = viewportHeight - 100;
        var left = (viewportWidth / 2) - (wd / 2) ;
        var top = (viewportHeight / 2) - (hg / 2);
        var win = myWins.createWindow("w_add", left, top, wd, hg);
        var itemid = null;
        if(item !== null && item !=="undefined"){
            itemid = {type: "hidden", name:"id", value:item.id};
            win.setText("Sửa thông tin cửa hàng bán phụ tùng  ... ");
        }else{
            win.setText("Thêm mới cửa hàng bán phụ tùng ... ");
            item = new Object();
            item.title = "";
            item.phone = "";
//            item.description = "";
            item.thumb = "";
            item.status = "";
            item.address = "";
        }
//            console.log(salon);
        win.setModal(true);
        win.button("minmax").disable();
        win.button("park").disable();


        var wform = win.attachForm();

        var cfgform1 = [
            {type: "settings", position: "label-left"},
            {type: "block", offsetLeft: 0, inputWidth: 1000, list: [

//                {type: "image", name: "images",required:true,labelWidth: 80, label: "Cover image",inputWidth: 860, inputHeight: 137, imageWidth: 860, imageHeight: 137, url: "/admin/tool/dhtmlxform_image_user", value:item.images},
                {type: "image",  name: "thumb",required:true,labelWidth: 80, label: "Thumnail",inputWidth: 135, inputHeight: 103,imageWidth: 135, imageHeight: 103, url: "/admin/tool/dhtmlxform_image_user", value:item.thumb},
                {type: "input", name: "title",required:true, label: "Name", labelWidth: 80, inputWidth: 860, value:item.title},
                {type: "input", name: "phone", required:true,label: "Phone", labelWidth: 80, inputWidth: 400, value:item.phone},

                {type: "input", id:"address",name: "address", label: "Address", labelWidth: 80, inputWidth: 860, value: item.address},

                {type: "combo",labelWidth: 80, required:true, label: "City", readonly:true,name: "city",inputWidth: 100,  options:[
                    {value: "" , text: "Select city"}
                    <?php
                    if(!empty($listCity)){

                        foreach ($listCity as $g){
                            echo ',{value: "'.$g['id'].'" , text: "'.$g['city_name'].'"}';

                        }
                    }
                    ?>
                ]},
                {type:"checkbox",labelWidth: 80,  name:"status", value:"Actived", label:"Actived"}
            ]},

            {type: "block", offsetLeft: 0, inputWidth: 490, list: [
                {type: "button", offsetLeft: 80, value: "Save", name: "btnSave"}

            ]}
        ];
        wform.loadStruct(cfgform1);
        if(itemid != null){
            wform.addItem(null,itemid,0,0);
        }
        if(item != null && item !="undefined" && item != ''){
            wform.setItemValue('city',item.cityID);

            wform.checkItem('status');
        }

        wform.attachEvent("onImageUploadSuccess", function(name, value, extra){

        });
        wform.attachEvent("onImageUploadFail", function(name, extra){
        });
        wform.attachEvent("onButtonClick", function (id) {
            if(id=="btnSave"){

                if(wform.validate()){
                    var formData = wform.getFormData();

                    $.ajax({
                        url: '/admin/save_phutung',
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
                            dhtmlx.alert(data.mess);
                            if(data.result){
                                win.close();
                                getphutung(Dhxgrid);
                            }


                        },
                        error: function () {
                            dhtmlx.alert("Error,Please try again!");
                        }
                    });


                }else {
                    dhtmlx.alert("Please input all required fields");
                }

            }
        });


    }
    function getphutung(Dhxgrid){
        Dhxgrid.loadXML("/admin/getphutung");
    }
    function delete_phutung(id,Dhxgrid) {
        if(id != null && id != "undefined"){
            $.ajax({
                url: '/admin/delphutung',
                dataType: "json",
                cache: false,
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function(xhr){

//                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                },
                success: function (data) {
                    getphutung(Dhxgrid);
                    dhtmlx.alert(data.mess);
                },
                error: function () {
                    dhtmlx.alert("Error,Please try again!");
                }
            });
        }

    }
    /* end phutung */
    function closing(){
        var win = myWins.window("w_add");
        if(win != null){
            try {
                win.close();
            }catch(e){

            }
        }
    }
</script>

@endsection

