<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/5/7
 * Time: 17:19
 */
class Captcha{
    private $code_length = 4;
    private $width=320;
    private $height = 30;
    private $font =5;
    private $pixel_number =100;
    public function setCodeLength($length)
    {
        $this->code_length = $length;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function setPixelNumber($number)
    {
        $this->pixel_number = $number;
    }
    public function mkimage()
    {
        $char_list = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $char_length = strlen($char_list);
        $code = '';
        for ($i = 1 ;$i<=$this->code_length ;++$i)
        {
            $rand_index = mt_rand(0,$char_length-1);
            $code .=$char_list[$rand_index];
        }
        @session_start();
        $_SESSION['captcha_code'] = $code;

        //create image
        $image = imagecreatetruecolor($this->width,$this->height);

        //operate image
        $bg_color = imagecolorallocate($image,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        imagefill($image,0,0,$bg_color);
        //set the key
        $code_color = imagecolorallocate($image,mt_rand(50,150),mt_rand(50,150),mt_rand(50,150));
        $font_width = imagefontwidth($this->font);
        $font_height = imagefontheight($this->font);
        $code_x = ($this->width - $font_width*$this->code_length)/2;
        $code_y = ($this->height - $font_height)/2;
        imagestring($image,$this->font,$code_x,$code_y,$code,$code_color);

        //set pixelers
        for($i = 1; $i<=$this->pixel_number; ++$i)
        {
            $pixel_color = imagecolorallocate($image,mt_rand(50,150),mt_rand(50,150),mt_rand(50,150));
            imagesetpixel($image,mt_rand(0,$this->width-1),mt_rand(0,$this->height-1),$pixel_color);
        }
        header('Content-type:image/png');
        header('Cache-Control: no-cache no-store must-revalidate');
        header('Expire:'.gmdate('D,d M Y H:i:s',time()-1) .'GMT');
        imagepng($image);

        imagedestroy($image);
    }
    public function checkCode($post_code)
    {
        @session_start();
        // 严谨性：同时存在 并且相等！
        $result = isset($post_code) && isset($_SESSION['captcha_code']) && $post_code==$_SESSION['captcha_code'];
        // 验证码使用过一次，一定要消灭！
        if (isset($_SESSION['captcha_code'])) {
            unset($_SESSION['captcha_code']);
        }
        // 返回验证结果
        return $result;
    }
}