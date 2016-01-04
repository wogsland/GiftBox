<?php
namespace GiveToken\Tests;

use GiveToken\HTML;

/**
 * This class tests the HTML class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/HTMLTest
 */
class HTMLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // instantiation check
        $result = new HTML();
        $this->assertEquals('GiveToken\HTML', get_class($result));
    }

    /**
     * Tests the to function.
     */
    public function testTo()
    {
        // check for static method
        $this->assertTrue(method_exists('GiveToken\HTML', 'to'));

        // empty string test
        $text = '';
        $expected = '';
        $this->assertEquals($expected, HTML::to($text));

        // carriage return & newline test
        $text = "This\rtext\nis\r\nborken.";
        $expected = '<p>This</p><p>text</p><p>is</p><p>borken.</p>';
        $this->assertEquals($expected, HTML::to($text));

        // bullets
        $bullet_list = "This is my list\n•Nachoes\n•number 2\n•pizza\nWasn't that great?";
        //echo "\n".$bullet_list."\n";
        $expected = "<p>This is my list</p>";
        $expected .= "<p><ul><li>Nachoes</li><li>number 2</li><li>pizza</li></ul></p>";
        $expected .= "<p>Wasn't that great?</p>";
        $this->assertEquals($expected, HTML::to($bullet_list));

        // multiple sections of bullets
    }

    /**
     * Tests the from function.
     */
    public function testFrom()
    {
        // check for static method
        $this->assertTrue(method_exists('GiveToken\HTML', 'from'));

        // empty string test
        $html = '';
        $expected = '';
        $this->assertEquals($expected, HTML::from($html));

        // carriage return & newline test
        $html = '<p>This</p><p>text</p><p>is</p><p>borken.</p>';
        $expected = "This\r\ntext\r\nis\r\nborken.";
        $this->assertEquals($expected, HTML::from($html));

        // bullets
        $html = "<p>This is my list</p>";
        $html .= "<p><ul><li>Nachoes</li><li>number 2</li><li>pizza</li></ul></p>";
        $html .= "<p>Wasn't that great?</p>";
        $expected = "This is my list\r\n•Nachoes\r\n•number 2\r\n•pizza\r\nWasn't that great?";
        $this->assertEquals($expected, HTML::from($html));
    }

    /**
     * Tests that the functions are inverses of eachother.
     * Sort of.
     * To certain equivalence classes of characters.
     */
    public function testConvolution()
    {
        // empty string test
        $text = '';
        $convolution1 = HTML::from(HTML::to($text));
        $this->assertEquals($text, $convolution1);
        $convolution2 = HTML::to(HTML::from($text));
        $this->assertEquals($text, $convolution2);

        // carriage return & newline test
        // (this inverse assumes the pair is always used)
        $text = "This\r\ntext\r\nis\r\nborken.";
        $convolution1 = HTML::from(HTML::to($text));
        $this->assertEquals($text, $convolution1);
        $html = '<p>This</p><p>text</p><p>is</p><p>borken.</p>';
        $convolution2 = HTML::to(HTML::from($html));
        $this->assertEquals($html, $convolution2);

        // carriage return & newline test
        // (this inverse assumes bullet is always '•')
        $expected = "This is my list\r\n•Nachoes\r\n•number 2\r\n•pizza\r\nWasn't that great?";
        $convolution1 = HTML::from(HTML::to($text));
        $this->assertEquals($text, $convolution1);
        $html = "<p>This is my list</p>";
        $html .= "<p><ul><li>Nachoes</li><li>number 2</li><li>pizza</li></ul></p>";
        $html .= "<p>Wasn't that great?</p>";
        $convolution2 = HTML::to(HTML::from($html));
        $this->assertEquals($html, $convolution2);
    }
}
