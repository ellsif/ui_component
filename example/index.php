<?php
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use ellsif\ui_component\layout\Container\v001\Container;
use ellsif\ui_component\components\Button\v001\Button;

// UiComponent動作確認
$button1 = new Button([], ['tag' => 'button', 'size' => 'lg'], []);
$button2 = new Button([], ['tag' => 'input'], []);
$button3 = new Button([], ['active' => true], []);
$container = new Container([], [], [$button1, $button2, $button3]);
?>
<html>
<head>
    <style>
        <?php echo $button1->getCss() ?>
    </style>
</head>
<body>
<?php
echo $container->getHtml();
?>
</body>
</html>
