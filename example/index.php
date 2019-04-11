<?php
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use ellsif\ui_component\layout\Container\Container\v001\Container;
use ellsif\ui_component\components\Button\Button\v001\Button;

// UiComponent動作確認
$button1 = new Button(['tag' => 'button', 'size' => 'xs', 'kind' => 'info']);
$button2 = new Button(['tag' => 'input', 'size' => 'sm', 'kind' => 'warning']);
$button3 = new Button(['active' => true, 'kind' => 'danger']);
$button4 = new Button(['tag' => 'button', 'size' => 'lg', 'kind' => 'light']);
$button5 = new Button(['tag' => 'button', 'size' => 'xl', 'kind' => 'dark']);
$container = new Container([]);
$container->addChildComponent($button1)
    ->addChildComponent($button2)
    ->addChildComponent($button3)
    ->addChildComponent($button4)
    ->addChildComponent($button5);
?>
<html>
<head>
    <style>
		<?php echo $container->getCss() ?>
        <?php echo $button1->getCss() // TODO attribute指定の有無によって調整が必要で・・・？ないか？自分でスタイル追加はHTMLでいい気もするが。。。 ?>
    </style>
</head>
<body>
<?php
echo $container->getHtml();
?>
</body>
</html>
