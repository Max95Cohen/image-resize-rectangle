# Image Resize Rectangle

Resize, rectangle, center .gif, .jpeg, .png image files

## Example

```php
<?php

require 'vendor/autoload.php';

$inputFile = 'example.png';

$resizedFile = imageResizeRectangleCenter($inputFile, 100, true);

echo $resizedFile;
```
