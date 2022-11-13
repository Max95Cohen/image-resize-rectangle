<?php

/**
 * Resize image to rectangle shape and take center of image if you wish.
 *
 * @param string $file Path to current image file
 * @param int $rectangle Size of new image
 * @param false $center Take of image center
 * @param bool $suffix Add a suffix size of image
 * @param string $output Export type
 * @return false|string
 */
function imageResizeRectangleCenter(
    $file,
    $rectangle = 100,
    $center = false,
    $suffix = true,
    $output = 'JPG',
    $quality = 85
) {
    $pathInfo = pathinfo($file);

    $extension = $pathInfo['extension'];
    $dirname = $pathInfo['dirname'];
    $filename = $pathInfo['filename'];

    unset($pathInfo);

    list($width, $height, $type) = getimagesize($file);

    $dimension = ($width / $height);

    $width_ = $height_ = $rectangle;

    $image = imagecreatetruecolor($width_, $height_);

    $offsetX = $offsetY = 0;

    if ($dimension >= 1) {
        $width_ = round($width_ * $dimension);

        if ($center) {
            $offsetX = round(($width / 2) - ($height / 2));
        }
    } else {
        $height_ = round($height_ / $dimension);

        if ($center) {
            $offsetY = round(($height / 2) - ($width / 2));
        }
    }

    unset($dimension);

    if (defined('IMG_WEBP') && function_exists('imagecreatefromwebp')) {
        $source = imagecreatefromwebp($file);
    } elseif (defined('IMG_BMP') && function_exists('imagecreatefrombmp')) {
        $source = imagecreatefrombmp($file);
    } else {
        switch ($type) {
            case IMG_GIF:
                $source = imagecreatefromgif($file);
                break;
            case IMG_JPEG:
                $source = imagecreatefromjpeg($file);
                break;
            case IMG_PNG:
                $source = imagecreatefrompng($file);
                break;
            case IMG_WBMP:
                $source = imagecreatefromwbmp($file);
                break;
            case IMG_XPM:
                $source = imagecreatefromxpm($file);
                break;
            default:
                return false;
        }
    }

    unset($center, $type);

    imagecopyresampled($image, $source, 0, 0, $offsetX, $offsetY, $width_, $height_, $width, $height);
    imagedestroy($source);

    unset($source, $offsetX, $offsetX, $width, $width_, $height, $height_);

    $filename = $dirname . '/' . $filename;

    unset($dirname);

    if ($suffix) {
        $filename .= '_' . $rectangle;
    }

    switch ($output) {
        case 'JPG':
            $filename .= '.' . $extension;
            imagejpeg($image, $filename, $quality);
            break;

        case 'GIF':
            $filename .= '.gif';
            imagegif($image, $filename);
            break;

        case 'PNG':
            $filename .= '.png';
            $quality_ = floor($quality / 10);

            imagepng($image, $filename, $quality_);
    }

    imagedestroy($image);

    unset($suffix, $image);

    return $filename;
}
