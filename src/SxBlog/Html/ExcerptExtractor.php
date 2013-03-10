<?php

namespace SxBlog\Html;

use \DOMDocument;
use \DOMText;

class ExcerptExtractor
{

    /**
     * @var \DOMDocument
     */
    protected $DOMDocument;

    /**
     * @param $markup
     */
    public function __construct($markup)
    {
        $this->DOMDocument = new DOMDocument;

        $this->DOMDocument->loadHTML($markup);
    }

    /**
     * Get the excerpt for constructed markup.
     *  Note: Text-only values will be wrapped in a paragraph tag.
     *
     * @param $length
     *
     * @return mixed
     */
    public function getExcerpt($length)
    {
        $elements = $this->DOMDocument->getElementsByTagName('body')->item(0);
        $trimmed  = $this->trimMarkup($elements->childNodes, $length);

        return $trimmed['markup'];
    }

    /**
     * @param $elements
     * @param $length
     *
     * @return array
     */
    protected function trimMarkup($elements, $length)
    {
        $markup     = '';
        $textLength = 0;

        foreach ($elements as $element) {
            if ($element instanceof DOMText) {
                $textLength += strlen($element->nodeValue);
                $element->nodeValue = substr($element->nodeValue, 0, ($length - $textLength));
                if ($textLength >= ($length - 30)) {
                    $element->nodeValue .= '...';
                }
                $markup .= $this->DOMDocument->saveHTML($element);
            } elseif ($element->firstChild instanceof DOMText) {
                $textLength += strlen($element->firstChild->nodeValue);
                $element->firstChild->nodeValue = substr($element->firstChild->nodeValue, 0, ($length - $textLength));
                if ($textLength >= ($length - 30)) {
                    $element->firstChild->nodeValue .= '...';
                }
                $markup .= $this->DOMDocument->saveHTML($element);
            } else {
                $trimmed = $this->trimMarkup($element, $length - $textLength);
                if ($trimmed['finished']) {
                    return array(
                        'finished' => true,
                        'markup'   => $markup . $trimmed['markup'],
                    );
                }

                $markup .= $trimmed['markup'];
                $textLength += $trimmed['length'];
            }

            if ($textLength >= ($length - 30)) {
                return array(
                    'finished' => true,
                    'markup'   => $markup,
                    'length'   => $length,
                );
            }
        }

        return array(
            'finished' => false,
            'markup'   => $markup,
            'length'   => $length,
        );
    }
}
