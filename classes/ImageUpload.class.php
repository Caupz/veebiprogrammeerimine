<?php

class ImageUpload {

    private $tempImg;
    private $thumbImg;
    public $imageFileType;
    private $tempName;
    private $img;
    public $size;
    public $exif;
    public $newFileName;

    public function __construct($imgData, $newFileName) {
        $this->tempName = $imgData['tmp_name'];
        $this->size = $imgData['size'];
        $extension = strtolower(pathinfo(basename($imgData['name']),PATHINFO_EXTENSION));
        $this->imageFileType = $extension;
        $this->imageFromFile();
        $this->newFileName = $newFileName;
        @$this->exif = exif_read_data($this->tempName, "ANY_TAG", 0, true);
    }

    public function __destruct()
    {
        imagedestroy($this->tempImg);
        imagedestroy($this->img);
    }

    public function isValidSize() {
        if ($this->size > 500000) {
            return false;
        }
        return true;
    }

    public function isImageType() {
        return ($this->imageFileType == "jpg" || $this->imageFileType == "png" || $this->imageFileType == "jpeg" || $this->imageFileType == "gif");
    }

    private function imageFromFile() {
        if($this->imageFileType == "jpg" or
            $this->imageFileType == "jpeg") $this->tempImg = imagecreatefromjpeg($this->tempName);
        else if($this->imageFileType == "png") $this->tempImg = imagecreatefrompng($this->tempName);
        else if($this->imageFileType == "gif") $this->tempImg = imagecreatefromgif($this->tempName);
    }

    public function resize($maxWidth, $maxHeight) {
        $imgWidth = imagesx($this->tempImg);
        $imgHeight = imagesy($this->tempImg);

        if($imgWidth > $imgHeight) $ratio = $imgWidth / $maxWidth;
        else $ratio = $imgHeight / $maxHeight;

        $newWidth = round($imgWidth / $ratio);
        $newHeight = round($imgHeight / $ratio);

        $this->img = $this->resizeImage($this->tempImg, $imgWidth, $imgHeight, $newWidth, $newHeight);
    }

    private function resizeImage($tempImg, $imgWidth, $imgHeight, $newWidth, $newHeight, $dstX = 0, $dstY = 0, $srcX = 0, $srcY = 0) {
        $img = imagecreatetruecolor($newWidth, $newHeight);
        imagesavealpha($img, true);
        $transparencyColor = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0,0, $transparencyColor);
        imagecopyresampled($img, $tempImg, $dstX, $dstY, $srcX, $srcY, $newWidth, $newHeight, $imgWidth, $imgHeight);
        return $img;
    }

    public function addWatermark($startX = 0, $startY = 0, $offsetX = -10, $offsetY = -10, $watermarkImageLocation = "/home/cauphel/public_html/veebiprogrammeerimine/pics/vp_logo_w100_overlay.png") {
        $watermark = imagecreatefrompng($watermarkImageLocation);
        $wmWidth = imagesx($watermark);
        $wmHeight = imagesy($watermark);
        $wmPosX = imagesx($this->img) - $wmWidth - $offsetX;
        $wmPosY = imagesy($this->img) - $wmHeight - $offsetY;
        imagecopy($this->img, $watermark, $wmPosX, $wmPosY, $startX, $startY, $wmWidth,$wmHeight);
        // imagecopy(img, watermark, dst_x, dst_y, src_x, _src_y, src_w, src_h)
    }

    public function addText($text, $fontSize = 12, $colorR = 255, $colorG = 0, $colorB = 0, $alpha = 100, $angle = 0, $x = 10, $y = 20, $fontFile = "/home/cauphel/public_html/veebiprogrammeerimine/fonts/ARIALBD.TTF") {
        $wmColor = imagecolorallocatealpha($this->img, $colorR, $colorG, $colorB, $alpha);
        imagettftext($this->img, $fontSize, $angle, $x, $y, $wmColor, $fontFile, $text);
    }

    public function createThumbnail($dir, $size) {
        $width = imagesx($this->tempImg);
        $height = imagesy($this->tempImg);

        if($width > $height) {
            $cutSize = $height;
            $cutX = round(($width - $cutSize) / 2);
            $cutY = 0;
        } else {
            $cutSize = $width;
            $cutX = 0;
            $cutY = round(($height - $cutSize) / 2);
        }

        $thumbnail = imagecreatetruecolor($size, $size);
        imagecopyresampled($thumbnail, $this->tempImg, 0, 0, $cutX, $cutY, $size, $size, $cutSize, $cutSize);
        $newFileName = $dir.$this->newFileName.'_thumbnail.'.$this->imageFileType;

        if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg") imagejpeg($thumbnail, $newFileName, 95);
        else if($this->imageFileType == "png") imagepng($thumbnail, $newFileName);
        else if($this->imageFileType == "gif") imagegif($thumbnail, $newFileName);
    }

    public function save($newFileName) {
        if($this->imageFileType == "jpg" or
            $this->imageFileType == "jpeg") {
            if(imagejpeg($this->img, $newFileName, 95)) {
                return true;
            } else {
                return false;
            }
        }
        else if($this->imageFileType == "png") {
            if(imagepng($this->img, $newFileName)) {
                return true;
            } else {
                return false;
            }
        }
        else if($this->imageFileType == "gif") {
            if(imagegif($this->img, $newFileName)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}

?>