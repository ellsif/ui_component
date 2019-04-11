<?php
namespace ellsif\ui_component\components\Button\Button\v001;

use ellsif\ui_component\UiComponentBase;

class Button extends UiComponentBase
{
    /**
     * コンポーネントのラベル（表示名）を取得します。
     */
    public function getLabel()
    {
        return 'ボタン';
    }

    public static function getAttributes()
	{
        return [
			'title' => [
				'label' => 'タイトル',
				'values' => [
					'ボタン'
				]
			],
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
					'primary',
                    'success',
					'info',
					'warning',
					'danger',
					'light',
					'dark',
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
					color: $black;
					text-decoration: none;
					cursor: pointer;
					&.btn-primary {
						color: $primaryTextColor;
						background-color: $primaryBgColor;
						border-color: $primaryBgColor;
					}
					@each $btn-type, $btn-color in $theme-colors {
						&.btn-#{$btn-type} {
							color: $primaryTextColor;
							background-color: $btn-color;
							border-color: $btn-color;
						}
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
				<?php echo $this->attributes['title'] ?? '' ?>
			</button>
        <?php
        } elseif ($this->attributes['tag'] == 'input') {
		?>
			<input class="<?php echo $class ?>" type="button" value="<?php echo $this->attributes['title'] ?? '' ?>">
		<?php
        } else {
		?>
			<a href="#" class="<?php echo $class ?>">
                <?php echo $this->attributes['title'] ?? '' ?>
			</a>
		<?php
		}
    }
}