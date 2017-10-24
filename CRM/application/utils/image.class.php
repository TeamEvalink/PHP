<?php
class Images{
	var $inputName;                 //控件名
	var $allowType = array(
				'image/gif','image/jpg','image/jpeg','image/png','image/x-png','image/pjpeg'
	);	                           //上传类型
	var $allowSize = 2097152;	//限制大小
	var $saveDir = "./uploads/";      //保存目录
	var $isRename = true;               //是否重命名，默认为true
	var $errID = 0;                     //错误代码，默认为0
	var $errMsg = "";                   //错误信息
	var $savePath = "";                 //保存路径

	function __construct($inputName,$allowType="",$allowSize="",$saveDir="",$isRename=true){
		if(empty($inputName)){
			$this->chk_err(-1);       //无传入控件名
		}else{
			$this->inputName = $inputName;
		}

		if(!empty($allowType)) $this->allowType = $allowType;
		if(!empty($allowSize)) $this->allowSize = $allowSize;
		if(!empty($saveDir)) $this->saveDir = $saveDir;
		if(!empty($isRename)) $this->isRename = $isRename;
	}

	function is_uploaded(){
		if(empty($_FILES[$this->inputName]['name'])){
			$this->chk_err(4);    //没有文件被上传
		}else{
			if(is_uploaded_file($_FILES[$this->inputName]['tmp_name'])){
				return true;
			}else{
				$this->chk_err(-2);       //文件上传不合法
			}
		}
	}

	function chk_type(){
		if(!in_array($_FILES[$this->inputName]['type'],$this->allowType)){
			$this->chk_err(-3);         //上传的文件类型不被允许
		}else{
			return true;
		}
	}

	function chk_size(){
		if($_FILES[$this->inputName]['size'] > $this->allowSize){
			$this->chk_(-4);          //上传的文件过大
		}else{
			return true;
		}
	}

	function move_uploaded(){        //移动上传文件
		if(!$this->is_uploaded()){
			return false;
		}

		if(!$this->chk_size()){
			return false;
		}

		if(!$this->chk_type()){
			return false;
		}

		//重命名
		if($this->isRename){
			$arrTmp = pathinfo($_FILES[$this->inputName]['name']);
			$extension = strtolower($arrTmp['extension']);
			$file_newname = date("YmdHis").rand(1000,9999)."00.".$extension; //重命名新文件， 00表示为上传的为原图
		}else{
			$file_newname = $_FILES[$this->inputName]['name'];
		}
		
		if(!file_exists($this->saveDir)){       //判断保存目录是否存在
			mkdir($this->saveDir,0777,true);    //建立保存目录
		}

		//移动文件
		$result = move_uploaded_file($_FILES[$this->inputName]['tmp_name'],$this->saveDir."/".$file_newname);

		if($result){
			$path = $this->savePath = $this->saveDir."/".$file_newname;		//文件的成功保存路径
			return $path;
		}else{
			$this->chk_err($_FILES[$this->inputName]['error']);
		}
	
	}

	//判断出错信息
	function chk_err($errID){
		$this->errID = $errID;
		switch($this->errID){
			case -4:
				$this->errMsg = "上传的文件过大";
				break;
			case -3:
				$this->errMsg = "上传的文件类型不被允许";
				break;
			case -2:
				$this->errMsg = "文件上传不合法";
				break;
			case -1:
				$this->errMsg = "无控件名传入";
				break;
			case 1:
				$this->errMsg = '上传的文件超出了php.ini中upload_max_filesize设定的最大值';
				break;
			case 2:
				$this->errMsg = '上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值';
				break;
			case 3:
				$this->errMsg = '文件只有部分被上传';
				break;
			case 4:
				$this->errMsg = '没有文件被上传';
				break;
			default:
				break;
		}
		return false;
	
	}

	function get_errMsg(){
		echo $this->errMsg;  //输出错误信息
	}

