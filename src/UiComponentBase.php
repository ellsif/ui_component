<?php
namespace ellsif\ui_component;

/**
 * UIコンポーネント基底クラス
 */
abstract class UiComponentBase
{
    protected $id;

    // Attributes（CSSに埋め込む値の配列）
    protected $attributes;

    // 子コンポーネントの配列（UiComponentまたはstring）
    protected $childComponents = [];

    // コンポーネントの名前（class名に利用）
    protected $componentName;

    // オプション（追加SCSS）
    protected $optionScssFiles;

    // コンポーネントのバージョン
    protected $version;

    public const MEDIA_SIZE_LIST = [
        '', 'sm', 'md', 'lg', 'xl'
    ];

    public function __construct($attributes, $optionScssFiles = [])
    {
        $this->attributes = array_merge(static::getDefaultAttributes(), $attributes);
        $class = get_class($this);
        $classNames = explode("\\", $class);
        $this->componentName = $classNames[count($classNames) - 1];
        $this->version = $classNames[count($classNames) - 2];
        $this->optionScssFiles = $optionScssFiles;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * 子コンポーネントを追加します。
     */
    public function addChildComponent($component)
    {
        if (is_string($component) || $component instanceof UiComponentBase) {
            $this->childComponents[] = $component;
        } else {
            throw new \InvalidArgumentException('invalid argument type addChild()');
        }
        return $this;
    }

    /**
     * 子コンポーネントのリストを取得します。
     */
    public function getChildComponents()
    {
        return $this->childComponents;
    }

    /**
     * コンポーネントの名称を取得します。
     */
    public function getComponentName($includeVersion = false)
    {
        if ($includeVersion) {
            return $this->componentName . '-' . $this->getVersion();
        } else {
            return $this->componentName;
        }
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
        $className = $this->getComponentName(true) . ' ' .
            $this->getComponentName() . '-' . $this->getId();
        return $className;
    }

    /**
     * 設定可能なattributeの選択肢を取得します。
     */
    abstract public static function getAttributes();

    /**
     * attributeの初期値を取得します。
     */
    public static function getDefaultAttributes()
    {
        $attributes = static::getAttributes();
        $default = [];
        foreach($attributes as $name => $settings) {
            $default[$name] = $settings['values'][0] ?? '';
        }
        return $default;
    }

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
            $css .= $scss;
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
        // colors
        $colors = file_get_contents(dirname(__FILE__, 2) . '/scss/colors/default.scss');
        $from = mb_strpos($scss, '{') + 1;
        $to = mb_strpos($scss, '</') - $from;
        $scss = mb_substr($scss, $from, $to);
        $scss = '.' . $this->componentName . '-' . $this->version .' {' . $scss;
        $scss = $colors . "\n" . $scss;
        $scss = trim($scss);
        $filepath = 'work/tmp.scss';
        file_put_contents($filepath, $scss);
        $css = exec("sass -t compressed --scss " . $filepath);
        return $css;
    }
}