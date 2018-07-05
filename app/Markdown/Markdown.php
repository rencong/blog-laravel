<?php
/**
 * Created by PhpStorm.
 * User: xiaoxiaocong
 * Date: 2018/6/27
 * Time: 下午7:06
 */

namespace App\Markdown;


class Markdown
{
    protected $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function markdown($content)
    {
        $html = $this->parser->makeHtml($content);
        return $html;
    }
}