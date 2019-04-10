<?php
namespace ellsif\ui_component\layout\Container\v001;

use ellsif\ui_component\UiComponentBase;

class Container extends UiComponentBase
{
    /**
     * コンポーネントのラベル（表示名）を取得します。
     */
    public function getLabel()
    {
        return 'コンテナ';
    }

    /**
     * デフォルトのattributesを返します。
     */
    public static function getDefaultAttributes()
    {
        return [];
    }

    /**
     * デフォルトのvaluesを返します。
     */
    public static function getDefaultValues()
    {
        return [];
    }

    /**
     * コンポーネントのCSS(SCSS)を取得します。
     */
    public function css($type = '')
    {
        if ($type === '') {
            ?>
            <style type="text/scss">
                .container {
                    max-width: $containerMaxWidth;
                }
            </style>
            <?php
        }
    }

    /**
     * コンポーネントが利用するJavaScriptを取得します。
     */
    public function script()
    {
        // script無し
    }

    /**
     * コンポーネントが利用するHTMLを取得します。
     */
    public function html()
    {
        ?>
            <div class="<?php echo $this->getClassName() ?>">
                <?php foreach ($this->childComponents as $childComponent) : ?>
                    <?php echo $childComponent->getHtml() ?>
                <?php endforeach ?>
            </div>
        <?php
    }
}