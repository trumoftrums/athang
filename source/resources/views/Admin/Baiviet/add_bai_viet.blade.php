<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style_vno.css') }}?ver=1.1">
<link rel="stylesheet" href="{{ URL::asset('css/media_screen.css') }}?ver=1.1">
<link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.css') }}">
<script src="{{ URL::asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<style>
    .dhxlayout_base_material div.dhxcelltop_toolbar{
        padding-bottom: 2px !important;
    }
    div.dhxform_control input.dhxform_textarea{
        border: 1px solid #DDDDDD !important;
    }
    .dhxform_label label{
        font-weight: normal !important;
    }
    .dhxform_obj_material .dhxform_textarea{
        border-width: 1px 1px 1px 1px !important;
    }
    div.gridbox table.row20px tr  td img{
        max-height:60px !important;
    }
    .dhxform_obj_material div.dhxform_base {
        position: relative;
        float: left;
        margin-right: 10px;
        margin-left: 5px;
    }
    .dhxcombolist_material{
        height:250px;
    }
    #tab2 .dhxform_obj_material div.dhxform_item_label_left{
        padding-top: 0px;
    }
    #tab4 .dhxform_obj_material div.dhxform_item_label_left{
        padding-top: 6px;
    }
    .img-cap{
        cursor: pointer;
    }
