<?php
namespace GiveToken;

/**
 * This class is for parsing strings into and out of HTML
 */
class HTML
{
    /**
     * Converts plain text to HTML
     *
     * @param string $text - plain text to format in HTML
     *
     * @return string - HTML
     */
    public static function to($text)
    {
        if ('' == $text) {
            $html = $text;
        } else {
            $html = '<p>';

            // simplify carriage returns to newlines
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\r", "\n", $text);

            // bulleted lists
            if (strpos($text, "\n•") !== false) {
              // regularize bullets

              // replace bullets
              $pos = strpos($text, "\n•");
              $text = substr_replace($text, '</p><p><ul><li>', $pos, strlen("\n•"));
              $text = str_replace("\n•", '</li><li>', $text);
              $pos = strrpos($text, '<li>');
              $backend = substr($text, $pos);
              $pos = strpos($backend, "\n");
              $pos = $pos + strlen($text) - strlen($backend);
              $text = substr_replace($text, '</li></ul></p><p>', $pos, strlen("\n"));
            }

            // spacing between paragraphs
            $text = str_replace("\n", '</p><p>', $text);

            // clean up empty paragraphs
            $text = str_replace('<p></p>', '', $text);

            $html .= $text;
            $html .= '</p>';
        }
        return $html;
    }

    /**
     * Converts well-formed (not broken) HTML to plain text
     *
     * @param string $html - HTML to format in plain text
     *
     * @return string - plain text
     */
    public static function from($html)
    {
        $text = '';
        if ('' != $html) {
            // bullets
            $html = str_replace('</p><p><ul><li>', "\r\n•", $html);
            $html = str_replace('</li><li>', "\r\n•", $html);
            $html = str_replace('</li></ul></p><p>', "\r\n", $html);

            // spacing between paragraphs
            $html = str_replace('</p><p>', "\r\n", $html);
            $html = str_replace('<p>', '', $html);
            $html = str_replace('</p>', '', $html);
            $text .= $html;
        }
        return $text;
    }
}
