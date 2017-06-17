<?php
/**
 * Created by PhpStorm.
 * User: LeeThong
 * Date: 3/21/2017
 * Time: 7:26 PM
 */
namespace App\Console\Commands;

use App\Models\Baiviet;
use Illuminate\Console\Command;
use Hash;
use DB;

class ThumbnailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumb:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = public_path()."/uploads/baiviet/";
        $thumnailPath = $path.$this->THUMB_FOLDER."/";
        if(is_dir($path)){

            $list = Baiviet::getListNew();
            $arrFiles =array();
            if(!empty($list)){
                foreach ($list as $v){
                    $arrFiles[] = $v->photo1;
                    $arrFiles[] = $v->photo2;
                    $arrFiles[] = $v->photo3;
                    $arrFiles[] = $v->photo4;
                    $arrFiles[] = $v->photo5;
                }
            }


//            $arrFiles = scandir($path);
            $i = 0;
            foreach ($arrFiles as $fpath){
//                if($i>100) break;
                if($fpath !="index.html"  && $fpath !="index.php"  && $fpath !="." && $fpath !=".." && !is_dir($path.$fpath)){

                    $r = $this->makeThumbnails($path,$fpath);
                    if($r !== false){
                        echo 'Created : '.$fpath.PHP_EOL;
                        $i++;
                    }else{
                        echo 'Skiped : '.$fpath.PHP_EOL;
                    }


                }
            }
        }


    }
    private $THUMB_FOLDER = "thumb";
    private $ADJUST_FOLDER ="adjust";
    private  $THUMB_TYPE = array(
//        'pc'=>array(
//            'folder'=>'pc',
//            'width' =>414,
//            'height'=>282
//        ),
        'tablet'=>array(
            'folder'=>'tablet',
            'width' =>212,
            'height'=>141

        ),
        'mobile'=>array(
            'folder'=>'m',
            'width' =>142,
            'height'=>94

        ),
        'share' => array(
            'folder' => 'share',
            'width' => 426,
            'height' => 282

        )
    );
    private function createIMGMaxSize($updir,$fName,$width,$height){

        if(!file_exists("$updir" . "$this->ADJUST_FOLDER/")){
            mkdir("$updir" . "$this->ADJUST_FOLDER", 0777);
        }
        if(file_exists("$updir" . "$fName")){
            $arr_image_details = getimagesize("$updir" . "$fName");
            $original_width = $arr_image_details[0];
            $original_height = $arr_image_details[1];
            $wn = floor($original_width/$width);
            $hn = floor($original_height/$height);
            $maxn = $wn;
            if($hn < $maxn) $maxn = $hn;
            if($maxn==0) $maxn =1;
            $newWidth = $width*$maxn;
            $newHeight = $height*$maxn;
            $top = floor($original_height/2 - $newHeight/2);
            $left = floor($original_width/2 - $newWidth/2);

            if ($arr_image_details[2] == IMAGETYPE_GIF) {
                $imgt = "ImageGIF";
                $imgcreatefrom = "ImageCreateFromGIF";
            }
            if ($arr_image_details[2] == IMAGETYPE_JPEG) {
                $imgt = "ImageJPEG";
                $imgcreatefrom = "ImageCreateFromJPEG";
            }
            if ($arr_image_details[2] == IMAGETYPE_PNG) {
                $imgt = "ImagePNG";
                $imgcreatefrom = "ImageCreateFromPNG";
            }
            if($imgt){
                $result = array(
                    'imgType' =>$imgt,
                    'Height' =>$newHeight,
                    'Width' =>$newWidth,

                );
                $old_image = $imgcreatefrom("$updir" . "$fName");
                if($original_width > $newWidth && $original_height >$newHeight){
                    $new_image = @imagecrop($old_image, ['x' => $left, 'y' => $top, 'width' => $newWidth, 'height' => $newHeight]);
                    $result['img'] = $new_image;
                }else{
                    $result['img'] = false;
                }
                imagedestroy($old_image);
                $old_image = null;

                return $result;
            }

        }
        return null;


    }
    private function makeThumbnails($updir, $img)
    {
        if(!empty($img) && !empty($updir)){
            $result = false;
            foreach ($this->THUMB_TYPE as $type){
                if(!file_exists("$updir" . "$this->THUMB_FOLDER/".$type['folder']."/" )){
                    mkdir("$updir" . "$this->THUMB_FOLDER/".$type['folder'] , 0777);
                }
                $width = $type['width'];
                $height = $type['height'];
                if(!file_exists("$updir" . "$this->THUMB_FOLDER/".$type['folder']."/" . "$img")){
                    $er = error_reporting(0);
                    $old_image = $this->createIMGMaxSize($updir,$img,$width,$height);

                    if (!empty($old_image)) {

                        if($old_image['img']===false){
                            copy("$updir" ."$img","$updir" . "$this->THUMB_FOLDER/".$type['folder']."/" . "$img");
                        }else{
                            $new_image = imagecreatetruecolor($width, $height);
                            @imagecopyresized($new_image, $old_image['img'],0,0, 0, 0,$width, $height, $old_image['Width'], $old_image['Height']);
//                    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
                            $imgt = $old_image['imgType'];
                            $imgt($new_image, "$updir" . "$this->THUMB_FOLDER/".$type['folder']."/" . "$img");
//                            imagegif($new_image, "$updir" . "$this->THUMB_FOLDER/".$type['folder']."/" . "$img");
                        }
                        $old_image = null;
                        $result =  true;
                    }
                    error_reporting($er);
                }
            }
            return $result;

        }

        return false;
    }
}