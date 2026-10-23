<?php
class Thumbnail{
    private $thumbnail;
    private $thumbnail_width;
    private $thumbnail_height;
    private $image;
    private $image_width;
    private $image_height;
    private $image_type;
    
    public $error;
    
    public function __construct($source) {
        $image_info = getimagesize($source);
        
        if($image_info) {
          $this->image_width = $image_info[0];
          $this->image_height = $image_info[1];    
          $this->image_type = $image_info[2];        
            
          switch($this->image_type) {
              case IMAGETYPE_JPEG: {          
                  $this->image = imagecreatefromjpeg($source);
                  break;
              }
                  
              case IMAGETYPE_GIF: {          
                  $this->image = imagecreatefromgif($source);
                  break;
              }      
            
              case IMAGETYPE_PNG: {          
                  $this->image = imagecreatefrompng($source);
                  break;
              }      
                  
              default:{
                  $this->error = 'Formato no soportado';
                  break;
                  
              }
          }
        }
        else {
            $this->error = 'Formato invalido';
        }
    }
    
    public function resize($width, $height = 0) {
        $this->thumbnail_width = $width;
        
        if($height == 0){
            $this->thumbnail_height = $width;
        }else {
            $this->thumbnail_height = $height;
        }
        $this->thumbnail = imagecreatetruecolor($this->thumbnail_width, $this->thumbnail_height);
        
        imagecopyresampled(
            $this->thumbnail, $this->image, 0, 0, 0, 0,
            $this->thumbnail_width, $this->thumbnail_height,
            $this->image_width, $this->image_height
            );
    }
   
    public function save_jpg($name, $quality = 95){
        $path = 'tmp/'. $name;
        imagejpeg($this->thumbnail, $path, $quality);
    
        imagedestroy($this->thumbnail);    
    }
    
     public function save_gif($name){
        $path = 'tmp/'. $name;
        imagegif($this->thumbnail, $path);
    
        imagedestroy($this->thumbnail);    
    }
    
     public function save_png($name){
        $path = 'tmp/'. $name;
        imagepng($this->thumbnail, $path);
    
        imagedestroy($this->thumbnail);    
    }
}
    
?>    
    
    
