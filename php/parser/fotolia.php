<?php

/**
 * Fotolia parser
 *
 * @package parser
 * @author Labs64 <info@labs64.com>
 **/
class Fotolia extends Parser
{

    const COPYRIGHT = '&copy; %author% - Fotolia.com';

    const BASE_URL = 'http://www.fotolia.com/id/';

    function __construct()
    {
        parent::__construct();
    }

    protected function parse($number)
    {
        $item = parent::parse($number);
        $item['source'] = 'Fotolia';
        $item['publisher'] = 'Fotolia';
        $item['license'] = 'Royalty-free';

        $url = self::BASE_URL . $number;
        $doc = new DOMDocument();
        $html = @$doc->loadHTMLFile($url);
        if ($html) {
            $xpath = new DOMXPath($doc);

            $tags = $xpath->query("*/meta[@property='og:author']");
            if (!is_null($tags) && $tags->length > 0) {
                $item['author'] = $tags->item(0)->getAttribute('content');
            }
        }

        return $item;
    }

}
