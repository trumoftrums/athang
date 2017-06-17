<!DOCTYPE html>
<html>

<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VietNamOTO.Net - @yield('title')</title>

    <!-- Mainly scripts -->
    <script src="{{ URL::asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../backend/dhtmlx5/fonts/font_roboto/roboto.css"/>
    <script src="../backend/dhtmlx5/dhtmlx.js"></script>
    <link href="../backend/dhtmlx5/dhtmlx.css" rel="stylesheet">
    <script src="../js/ckeditor/ckeditor.js"></script>
    <script src="../js/ckeditor/samples/js/sample.js"></script>

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
            max-width:80px !important;
        }
        #pagingArea{
            display: inline-flex;
            width: 100%;
        }
        #pagingArea .dhxtoolbar_float_right{
            display: inline-flex;
            width: 100%;
            right: 0px;
            background-color: #f4f4f4;
        }
        #pagingArea .dhxtoolbar_float_right .dhx_toolbar_text{
            width: auto !important;
        }
        .dhxacc_base_dhx_web div.dhx_cell_acc div.dhx_cell_statusbar_def div.dhx_cell_statusbar_paging, .dhxlayout_base_dhx_web div.dhx_cell_layout div.dhx_cell_statusbar_def div.dhx_cell_statusbar_paging, .dhxtabbar_base_dhx_web div.dhx_cell_tabbar div.dhx_cell_statusbar_def div.dhx_cell_statusbar_paging{
            line-height: normal !important;
        }
        .dhxform_base_nested in_block{
            padding-left: 0px !important;
        }
        .dhxlayout_base_dhx_web div.dhx_cell_layout div.dhx_cell_cont_layout{
            padding: 0px;
        }
        .dhxacc_base_dhx_web div.dhx_cell_acc div.dhx_cell_cont_acc{
            padding: 0px;
        }
        .img_avatar{
        }
    </style>
</head>

<body id="layoutBody">
@yield('content')
</body>
</html>
