<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function dhtmlx_form($thongso=array(),$lbwidth=null,$ipWidth=null,$value=null)
    {
        if(empty($lbwidth)){
            $lbwidth = 150;
        }
        if(empty($ipWidth)){
            $ipWidth = 150;
        }
        $content = "";
        if(!empty($thongso)){

            if(empty($value)){
                $value = $thongso['default_value'];
            }
            switch ($thongso['type']){
                case "input":
                    $rows = "";
                    if(!empty($thongso['rows'])){
                        $rows = ', rows:'.$thongso['rows'];
                    }
                    $content = '{type: "'.$thongso['type'].'", required: '.$thongso['required'].', name: "'
                        .'thongso_'.$thongso['id'].'", labelAlign: "right", label: "'.$thongso['name'].'", labelWidth: '
                        .$lbwidth.', inputWidth: '.$ipWidth.', value: "'.$value.'", tooltip: "vui lòng nhập '
                        .$thongso['name'].'" '.$rows.'}';
                    break;
                case "checkbox":
                    $content = '{type: "'.$thongso['type'].'", required: '.$thongso['required'].', value: "'.$value.'", name: "'.'thongso_'
                        .$thongso['id'].'", labelAlign: "right", label: "'.$thongso['name'].'", labelWidth: '.$lbwidth.', tooltip: "vui lòng nhập '.$thongso['name'].'"}';
                    break;

                case "combo":

                    $content = '{type: "'.$thongso['type'].'" , value: "'.$value.'", required: '.$thongso['required'].', labelAlign: "right", label: "'.$thongso['name'].'", name: "'.'thongso_'.$thongso['id'].'", labelWidth: '.$lbwidth.', inputWidth: '.$ipWidth.', options:'.$thongso['options'].'}';

                    //[{text: "2017", value: "AAC"},{text: "AC3", value: "AC3", selected: true},{text: "MP3", value: "MP3"},{text: "FLAC", value: "FLAC"}]
                    break;
            }

        }

        return $content;
    }

    public  static  function  search_field($thongso = array(),$init_value =null,$default_value = null,$name = null){

        $content = "";
        if(!empty($thongso)){

            if(empty($name)){
                $name = 'thongso_'.$thongso['id'];
            }
            switch ($thongso['type']){
                case "combo":
                    $content .='<select class="form-control inp-filter" name="'.$name.'">';
                    if(!empty($init_value)){
                        $content .='<option value="">'.$init_value.'</option>';
                    }
                    $options = str_replace("[{","",$thongso['options']);
                    if(!empty($options)){
                        $arr_options = explode("},{",$options);
                        if(!empty($arr_options)){
                            foreach ($arr_options as  $v){
                                $arr2 = explode(",",$v);

                                if(count($arr2)==2){
                                    $value = "";
                                    $text ="";
                                    foreach ($arr2 as $v2){
                                        if(strpos($v2,"value")){
                                            $value = self::get_string_between($v2,'"','"');
                                        }else{
                                            $text = self::get_string_between($v2,'"','"');
                                        }
                                    }
                                    if(!empty($value) || !empty($text)){
                                        $selected ="";

                                        if($default_value != null && $value == $default_value){
                                            $selected = 'selected ="true"';
                                        }
                                        $content .='<option value="'.$value.'" '.$selected.'>'.$text.'</option>';
                                    }
                                }



                            }
                        }

                    }

                    $content .='</select>';
                    break;
                case "input":
                    break;
                default: break;
            }

        }


        return $content;
    }
    private static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}