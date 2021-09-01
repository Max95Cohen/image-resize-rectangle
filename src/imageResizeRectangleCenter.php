<?php

function imageResizeRectangleCenter($file, $rectangle = 100, $center = false, $output = 'JPG') {
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

    switch ($type) {
        case 1:
            $source = imagecreatefromgif($file);
            break;
        case 2:
            $source = imagecreatefromjpeg($file);
            break;
        case 3:
            $source = imagecreatefrompng($file);
            break;
        default:
            return false;
    }

    imagecopyresampled($image, $source, 0, 0, $offsetX, $offsetY, $width_, $height_, $width, $height);

    $file_ = $file . '_' . $rectangle;

    switch ($output) {
        case 'JPG':
            $file_ .= '.jpeg';
            imagejpeg($image, $file_, 100);
            break;

        case 'GIF':
            $file_ .= '.gif';
            imagegif($image, $file_);
            break;

        case 'PNG':
            $file_ .= '.png';
            imagepng($image, $file_, 9);
            break;

    }

    return $file_;
}
