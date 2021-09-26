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
function imageResizeRectangleCenter($file, $rectangle = 100, $center = false, $suffix = true, $output = 'JPG') {
    $pathInfo = pathinfo($file);

    $dirname = $pathInfo['dirname'];
    $filename = $pathInfo['filename'];

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

    $filename = $dirname . '/' . $filename;

    if ($suffix) {
        $filename .= '_' . $rectangle;
    }

    switch ($output) {
        case 'JPG':
            $filename .= '.jpeg';
            imagejpeg($image, $filename, 100);
            break;

        case 'GIF':
            $filename .= '.gif';
            imagegif($image, $filename);
            break;

        case 'PNG':
            $filename .= '.png';
            imagepng($image, $filename, 9);
    }

    return $filename;
}
