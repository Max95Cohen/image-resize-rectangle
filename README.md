# Image Resize Rectangle

Resize, rectangle, center .bmp, .gif, .jpeg, .png, .wbmp, .webp, .xpm image files

## Example

```php
<?php

require 'vendor/autoload.php';

$inputFile = 'example.png';

$resizedFile = imageResizeRectangleCenter($inputFile, 100, true);

echo $resizedFile;
```