</style>
    <div class="detail-post">

        <form id="fmbaiviet" action="" method="post" enctype="multipart/form-data">


            <div class="info-post">
                <ul class="ul-cover-tabs-post">
                    <li id="title_tab1" class="active"><a data-toggle="tab" href="#tab1">THÔNG TIN CƠ BẢN</a></li>
                    <li id="title_tab2" ><a data-toggle="tab" href="#tab2">LOẠI TIN ĐĂNG</a></li>
                </ul>
                <div class="cover-tab-post tab-content">
                    <div id="tab1" class="tab-pane fade in active" style="float: left;position:relative;width: 100%">
                        <div class="cover-tab-free">
                            <ul>
                                <li>
                                    <p class="p-title-area">MÔ TẢ CƠ BẢN</p>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Hãng xe<span style="color:red;">*</span></label>
                                        <select type="select" class="free-post-input fm_required" name ="thongso_20" <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?>>
                                            <option value="">Click chọn</option>
                                            <?php
                                            //                                            var_dump($hangxes);exit();
                                            if(isset($hangxes) && !empty($hangxes)){
                                                foreach ($hangxes as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['hang_xe']) && $k == $baiviet['hang_xe']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right ">Dòng xe<span style="color:red;">*</span></label>
                                        <select  type="select" class="free-post-input fm_required" name="thongso_75" <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?>>
                                            <option value="">Click chọn</option>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Dáng xe<?php if($thongso["thongso_25"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="select" class="free-post-input <?php if($thongso["thongso_25"]['required']=="true"){echo 'fm_required';}?>" name="thongso_25">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_25"]["arr_options"]) && !empty($thongso["thongso_25"]["arr_options"])){
                                                foreach ($thongso["thongso_25"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_25']) && $k == $baiviet['thongso']['thongso_25']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Tỉnh thành<?php if($thongso["thongso_62"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="select" class="free-post-input <?php if($thongso["thongso_62"]['required']=="true"){echo 'fm_required';}?>" name="thongso_62">
                                            <option value=""><i style="color: #d1d1d1;">Click chọn</i></option>
                                            <?php
                                            if(!empty($listCity)){
                                                foreach ($listCity as $v){
                                                    $selected="";
                                                    if(isset($baiviet['thongso']['thongso_62']) && $v['city_name'] == $baiviet['thongso']['thongso_62']){
                                                        $selected =' selected="selected"';
                                                    }
                                                    echo '<option value="'.$v['city_name'].'" '.$selected.'>'.$v['city_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Xuất xứ<?php if($thongso["thongso_70"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="select" class="free-post-input <?php if($thongso["thongso_70"]['required']=="true"){echo 'fm_required';}?>" name="thongso_70">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_70"]["arr_options"]) && !empty($thongso["thongso_70"]["arr_options"])){
                                                foreach ($thongso["thongso_70"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_70']) && $k == $baiviet['thongso']['thongso_70']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Tình trạng<?php if($thongso["thongso_24"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="select" class="free-post-input <?php if($thongso["thongso_24"]['required']=="true"){echo 'fm_required';}?>" name="thongso_24">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_24"]["arr_options"]) && !empty($thongso["thongso_24"]["arr_options"])){
                                                foreach ($thongso["thongso_24"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_24']) && $k == $baiviet['thongso']['thongso_24']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Năm SX<?php if($thongso["thongso_22"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="select" class="free-post-input <?php if($thongso["thongso_22"]['required']=="true"){echo 'fm_required';}?>" name="thongso_22">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_22"]["arr_options"]) && !empty($thongso["thongso_22"]["arr_options"])){
                                                foreach ($thongso["thongso_22"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_22']) && $k == $baiviet['thongso']['thongso_22']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label  class="mar-right">KM đã đi<?php if($thongso["thongso_26"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text onlynumber <?php if($thongso["thongso_26"]['required']=="true"){echo 'fm_required';}?>" placeholder="Nhập số KM đã đi" name="thongso_26" value="<?php if(isset($baiviet['thongso']['thongso_26'])) echo $baiviet['thongso']['thongso_26']; ?>">

                                    </div>
                                    <div class="item-cover-one">

                                        <label  class="mar-right">Màu sắc<?php if($thongso["thongso_27"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text <?php if($thongso["thongso_27"]['required']=="true"){echo 'fm_required';}?>" placeholder="Nhập màu xe" name="thongso_27" value="<?php if(isset($baiviet['thongso']['thongso_27'])) echo $baiviet['thongso']['thongso_27']; ?>">

                                    </div>
                                </li>
                                <li>
                                    <p class="p-title-area">THÔNG SỐ CƠ BẢN</p>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Nhiên liệu<?php if($thongso["thongso_32"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select  type="select" class="free-post-input <?php if($thongso["thongso_32"]['required']=="true"){echo 'fm_required';}?>" name="thongso_32">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_32"]["arr_options"]) && !empty($thongso["thongso_32"]["arr_options"])){
                                                foreach ($thongso["thongso_32"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_32']) && $k == $baiviet['thongso']['thongso_32']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Hộp số<?php if($thongso["thongso_34"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select  type="select" class="free-post-input <?php if($thongso["thongso_34"]['required']=="true"){echo 'fm_required';}?>" name="thongso_34">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_34"]["arr_options"]) && !empty($thongso["thongso_34"]["arr_options"])){
                                                foreach ($thongso["thongso_34"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_34']) && $k == $baiviet['thongso']['thongso_34']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Dẫn động<?php if($thongso["thongso_33"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <select  type="select" class="free-post-input <?php if($thongso["thongso_33"]['required']=="true"){echo 'fm_required';}?>" name="thongso_33">
                                            <option value="">Click chọn</option>
                                            <?php
                                            if(isset($thongso["thongso_33"]["arr_options"]) && !empty($thongso["thongso_33"]["arr_options"])){
                                                foreach ($thongso["thongso_33"]["arr_options"] as $k=>$v){
                                                    $selected = "";
                                                    if(isset($baiviet['thongso']['thongso_33']) && $k == $baiviet['thongso']['thongso_33']) {
                                                        $selected =' selected="selected" ';
                                                    }
                                                    echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Số ghế<?php if($thongso["thongso_30"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text <?php if($thongso["thongso_30"]['required']=="true"){echo 'fm_required';}?>" name="thongso_30" placeholder="Nhập số ghế" value="<?php if(isset($baiviet['thongso']['thongso_30'])) echo $baiviet['thongso']['thongso_30']; ?>">
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Số cửa<?php if($thongso["thongso_29"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text <?php if($thongso["thongso_29"]['required']=="true"){echo 'fm_required';}?>" name="thongso_29" placeholder="Nhập số cửa" value="<?php if(isset($baiviet['thongso']['thongso_29'])) echo $baiviet['thongso']['thongso_29']; ?>">
                                    </div>
                                    <div class="item-cover-one">
                                        <label class="mar-right">Tiêu thụ</label>
                                        <input type="text" class="free-post-inp-text" name="thongso_35" placeholder="Lit/100 KM" value="<?php if(isset($baiviet['thongso']['thongso_35'])) echo $baiviet['thongso']['thongso_35']; ?>">
                                    </div>
                                </li>
                                <li>
                                    <div class="item-cover-one">

                                        <label>Số điện thoại<?php if($thongso["thongso_63"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input maxlength="15" type="text" class="free-post-inp-text onlynumber  <?php if($thongso["thongso_63"]['required']=="true"){echo 'fm_required';}?>" name="thongso_63" placeholder="Nhập số điện thoại" value="<?php if(isset($baiviet['thongso']['thongso_63'])) echo $baiviet['thongso']['thongso_63']; ?>">

                                    </div>
                                    <div class="item-cover-two">

                                        <label class="mar-right">Địa chỉ<?php if($thongso["thongso_68"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text inp-address  <?php if($thongso["thongso_68"]['required']=="true"){echo 'fm_required';}?>" name="thongso_68" placeholder="Nhập địa chỉ của bạn" value="<?php if(isset($baiviet['thongso']['thongso_68'])) echo $baiviet['thongso']['thongso_68']; ?>">

                                    </div>
                                </li>
                                <li>
                                    <div class="item-cover-one">
                                        <label>Giá tiền<?php if($thongso["thongso_65"]['required']=="true"){echo '<span style="color:red;">*</span>';}?></label>
                                        <input type="text" class="free-post-inp-text onlynumber autonumber <?php if($thongso["thongso_65"]['required']=="true"){echo 'fm_required';}?>" name="thongso_65" placeholder="Nhập giá tiền" value="<?php if(isset($baiviet['thongso']['thongso_65'])) echo $baiviet['thongso']['thongso_65']; ?>">

                                    </div>
                                    <div class="item-cover-two">
                                        <label class="mar-right">Xe này có thể vay</label>
                                        <input type="text" class="free-post-inp-text inp-address onlynumber autonumber " name="thongso_73" value="<?php if(isset($baiviet['thongso']['thongso_73'])) echo $baiviet['thongso']['thongso_73']; ?>" placeholder="Nhập số tiền hỗ trợ">
                                    </div>
                                </li>
                                <li>
                                    <p class="p-title-area">MÔ TẢ XE CỦA BẠN</p>
                                </li>
                                <li>
                                    <textarea style="width: 100%;height: 150px;border: 1px solid #ccc;padding: 5px;" type="textarea" class=" <?php if($thongso["thongso_67"]['required']=="true"){echo 'fm_required';}?>" rows="5" name="thongso_67" id="comment" maxlength="1200" placeholder="Hãy nhập thông tin mô tả chi tiết"><?php if(isset($baiviet['thongso']['thongso_67'])) echo str_replace("<br>","\r\n",$baiviet['thongso']['thongso_67']); ?></textarea>
                                </li>
                                <li>
                                    <div class="col-md-12" style="padding: 0px;">
                                        <div class="parent-img-upload">
                                            <div class="cover-inp-upload">

                                                <input  type="file" class="upload-image img-upload-1" id="photo1" name="file_photo1" size="20"/>
                                                <img id="img_photo1" src="<?php if(isset($baiviet['photo1']) && !empty($baiviet['photo1'])) echo '/uploads/baiviet/'.$baiviet['photo1'];else echo '/images/1.png'; ?>"/>
                                                <input type="hidden" class="fm_required" name="photo1" value="<?php if(isset($baiviet['photo1']) && !empty($baiviet['photo1'])) echo $baiviet['photo1'];?>"/>
                                            </div>
                                            <div class="cover-inp-upload">
                                                <input  type="file" class="upload-image img-upload-2" id="photo2" name="file_photo2" size="20"/>
                                                <img id="img_photo2" src="<?php if(isset($baiviet['photo2']) && !empty($baiviet['photo2'])) echo '/uploads/baiviet/'.$baiviet['photo2'];else echo '/images/2.png'; ?>"/>
                                                <input type="hidden"  class="fm_required" name="photo2"  value="<?php if(isset($baiviet['photo2']) && !empty($baiviet['photo2'])) echo $baiviet['photo2'];?>"/>
                                            </div>
                                            <div class="cover-inp-upload">
                                                <input type="file" class="upload-image img-upload-3" id="photo3" name="file_photo3" size="20"/>
                                                <img id="img_photo3" src="<?php if(isset($baiviet['photo3']) && !empty($baiviet['photo3'])) echo '/uploads/baiviet/'.$baiviet['photo3'];else echo '/images/3.png'; ?>"/>
                                                <input type="hidden"  class="fm_required" name="photo3"  value="<?php if(isset($baiviet['photo3']) && !empty($baiviet['photo3'])) echo $baiviet['photo3'];?>"/>
                                            </div>
                                            <div class="cover-inp-upload">
                                                <input type="file" class="upload-image img-upload-4" id="photo4" name="file_photo4" size="20"/>
                                                <img id="img_photo4" src="<?php if(isset($baiviet['photo4']) && !empty($baiviet['photo4'])) echo '/uploads/baiviet/'.$baiviet['photo4'];else echo '/images/4.png'; ?>"/>
                                                <input type="hidden"  class="fm_required" name="photo4"  value="<?php if(isset($baiviet['photo4']) && !empty($baiviet['photo4'])) echo $baiviet['photo4'];?>"/>
                                            </div>
                                            <div class="cover-inp-upload">
                                                <input type="file" class="upload-image img-upload-5" id="photo5" name="file_photo5" size="20"/>
                                                <img id="img_photo5" src="<?php if(isset($baiviet['photo5']) && !empty($baiviet['photo5'])) echo '/uploads/baiviet/'.$baiviet['photo5'];else echo '/images/5.png'; ?>"/>
                                                <input type="hidden"  class="fm_required" name="photo5"  value="<?php if(isset($baiviet['photo5']) && !empty($baiviet['photo5'])) echo $baiviet['photo5'];?>"/>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                                <li style="text-align: center;">
                                    <input type="button" class="btn-next-free-post" id="btnNext_tab1" value="TIẾP TỤC >>"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php $src_captcha = Captcha::src();?>
                    <div id="tab2" class="tab-pane fade">
                        <p class="p-title-area">CHỌN LOẠI TIN ĐĂNG</p>
                        <div class="common-info">
                            <label class="radio-inline post-normal"><input type="radio" <?php if(empty($baiviet) || (isset($baiviet['loai_tin']) && $baiviet['loai_tin']=="NORMAL")) echo ' checked="checked" '; if(!empty($baiviet)) echo ' disabled="disabled"'; ?> name="optradio" value="NORMAL">TIN THƯỜNG</label>
                            <label class="radio-inline post-vip1"><input type="radio" <?php if(!empty($baiviet)) echo ' disabled="disabled"'; if(isset($baiviet['loai_tin']) && $baiviet['loai_tin']=="VIP001") echo ' checked="checked" '; ?> name="optradio" value="VIP001">TIN VIP 1</label>
                            <label class="radio-inline post-vip2"><input type="radio" <?php if(!empty($baiviet)) echo ' disabled="disabled"'; if(isset($baiviet['loai_tin']) && $baiviet['loai_tin']=="VIP002") echo ' checked="checked" '; ?> name="optradio" value="VIP002">TIN VIP 2</label>
                            <label class="radio-inline post-vip-pro"><input type="radio" <?php if(!empty($baiviet)) echo ' disabled="disabled"';  if(isset($baiviet['loai_tin']) && $baiviet['loai_tin']=="VIPPRO") echo ' checked="checked" ';?> name="optradio" value="VIPPRO">TIN VIP PRO</label>
                            <div class="cover-div-first">
                                <div class="div-one">
                                    <label>Ngày băt đầu</label>
                                    <input <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="text" id="datepicker1" name="actived_from" class="calendar-inp" value="<?php echo date("d/m/Y");?>">
                                </div>
                                <div class="div-two">
                                    <label>Ngày kết thúc</label>
                                    <input <?php if(!empty($baiviet)) echo ' disabled="disabled"'; ?> type="text" id="datepicker2" name="actived_to" class="calendar-inp" value="<?php echo date("d/m/Y",strtotime("+30 days"));?>">
                                </div>
                                <div class="div-three">
                                    <label>Up tin tự động</label>
                                    <div class="cover-radio">
                                        <label class="radio-inline post-normal"><input <?php if(!empty($baiviet)) echo ' disabled="disabled"'; if(empty($baiviet) || (isset($baiviet['auto_up']) && !empty($baiviet['auto_up']))) echo ' checked="checked" '; ?> type="radio" value="1" name="optradio1">Có</label>
                                        <label class="radio-inline post-normal"><input <?php if(!empty($baiviet)) echo ' disabled="disabled"'; if(isset($baiviet['auto_up']) && empty($baiviet['auto_up'])) echo ' checked="checked" ';?> type="radio" value="0" name="optradio1">Không</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="p-title-area">THÀNH TIỀN</p>
                        <div class="div-post-normal">
                            <ul>
                                <li>
                                    <label>Tổng tiền</label>
                                    <input type="text" class="inp-price" value="Miễn phí" disabled="disabled">
                                </li>
                                <li <?php if(!empty($baiviet)) echo ' style="display:none;"'; ?>>
                                    <label>Mã xác nhận</label>
                                    <input type="text" class="code" placeholder="Nhập mã" value="" name="nm_captcha" id="nm_captcha">
                                    <img class="img-cap" src="{{$src_captcha}}"/>
                                </li>
                            </ul>
                        </div>
                        <div class="div-post-vip">
                            <ul>
                                <li>
                                    <div class="div-item-vip-post">
                                        <label>Thời gian</label>
                                        <input type="text" class="inp-normal" value="30 ngày" id="vip_so_ngay"  disabled="disabled">
                                    </div>
                                    <div class="div-item-vip-post">
                                        <label>Loại tin</label>
                                        <input type="text" class="inp-normal" value="" id="vip_loai_tin"  disabled="disabled">
                                    </div>
                                    <div class="div-item-vip-post">
                                        <label>Phí đăng tin</label>
                                        <input type="text" class="inp-normal" value="" id="vip_phi_dang_tin"  disabled="disabled">
                                    </div>
                                </li>
                                <li>
                                    <div class="div-item-vip-post">
                                        <label>Up tin<br> tự động</label>
                                        <input type="text" class="inp-normal" value="" id="vip_auto_up" disabled="disabled">
                                    </div>
                                    <div class="div-item-vip-post">
                                        <label>Tổng tiền</label>
                                        <input type="text" class="inp-normal"  value="" id="vip_total_price" disabled="disabled">
                                    </div>
                                    <div class="div-item-vip-post" <?php if(!empty($baiviet)) echo ' style="display:none;"'; ?>>
                                        <label>Mã xác nhận</label>
                                        <input type="text" class="code" placeholder="Nhập mã" name="vip_captcha"  value="" id="vip_captcha">
                                        <img title="Click để đổi hình khác" class="img-cap" src="{{$src_captcha}}"/>

                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="div-bottom">
                            <p>* NHÂN DỊP RA MẮT HÌNH ẢNH MỚI VIETNAMOTO.NET MIỄN PHÍ 100% TIN ĐĂNG CỦA TẤT CẢ CÁC THỂ LOẠI ĐẾN HẾT NÀY 30/4/2017</p>
                            <input type="submit" class="btn-next-free-post" id="btnSubmit" value="<?php if(!empty($baiviet)) echo 'SAVE & '; ?>ĐĂNG BÀI"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        function loaitin_actived(value){
            if (value == "NORMAL") {
                $(".div-post-normal").fadeIn();
                $(".div-post-vip").hide();
            } else {
                generate_loaibv(value);

                $(".div-post-normal").hide();
                $(".div-post-vip").fadeIn();

            }
        }
        $( document ).ready(function() {
            dhtmlx = parent.dhtmlx;
            <?php
                if(isset($baiviet['hang_xe'])){
                    echo 'getDongXe('.$baiviet['hang_xe'].');';
                }
                if(isset($baiviet['loai_tin']) && !empty($baiviet['loai_tin'])){
                    echo 'loaitin_actived("'.$baiviet['loai_tin'].'");';
                }

            ?>

            $( ".btn-next-free-post" ).click(function() {
                var id = $(this).attr("id");
                if(id.startsWith("btnNext_")){
                    var arr = id.split("_");
                    var  current_tab = arr[1];
                    var tabidx = current_tab.substr(current_tab.length-1,current_tab.length);
                    var next_tab = current_tab.substr(0,current_tab.length-1)+parseInt(parseInt(tabidx)+1);
//            dhtmlx.alert(tabidx+":"+next_tab);
                    var current_tab_tt = "title_"+current_tab;
                    var next_tab_tt = "title_"+next_tab;
                    $("#"+current_tab_tt).removeAttr("class");
                    $("#"+next_tab_tt).attr("class","active");

                    $("#"+current_tab).attr("class","tab-pane");
                    $("#"+next_tab).attr("class","tab-pane in active");
                }

            });
            $(".img-cap").click(function () {
                $.ajax({
                    url: '/changecaptcha',
                    type: 'POST',
                    dataType: "html",
                    cache: false,
                    enctype: 'multipart/form-data',
                    data : {},
                    success : function(data) {
                        $(".img-cap").attr("src",data);
                    }
                });
            });


            $("input:radio[name=optradio]").click(function () {
                var value = $(this).val();
                loaitin_actived(value);
            });
//            var $j = jQuery.noConflict();

            <?php
            if(isset($result) && !empty($result)){
                echo 'dhtmlx.alert("'.$result['mess'].'");';
                echo 'parent.closing();';
            }
            ?>
            try{
                $( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy' });
                $( "#datepicker2" ).datepicker({ dateFormat: 'dd/mm/yy' });
            }catch(e){

            }

        });

        $("#fmbaiviet").submit(function( event ) {
            var cando = true;
            var photo = false;
            $( ".fm_required" ).each(function( index ) {
                var name = $(this).attr("name");
                var type = $(this).attr("type");

                var vl =$(this).val();

                if(type=="textarea"){
//                vl = CKEDITOR.instances['comment'].getData();
                }

                if(vl == null ||vl=="undefined" || vl==""){
                    if(name.startsWith("photo")){
                        photo = true;
                    }
                    cando = false;
                }


            });
            var capc = null;
            var loaiTin = $('input:radio[name=optradio]:checked', '#fmbaiviet').val();
            if(loaiTin=="NORMAL"){
                capc = $("#nm_captcha").val();
            }else{
                capc = $("#vip_captcha").val();
            }
            <?php if(!empty($baiviet)) echo 'capc = "skip";';?>
            if(capc == null ||capc=="undefined" || capc==""){
                cando = false;

            }
            if(!cando){
                event.preventDefault();
                if(photo){
                    dhtmlx.alert("<strong>Vui lòng upload đủ 5 hình ảnh</strong>");
                }else{

                    if(capc == null ||capc=="undefined" || capc==""){
                        dhtmlx.alert("<strong>Vui lòng điền mã xác nhận</strong>");
                    }else{
                        dhtmlx.alert("<strong>Vui lòng điền đầy đủ thông tin bắt buộc</strong>");
                    }

                }

            }

        });
        $(".onlynumber").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        $('input.autonumber').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    ;
            });
        });
        $(".upload-image").change(function () {
            upload_img($(this).attr("id"));

        });
        $("select[name='thongso_20']").change(function() {
            var vl = $("select[name='thongso_20']").val();
//        dhtmlx.alert(vl);
            if(vl!=''){
                getDongXe(vl);
            }else{
                dhtmlx.alert("Vui lòng chọn thương hiệu xe trước!");
            }

        });
        function getDongXe(vl){
            $.ajax({
                url: '/getdongxe',
                type: 'POST',
                dataType: "json",
                cache: false,
                enctype: 'multipart/form-data',
                data : {id:vl},
                success : function(data) {
                    if(data.result){
                        generate_dongxe('thongso_75',data.data);

                    }else{
                        dhtmlx.alert(data.mess);
                    }
                }
            });
        }
        function generate_dongxe(selectName,data){
            var sl = $("select[name='"+selectName+"']");
            //var obj = jQuery.parseJSON(data);
            sl.html('<option value="">Click chọn</option>');
            var dx = 0;
            <?php
                if(isset($baiviet['dong_xe'])){
                    echo 'dx = '.$baiviet['dong_xe'].';';
                }

            ?>
            $.each(data, function(key,value) {

                if(key==dx){
                    sl.append('<option  selected="selected" value="'+key+'">'+value+'</option>');
                }else{
                    sl.append('<option value="'+key+'">'+value+'</option>');
                }

            });
        }
        function upload_img(fileID){
            var formData = new FormData();
            formData.append('file', $("#"+fileID)[0].files[0]);
            $.ajax({
                url: '/baiviet/uploadimg',
                type: 'POST',
                enctype: 'multipart/form-data',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    if(data.result){
                        $("#img_"+fileID).attr("src","/"+data.url);
                        $( "input[name='"+fileID+"']" ).val(data.url);
                    }else{
                        dhtmlx.alert(data.mess);
                    }
                }
            });
        }
        function generate_loaibv(typeID){
            $.ajax({
                url: '/getloaibaiviet',
                type: 'POST',
                dataType: "json",
                cache: false,
                enctype: 'multipart/form-data',
                data : {id:typeID},
                success : function(data) {
                    if(data.result){
                        dt = data.data;
                        calculate_prices();
                    }else{
                        dhtmlx.alert(data.mess);
                    }
                }
            });
        }
        var dt;
        function calculate_prices(){

            if(dt != null){
                $("#vip_loai_tin").val(dt.ten_loai_tin);

                var from = $("#datepicker1").val().split("/");
                var to = $("#datepicker2").val().split("/");

                var date1 = new Date(from[2], from[1] - 1, from[0]);
                var date2 = new Date(to[2], to[1] - 1, to[0]);
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                $("#vip_so_ngay").val(diffDays+" ngày");
                var months =0;
                var days = 0;
                var weeks = 0;
                if(diffDays>0){
                    months = parseInt(diffDays/30);
                    weeks = parseInt((diffDays - 30*months)/7);
                    days = diffDays - 30*months - 7*weeks;
                    var vip_phidt =0;
                    var vip_price_unit = dt.price_unit;
                    if(months>0) vip_phidt +=dt.price_month*months;
                    if(weeks>0) vip_phidt +=dt.price_week*weeks;
                    if(days>0) vip_phidt +=dt.price_day*days;
                    var vip_total = vip_phidt;
                    $("#vip_phi_dang_tin").val(vip_phidt +"  "+vip_price_unit);


                    var autoUp = $('input:radio[name=optradio1]:checked', '#fmbaiviet').val();
                    var numUp = 0;
                    if(autoUp==1){
                        numUp = Math.round(diffDays/7);
                        vip_total += dt.price_day*numUp ;
                    }
                    if(numUp>0){
                        $("#vip_auto_up").val(dt.price_day+"/lần x "+numUp+"lần");
                    }else{
                        $("#vip_auto_up").val("None");
                    }

                    $("#vip_total_price").val(vip_total+"  "+vip_price_unit);
                }else{
                    dhtmlx.alert("Bạn phải đăng tin ít nhất 1 ngày");
                }



            }else{
                generate_loaibv($('input:radio[name=optradio]:checked', '#fmbaiviet').val());
            }
//        dhtmlx.alert(months+":"+days);
        }
        $("input:radio[name=optradio1]").click(function () {
            calculate_prices();

        });
        $(".calendar-inp").change(function() {
            calculate_prices();

        });

    </script>
