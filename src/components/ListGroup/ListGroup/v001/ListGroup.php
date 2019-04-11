<?php
namespace ellsif\ui_component\components\ListGroup\ListGroup\v001;

use ellsif\ui_component\UiComponentBase;

class ListGroup extends UiComponentBase
{
    /**
     * コンポーネントのラベル（表示名）を取得します。
     */
    public function getLabel()
    {
        return 'リスト';
    }

    public static function getAttributes()
	{
        return [
			'tag' => [
				'label' => 'タグ',
				'values' => [
					'a',
					'button',
					'input',
				]
			],
			'kind' => [
				'label' => 'ボタンタイプ',
				'values' => [
					'primary',	// とか？
				]
			],
            'type' => [
                'label' => 'タイプ',
                'values' => [
                    'button',
                    'submit',
					'reset',
                ]
            ],
			'size' => [
				'label' => 'サイズ',
				'values' => [
					'',
					'sm',
					'lg',
					'xs',
					'xl',
				]
			],
            'active' => [
                'label' => 'アクティブ',
                'values' => [
                    false,
                    true,
                ]
            ],
			'disabled' => [
				'label' => '無効',
				'values' => [
                    false,
					true,
				]
			],
        ];
	}

    /**
     * デフォルトのattributesを返します。
     */
    public static function getDefaultAttributes()
    {
        return [
			'tag' => 'a',
			'kind' => 'primary',
			'size' => '',
			'active' => false,
			'disabled' => false,
		];
    }

    /**
     * デフォルトのvaluesを返します。
     */
    public static function getDefaultValues()
    {
        return [
			'text' => 'ボタン',
		];
    }

    /**
     * コンポーネントのCSS(SCSS)を取得します。
     */
    public function css($type = '')
    {
        if ($type === '') {
            ?>
            <style type="text/scss">
                .Button {
					display: inline-block;
					font-weight: 400;
					text-align: center;
					vertical-align: middle;
					padding: 0.375rem 0.75rem;
					font-size: 1rem;
					line-height: 1.5;
					background-color: transparent;
					border: 1px solid transparent;
					border-radius: 0.25rem;
					color: #000;
					text-decoration: none;
					cursor: pointer;
					&.btn-primary {
						color: #fff;
						background-color: #007bff;
						border-color: #007bff;
					}
					&.btn-sm {
						font-size: 0.75rem;
					}
					&.btn-lg {
						font-size: 1.25rem;
					}
					&.btn-xs {
						font-size: 0.5rem;
					}
					&.btn-xl {
						font-size: 1.5rem;
					}
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
    	$classes = [$this->getClassName()];
        if ($this->attributes['kind']) {
            $classes[] = 'btn-' . $this->attributes['kind'];
        }
        if ($this->attributes['size']) {
            $classes[] = 'btn-' . $this->attributes['size'];
        }
    	if ($this->attributes['active']) {
            $classes[] = 'active';
		}
		$class = implode(' ', $classes);

		if ($this->attributes['tag'] == 'button') {
        ?>
			<button type="button" class="<?php echo $class ?>">
				<?php echo $this->values['text'] ?? '' ?>
			</button>
        <?php
        } elseif ($this->attributes['tag'] == 'input') {
		?>
			<input class="<?php echo $class ?>" type="button" value="<?php echo $this->values['text'] ?? '' ?>">
		<?php
        } else {
		?>
			<a href="#" class="<?php echo $class ?>">
				ボタン
			</a>
		<?php
		}
    }
}