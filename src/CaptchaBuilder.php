<?php

namespace Mix\Captcha;

use Mix\Core\Bean\AbstractObject;

/**
 * Class CaptchaBuilder
 * @package Mix\Captcha
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class CaptchaBuilder extends AbstractObject
{

    /**
     * 宽度
     * @var int
     */
    public $width = 100;

    /**
     * 高度
     * @var int
     */
    public $height = 40;

    /**
     * 字集合
     * @var string
     */
    public $wordSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * 字体文件
     * @var string
     */
    public $fontFile = '';

    /**
     * 字体大小
     * @var int
     */
    public $fontSize = 20;

    /**
     * 字数
     * @var int
     */
    public $wordNumber = 4;

    /**
     * 角度随机
     * @var array
     */
    public $angleRand = [-20, 20];

    /**
     * 字距
     * @var float
     */
    public $xSpacing = 0.8;

    /**
     * Y轴随机
     * @var array
     */
    public $yRand = [5, 15];

    /**
     * 文本
     * @var string
     */
    protected $_text;

    /**
     * 内容
     * @var string
     */
    protected $_content;

    /**
     * 构造
     * @return bool
     */
    public function build()
    {
        $canvas     = imagecreatetruecolor($this->width, $this->height);
        $background = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        $fontColor  = imagecolorallocate($canvas, 32, 64, 160);
        imagefill($canvas, 0, 0, $background);
        for ($i = 1; $i <= $this->wordNumber; $i++) {
            $word        = iconv_substr($this->wordSet, floor(mt_rand(0, mb_strlen($this->wordSet, 'utf-8') - 1)), 1, 'utf-8');
            $this->_text .= $word;
            imagettftext($canvas, $this->fontSize, mt_rand($this->angleRand[0], $this->angleRand[1]), $this->fontSize * ($this->xSpacing * $i), $this->fontSize + mt_rand($this->yRand[0], $this->yRand[1]), $fontColor, $this->fontFile, $word);
        }
        imagesavealpha($canvas, true);
        ob_start();
        imagepng($canvas);
        imagedestroy($canvas);
        $this->_content = ob_get_clean();
        return true;
    }

    /**
     * 获取文本
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * 获取内容
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

}
