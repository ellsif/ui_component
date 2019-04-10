<?php
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use ellsif\ui_component\layout\Container\v001\Container;

// UiComponent動作確認
$uiComponent = new Container([], null, []);
echo $uiComponent->getHtml();