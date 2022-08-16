<?php

declare(strict_types=1);

namespace MAKS\PhpHtml\Tests;

use MAKS\PhpHtml\HTML;
use MAKS\PhpHtml\TestCase;

class HTMLTest extends TestCase
{
    private HTML $html;


    public function setUp(): void
    {
        parent::setUp();

        $this->html = new HTML(strict: true);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->html);
    }


    public function testHTMLClassHTMLOutputViaEchoMethod()
    {
        $this->expectOutputString(
            "<!DOCTYPE html>\n" .
            "<head>\n" .
            "    <title>Test Document</title>\n" .
            "</head>\n" .
            "<body>\n" .
            "    <!-- Main Page Content -->\n" .
            "    <h1 style=\"text-align: center;\">Test</h1>\n" .
            "    <div class=\"container\" style=\"max-width: 80%;\">\n" .
            "        <h2>This is a test!</h2>\n" .
            "        <p>This is only for test purposes ...</p>\n" .
            "        <hr />\n" .
            "        &copy;\n" .
            "        <span> 2021</span>\n" .
            "    </div>\n" .
            "</body>"
        );

        echo $this->html
            ->node('<!DOCTYPE html>')
            ->open('head')
                ->title('Test Document')
            ->close()
            ->open('body')
                ->comment('Main Page Content')
                ->element('h1', 'Test', ['style' => 'text-align: center;'])
                ->open('div', ['class' => 'container', 'style' => 'max-width: 80%;'])
                    ->h2('This is a test!')
                    ->p('This is only for test purposes ...')
                    ->hr()
                    ->entity('copy')
                    ->span(' 2021')
                ->close()
            ->close()
        ->render();
    }

    public function testHTMLConditionMethod()
    {
        $html1 = $this->html
            ->open('div')
                ->p('This should be rendered. [ID: 1]')
                ->condition(true)
                ->open('div')
                    ->p('This should be rendered. [ID: 2]')
                    ->condition(false)
                    ->p('This should NOT be rendered. [ID: 1]')
                ->close()
            ->close()
        ->render();

        $this->assertStringContainsString('This should be rendered. [ID: 1]', $html1);
        $this->assertStringContainsString('This should be rendered. [ID: 2]', $html1);
        $this->assertStringNotContainsString('This should NOT be rendered. [ID: 1]', $html1);

        $html2 = $this->html
            ->if(true)
            ->open('div')
                ->p('This should be rendered. [ID: 1]')
                ->if(false)
                ->open('div')
                    ->p('This should NOT be rendered. [ID: 1]')
                    ->if(true)
                    ->p('This should NOT be rendered. [ID: 2]')
                ->close()
            ->close()
        ->render();

        $this->assertStringContainsString('This should be rendered. [ID: 1]', $html2);
        $this->assertStringNotContainsString('This should NOT be rendered. [ID: 1]', $html2);
        $this->assertStringNotContainsString('This should NOT be rendered. [ID: 2]', $html2);
    }

    public function testHTMLExecuteMethod()
    {
        $list = ['One [I]', 'Two [II]', 'Three [III]'];

        $html = (new HTML(strict: true))
            ->open('div')
                ->h4('This is a list:')
                ->open('ol')
                    ->function(function ($html) use ($list) {
                        // $this === $html
                        $index = 0;
                        foreach($list as $item) {
                            $html->li($item, ['data-index' => $index]);
                            $index++;
                        }
                    })
                ->close()
            ->close()
        ->render();

        $this->assertStringContainsString('One [I]', $html);
        $this->assertStringContainsString('Two [II]', $html);
        $this->assertStringContainsString('Three [III]', $html);

        $html = (new HTML(strict: true))
            ->open('div')
                ->h4('This is an empty list:')
                ->open('ol')
                    ->do(static fn ($html) => $html->comment('NOTHING')) // cover unboundable closure
                ->close()
            ->close()
        ->render();

        $this->assertStringNotContainsString('One [I]', $html);
        $this->assertStringNotContainsString('Two [II]', $html);
        $this->assertStringNotContainsString('Three [III]', $html);

        $html = (new HTML(strict: true, indent: false))
            ->open('div')
                ->h4('This is an empty list:')
                ->open('ol')
                    ->do('is_object') // cover creating a closure
                ->close()
            ->close()
        ->render();
    }

    public function testHTMLTagsMagicMethodsWithDifferentWaysOfWritingAttributes()
    {
        $html = '<input type="text" readonly disabled />';

        $this->assertEquals($html, HTML::input(['type' => 'text', 'title' => false, 'readonly' => null, 'disabled']));
    }

    public function testHTMLTagsMagicMethodsThrowExceptionForUnknownHTMLTags()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Call to undefined method');

        HTML::unknown();
    }

    public function testHTMLCloseMethodFailsWhenCalledWithoutOpeningTag()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/(Not in a context to close a tag)/');

        echo $this->html
            ->open('section')
                ->h1('This will fail')
            ->close()
            ->close()
        ->render();
    }

    public function testHTMLReturnMethodFailsWhenThereIsAnUnclosedHTMLTags()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/(Cannot return HTML in)/');

        echo $this->html
            ->open('section')
                ->h1('This will fail')
            // ->close()
        ->render();
    }

    public function testHTMLValidateMethodFailsOnInvalidHTML()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/(HTML is invalid in)/');

        echo $this->html
            ->node('<img src="https://fakeimg.pl/1000x1000/151515/ffffff/?text=HTML"></img>')
        ->render();
    }

    public function testHTMLMinifyMethodMinifiesHTMLStrings()
    {
        $badHtml  = '<div ><     label>   Text:</label>   <input   type="text"         disabled   /> </div ' . PHP_EOL . '>';
        $goodHtml = '<div><label> Text:</label> <input type="text" disabled /> </div>';

        $this->assertEquals($goodHtml, HTML::minify($badHtml));
    }
}
