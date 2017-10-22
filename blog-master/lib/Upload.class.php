<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/5/7
 * Time: 10:22
 */
class Upload{
    private $allow_ext_list = array(
        '.jpeg','.jpg','.gif','.png'
    );
    private $allow_max_size = 1048576;
    private $upload_path = './';
    private $prefix = '';

    public function setAllowExtList($ext_list)
    {
        $this->allow_ext_list = $ext_list;
    }
    public function setAllowMaxSize($max_size)
    {
        $this->allow_max_size = (int)$max_size;
    }
    public function setUploadPath($path)
    {
        $this->upload_path = $path;
    }
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
    private $ext2mime =array(
        '.jpeg' => 'image/jpeg',
        '.png'	=> 'image/png',
        '.gif'	=> 'image/gif',
        '.jpg'	=> 'image/jpeg',
        '.html'	=> 'text/html',
    );
    private function getMIME($ext_list)
    {
        $mime_list = [];
        foreach ($ext_list as $value)
        {
            $mime_list[] = $this->ext2mime[$value];
        }
        return $mime_list;
    }

    public function uploadfile($file)
    {
        if( 0 != $file['error'])
        {
            trigger_error('upload file error');
            return false;
        }

        $ext = strrchr($file['name'],'.');
        if(!in_array($ext,$this->allow_ext_list))
        {
            trigger_error('file type error ,ext');
            return false;
        }
        $allow_mime_list = $this->getMIME($this->allow_ext_list);
        $finfo = new Finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if(!in_array($mime,$allow_mime_list))
        {
            trigger_error('type error ,mime');
            return false;
        }

        if($file['size'] > $this->allow_max_size)
        {
            trigger_error('file over big');
            return false;
        }

        $subdir = date('Ymd') . '/';
        if(!is_dir($this->upload_path . $subdir))
        {
            mkdir($this->upload_path .$subdir);
        }

        $basename = uniqid($this->prefix,true) .$ext;
        $result_move = move_uploaded_file($file['tmp_name'],$this->upload_path .$subdir.$basename);
        if(!$result_move)
        {
            trigger_error('move error');
            return false;
        }
        return $subdir . $basename;
    }
}