<?php

namespace ellsif\ui_component;

/**
 * UIコンポーネント管理クラス
 */
class UiComponentManager
{
    private static $instance = null;

    // 登録されているコンポーネント
    protected $components = [];

    // ID発番用
    private $uniqId;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new UiComponentManager();
        }
        return self::$instance;
    }

    /**
     * 初期化します。
     */
    public function initialize($uiComponents = [])
    {
        $this->components = $uiComponents;
        $this->uniqId = $this->getMaxId($uiComponents);
        return $this;
    }

    /**
     * IDの最大値を取得します。
     */
    protected function getMaxId($uiComponents, $max = 0)
    {
        foreach($uiComponents as $uiComponent) {
            if ($uiComponent instanceof UiComponentBase) {
                $max = max($uiComponent->getId(), $max);
                $max = $this->getMaxId($uiComponent->getChildComponents(), $max);
            }
        }
        return $max;
    }

    /**
     * 次のIDを取得します。
     */
    public function nextId()
    {
        $this->uniqId++;
        return $this->uniqId;
    }

    /**
     * UIコンポーネントを追加します。
     */
    public function addUiComponent($uiComponent)
    {
        if (!$uiComponent->getId()) {
            $uiComponent->setId($this->nextId());
        }
        $this->components[] = $uiComponent;
    }

    /**
     * 結合されたCSSを出力します。
     */
    public function getCss()
    {

    }
}