    /**
     +----------------------------------------------------------
     * 取得图像信息
     *
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image 图像文件名
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"		=>$imageInfo[0],
                "height"	=>$imageInfo[1],
                "type"		=>$imageType,
                "size"		=>$imageSize,
                "mime"		=>$imageInfo['mime'],
            );
            return $info;
        }else {
            return false;
        }
    }

	/**
     +----------------------------------------------------------
     * 生成缩略图
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $imgPath 裁剪之后的图片存放路径
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     * @param boolean $is_save 是否保留原图
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
	 
    function ImageCreateFrombmp($filename) {  
	    //Ouverture du fichier en mode binaire  
	    if (!$f1 = fopen($filename, "rb"))  
	        return FALSE;  
	  
	    //1 : Chargement des ent�tes FICHIER  
	    $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));  
	    if ($FILE['file_type'] != 19778)  
	        return FALSE;  
	  
	    //2 : Chargement des ent�tes BMP  
	    $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' .  
	            '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .  
	            '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));  
	    $BMP['colors'] = pow(2, $BMP['bits_per_pixel']);  
	    if ($BMP['size_bitmap'] == 0)  
	        $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];  
	    $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel'] / 8;  
	    $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);  
	    $BMP['decal'] = ($BMP['width'] * $BMP['bytes_per_pixel'] / 4);  
	    $BMP['decal'] -= floor($BMP['width'] * $BMP['bytes_per_pixel'] / 4);  
	    $BMP['decal'] = 4 - (4 * $BMP['decal']);  
	    if ($BMP['decal'] == 4)  
	        $BMP['decal'] = 0;  
	  
	    //3 : Chargement des couleurs de la palette  
	    $PALETTE = array();  
	    if ($BMP['colors'] < 16777216) {  
	        $PALETTE = unpack('V' . $BMP['colors'], fread($f1, $BMP['colors'] * 4));  
	    }  
	  
	    //4 : Cr�ation de l'image  
	    $IMG = fread($f1, $BMP['size_bitmap']);  
	    $VIDE = chr(0);  
	  
	    $res = imagecreatetruecolor($BMP['width'], $BMP['height']);  
	    $P = 0;  
	    $Y = $BMP['height'] - 1;  
	    while ($Y >= 0) {  
	        $X = 0;  
	        while ($X < $BMP['width']) {  
	            if ($BMP['bits_per_pixel'] == 24)  
	                $COLOR = unpack("V", substr($IMG, $P, 3) . $VIDE);  
	            elseif ($BMP['bits_per_pixel'] == 16) {  
	                $COLOR = unpack("n", substr($IMG, $P, 2));  
	                $COLOR[1] = $PALETTE[$COLOR[1] + 1];  
	            } elseif ($BMP['bits_per_pixel'] == 8) {  
	                $COLOR = unpack("n", $VIDE . substr($IMG, $P, 1));  
	                $COLOR[1] = $PALETTE[$COLOR[1] + 1];  
	            } elseif ($BMP['bits_per_pixel'] == 4) {  
	                $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));  
	                if (($P * 2) % 2 == 0)  
	                    $COLOR[1] = ($COLOR[1] >> 4);  
	                else  
	                    $COLOR[1] = ($COLOR[1] & 0x0F);  
	                $COLOR[1] = $PALETTE[$COLOR[1] + 1];  
	            }  
	            elseif ($BMP['bits_per_pixel'] == 1) {  
	                $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));  
	                if (($P * 8) % 8 == 0)  
	                    $COLOR[1] = $COLOR[1] >> 7;  
	                elseif (($P * 8) % 8 == 1)  
	                    $COLOR[1] = ($COLOR[1] & 0x40) >> 6;  
	                elseif (($P * 8) % 8 == 2)  
	                    $COLOR[1] = ($COLOR[1] & 0x20) >> 5;  
	                elseif (($P * 8) % 8 == 3)  
	                    $COLOR[1] = ($COLOR[1] & 0x10) >> 4;  
	                elseif (($P * 8) % 8 == 4)  
	                    $COLOR[1] = ($COLOR[1] & 0x8) >> 3;  
	                elseif (($P * 8) % 8 == 5)  
	                    $COLOR[1] = ($COLOR[1] & 0x4) >> 2;  
	                elseif (($P * 8) % 8 == 6)  
	                    $COLOR[1] = ($COLOR[1] & 0x2) >> 1;  
	                elseif (($P * 8) % 8 == 7)  
	                    $COLOR[1] = ($COLOR[1] & 0x1);  
	                $COLOR[1] = $PALETTE[$COLOR[1] + 1];  
	            } else  
	                return FALSE;  
	            imagesetpixel($res, $X, $Y, $COLOR[1]);  
	            $X++;  
	            $P += $BMP['bytes_per_pixel'];  
	        }  
	        $Y--;  
	        $P+=$BMP['decal'];  
	    }  
	  
	    //Fermeture du fichier  
	    fclose($f1);  
	  
	    return $res;  
	}  

    function imagebmp(&$im, $filename = '', $bit = 8, $compression = 0)
{
    if (!in_array($bit, array(1, 4, 8, 16, 24, 32)))
    {
        $bit = 8;
    }
    else if ($bit == 32) // todo:32 bit
    {
        $bit = 24;
    }
    $bits = pow(2, $bit);
 
    // 调整调色板
    imagetruecolortopalette($im, true, $bits);
    $width  = imagesx($im);
    $height = imagesy($im);
    $colors_num = imagecolorstotal($im);
 
    if ($bit <= 8)
    {
        // 颜色索引
        $rgb_quad = '';
        for ($i = 0; $i < $colors_num; $i ++)
        {
            $colors = imagecolorsforindex($im, $i);
            $rgb_quad .= chr($colors['blue']) . chr($colors['green']) . chr($colors['red']) . "\0";
        }
 
        // 位图数据
        $bmp_data = '';
 
        // 非压缩
        if ($compression == 0 || $bit < 8)
        {
            if (!in_array($bit, array(1, 4, 8)))
            {
            $bit = 8;
            }
            $compression = 0;
             
            // 每行字节数必须为4的倍数，补齐。
            $extra = '';
            $padding = 4 - ceil($width / (8 / $bit)) % 4;
            if ($padding % 4 != 0)
            {
            $extra = str_repeat("\0", $padding);
            }
 
            for ($j = $height - 1; $j >= 0; $j --)
            {
                $i = 0;
                while ($i < $width)
                {
                    $bin = 0;
                    $limit = $width - $i < 8 / $bit ? (8 / $bit - $width + $i) * $bit : 0;
 
                    for ($k = 8 - $bit; $k >= $limit; $k -= $bit)
                    {
                        $index = imagecolorat($im, $i, $j);
                        $bin |= $index << $k;
                        $i ++;
                    }
 
                    $bmp_data .= chr($bin);
                }
 
                $bmp_data .= $extra;
            }
        }
        // RLE8 压缩
        else if ($compression == 1 && $bit == 8)
        {
            for ($j = $height - 1; $j >= 0; $j --)
            {
                $last_index = "\0";
                $same_num   = 0;
                for ($i = 0; $i <= $width; $i ++)
                {
                    $index = imagecolorat($im, $i, $j);
                    if ($index !== $last_index || $same_num > 255)
                    {
                        if ($same_num != 0)
                        {
                            $bmp_data .= chr($same_num) . chr($last_index);
                        }
 
                        $last_index = $index;
                        $same_num = 1;
                    }
                    else
                    {
                    $same_num ++;
                    }
                }
 
                $bmp_data .= "\0\0";
            }
 
            $bmp_data .= "\0\1";
        }
        $size_quad = strlen($rgb_quad);
        $size_data = strlen($bmp_data);
    }
    else
    {
    // 每行字节数必须为4的倍数，补齐。
        $extra = '';
        $padding = 4 - ($width * ($bit / 8)) % 4;
        if ($padding % 4 != 0)
        {
            $extra = str_repeat("\0", $padding);
        }
        // 位图数据
        $bmp_data = '';
        for ($j = $height - 1; $j >= 0; $j --)
        {
            for ($i = 0; $i < $width; $i ++)
            {
                $index  = imagecolorat($im, $i, $j);
                $colors = imagecolorsforindex($im, $index);
                if ($bit == 16)
                {
                    $bin = 0 << $bit;
 
                    $bin |= ($colors['red'] >> 3) << 10;
                    $bin |= ($colors['green'] >> 3) << 5;
                    $bin |= $colors['blue'] >> 3;
 
                    $bmp_data .= pack("v", $bin);
                }
                else
                {
                    $bmp_data .= pack("c*", $colors['blue'], $colors['green'], $colors['red']);
                }
 
                // todo: 32bit;
            }
            $bmp_data .= $extra;
        }
        $size_quad = 0;
        $size_data = strlen($bmp_data);
        $colors_num = 0;
    }
 
    // 位图文件头
    $file_header = "BM" . pack("V3", 54 + $size_quad + $size_data, 0, 54 + $size_quad);
 
    // 位图信息头
    $info_header = pack("V3v2V*", 0x28, $width, $height, 1, $bit, $compression, $size_data, 0, 0, $colors_num, 0);
 
    // 写入文件
    if ($filename != '')
    {
        $fp = fopen($filename, "wb");
        fwrite($fp, $file_header);
        fwrite($fp, $info_header);
        fwrite($fp, $rgb_quad);
        fwrite($fp, $bmp_data);
        fclose($fp);        
        return true;
    }
 
    // 浏览器输出
    header("Content-Type: image/bmp");
    echo $file_header . $info_header;
    echo $rgb_quad;
    echo $bmp_data;
    return true;
}
    function thumb( $targetImgSize,$imgPath, $image,$is_save=true,$suofang=0,$type='',$maxWidth=500,$maxHeight=500,$interlace=true){
        // 获取原图信息
       $info  = $this->getImageInfo($image);
         if($info !== false) {
            $srcWidth  = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
			$type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            if ($suofang==1) {
                $width  = $srcWidth;
                $height = $srcHeight;
            } else {
                $scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
                if($scale>=1) {
                    // 超过原图大小不再缩略
                    $width   =  $srcWidth;
                    $height  =  $srcHeight;
                }else{
                    // 缩略图尺寸
                    $width  = (int)($srcWidth*$scale);	//147
                    $height = (int)($srcHeight*$scale);	//199
                }
            }
            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            if ($createFun=='ImageCreateFrombmp') {
            	$srcImg = $this->$createFun($image);
            }else{
            	$srcImg = $createFun($image);
            }
            

            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);
            //return $width.",".$height;
            // 复制图片
            if(function_exists("ImageCopyResampled")){
            	imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            }else{
            	imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
            }
            if('gif'==$type || 'png'==$type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
				imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }
            // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	imageinterlace($thumbImg,$interlace);
            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image'.($type=='jpg'?'jpeg':$type); 

            $qulity = $type=='jpg'?100:9;
			$length = strlen("00.".$type) * (-1);
			$_type = substr($image,-4);
			$length = ($type != $_type ? $length+1 : $length);
            //裁剪
            if ($suofang==1) {
				
				//$thumbname01 = substr_replace($image,"01.".$type,$length);		//大头像
				//$thumbname02 = substr_replace($image,"02.".$type,$length);		//小头像
				$imageName = md5(uniqid()).".".$type;
				$thumbname01 = $imgPath.$imageName;		//大头像

	            if ($imageFun=='imagebmp') {
	            	$this->$imageFun($thumbImg,$thumbname01,$qulity);
	            }else{
	            	$imageFun($thumbImg,$thumbname01,$qulity);
	            }
				//$imageFun($thumbImg,$thumbname02,100);

                $thumbImg01 = imagecreatetruecolor($_POST['w'],$_POST['h']);
                imagecopyresampled($thumbImg01,$thumbImg,0,0,$_POST['x'],$_POST['y'],$_POST['w'],$_POST['h'],$_POST['w'],$_POST['h']);

				//$thumbImg02 = imagecreatetruecolor(48,48);
                //imagecopyresampled($thumbImg02,$thumbImg,0,0,$_POST['x'],$_POST['y'],48,48,$_POST['w'],$_POST['h']);

	            if ($imageFun=='imagebmp') {
	            	$this->$imageFun($thumbImg01,$thumbname01,$qulity);
	            }else{
	            	$imageFun($thumbImg01,$thumbname01,$qulity);
	            }
				//$imageFun($thumbImg01,$thumbname01,$qulity);
				//$imageFun($thumbImg02,$thumbname02,100);
//				unlink($image);
				imagedestroy($thumbImg01);
				//imagedestroy($thumbImg02);
				imagedestroy($thumbImg);
				imagedestroy($srcImg);

				//return array('big' => $thumbname01 , 'small' => $thumbname02);	//返回包含大小头像路径的数组
				return array('big' => $imageName );	//返回包含大小头像路径的数组
            }else{
				if($is_save == false){											//缩略图覆盖原图，缩略图的路径还是原图路径

		            if ($imageFun=='imagebmp') {
		            	$this->$imageFun($thumbImg,$image,$qulity);
		            }else{
		            	$imageFun($thumbImg,$image,$qulity);
		            }
					
				}else{
					$thumbname03 = substr_replace($image,"03.".$type,$length);	//缩略图与原图同时存在，

		            if ($imageFun=='imagebmp') {
		            	$this->$imageFun($thumbImg,$thumbname03,$qulity);
		            }else{
		            	$imageFun($thumbImg,$thumbname03,$qulity);
		            }
					

					imagedestroy($thumbImg);
					imagedestroy($srcImg);
					return $thumbname03 ;					//返回缩略图的路径，字符串
				}
			}

         }
         return false;
    }
}
///***************
//	./uploads/2011/6/23/201106231015231234985800.jpg	----->上传到服务器上的原始图
//	./uploads/2011/6/23/201106231015231234985801.jpg	----->裁剪的大头像  190*195
//	./uploads/2011/6/23/201106231015231234985802.jpg	----->裁剪的小头像	48*48
//	./uploads/2011/6/23/201106231015231234985803.jpg	----->超过规定尺寸后的缩略图