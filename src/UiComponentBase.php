<?php
namespace ellsif\ui_component;

/**
 * UIコンポーネント基底クラス
 */
abstract class UiComponentBase
{
    protected $id;

    // HTMLに埋め込む値の配列
    protected $values;

    // AttributeのID
    protected $attributeId;

    // Attributes（CSSに埋め込む値の配列）
    protected $attributes;

    // 子コンポーネント
    protected $childComponents;

    // コンポーネントの名前（class名に利用）
    protected $componentName;

    // コンポーネントのバージョン
    protected $version;

    public const MEDIA_SIZE_LIST = [
        '', 'sm', 'md', 'lg', 'xl'
    ];

    public function __construct($values, $attributes, $childComponents, $options = [])
    {
        $this->values = array_merge(static::getDefaultValues(), $values);
        $this->attributes = array_merge(static::getDefaultAttributes(), $attributes);
        $this->childComponents = $childComponents;

        // TODO attributesについては別途検討が必要になる。
        /*
        if ($attributes) {
            // TODO attributesが追加された場合、CSSが変わるため、個別のidを指定する必要がある。
            $this->attributes = array_merge(static::getDefaultAttributes(), $attributes);
        }
        */

        $class = get_class($this);
        $classNames = explode("\\", $class);
        $this->componentName = $classNames[count($classNames) - 1];
        $this->version = $classNames[count($classNames) - 2];

        // TODO オプションの扱い
        // _valiables.scssとかを追加したい場合がある・・・？
    }

    /**
     * コンポーネントの名称を取得します。
     */
    public function getComponentName()
    {
        return $this->componentName;
    }

    /**
     * コンポーネントのバージョンを取得します。
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * CSSに利用するクラス名を取得します。
     */
    public function getClassName()
    {
        $className = $this->componentName . '-' . $this->version;
        if ($this->attributeId) {
            $className .= ' attribute-' . $this->attributeId;
        }
        return $className;
    }

    /**
     * デフォルトのattributesを返します。
     */
    public static abstract function getDefaultAttributes();

    /**
     * デフォルトのvaluesを返します。
     */
    public static abstract function getDefaultValues();

    /**
     * コンポーネントのCSS(SCSS)を取得します。
     */
    public abstract function css($type = '');

    /**
     * コンポーネントが利用するJavaScriptを取得します。
     */
    public abstract function script();

    /**
     * コンポーネントが利用するHTMLを取得します。
     */
    public abstract function html();

    /**
     * コンポーネントのラベル（表示名）を取得します。
     */
    public abstract function getLabel();

    /**
     * コンポーネントの出力用CSSを取得します。
     */
    public function getCss()
    {
        $css = '';
        foreach(self::MEDIA_SIZE_LIST as $size) {
            ob_start();
            $this->css($size);
            $scss = ob_get_contents();
            ob_end_clean();
            $css .= $scss;  // TODO 加工して専用のCSSにする
        }
        return $this->scssCompile($css);
    }

    /**
     * コンポーネントの出力用JSを取得します。
     */
    public function getScript()
    {
        ob_start();
        $this->script();
        $script = ob_get_contents();
        ob_end_clean();
        return $script; // TODO 加工してカプセル化
    }

    /**
     * コンポーネントの出力用HTMLを取得します。
     */
    public function getHtml()
    {
        ob_start();
        $this->html();
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * 継承先のコンポーネントは出来るだけドキュメントを表示してあげてほしい
     */
    public function getDocument()
    {
        return 'in preparation';
    }

    // 切り出したSCSSを加工してコンパイル
    protected function scssCompile($scss) {
        $from = mb_strpos($scss, '{') + 1;
        $to = mb_strpos($scss, '</') - $from;
        $scss = mb_substr($scss, $from, $to);
        $scss = '.' . $this->componentName . '-' . $this->version .' {' . $scss;
        $scss = addslashes(trim(str_replace("\n", "" , $scss)));
        $scss = exec("echo \"".$scss."\" | sass -s -t compressed --scss");
        return $scss;
    }
}