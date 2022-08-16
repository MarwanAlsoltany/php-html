<?php

/**
 * @author Marwan Al-Soltany <MarwanAlsoltany@gmail.com>
 * @copyright Marwan Al-Soltany 2022
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MAKS\PhpHtml;

use DOMDocument;
use Closure;
use Exception;
use BadMethodCallException;

/**
 * A class that serves as a fluent interface to write HTML in PHP. It also helps with creating HTML elements on the fly.
 *
 * Example:
 * ```
 * // return an HTML element by using some tag name as a static method
 * // "div" can be replaced by any other valid HTML element tag name
 * $html = HTML::div('This is a div!', ['class' => 'container']);
 *
 * // create elements using "->element()" or "->{$tagName}()"
 * // create entities using "->entity()"
 * // create comments using "->comment()"
 * // structure deeply nested elements using "->open()" and "->close()" (wrapping methods)
 * // make the next action conditional using "->condition()" or "->if()"
 * // execute some logic (loops, complex if-statements) while creating the HTML using "->function()" or "->do()"
 * // retrieve the final generated HTML by using "->render()"
 * (new HTML())
 *     ->element('h1', 'HTML Forms', ['class' => 'title'])
 *     ->open('form', ['method' => 'POST'])
 *         ->h2('Example', ['class' => 'subtitle'])
 *         ->p('This is an example form.')
 *         ->br(null)
 *         ->if($someVar === true)->div('$someVar is true')
 *         ->open('fieldset')
 *             ->legend('Form 1', ['style' => 'color: #333;'])
 *             ->label('Message: ', ['class' => 'text'])
 *             ->input(null, ['type' => 'text', 'required'])
 *             ->entity('nbsp', 2)
 *             ->input(null, ['type' => 'submit', 'value' => 'Submit'])
 *         ->close()
 *         ->condition(count($errors))
 *         ->open('ul', ['class' => 'errors'])
 *             ->do(function () use ($errors) {
 *                 foreach ($errors as $error) {
 *                     $this->li($error);
 *                 }
 *             })
 *         ->close()
 *     ->close()
 * ->render();
 * ```
 *
 * @package MAKS\PhpHtml
 * @api
 *
 * @method static a(mixed $content = '', array $attributes = []) Defines a hyperlink.
 * @method static string a(mixed $content = '', array $attributes = []) Defines a hyperlink.
 * @method static abbr(mixed $content = '', array $attributes = []) Defines an abbreviation or an acronym.
 * @method static string abbr(mixed $content = '', array $attributes = []) Defines an abbreviation or an acronym.
 * @method static acronym(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;abbr> instead. Defines an acronym.
 * @method static string acronym(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;abbr&gt; instead. Defines an acronym.
 * @method static address(mixed $content = '', array $attributes = []) Defines contact information for the author/owner of a document.
 * @method static string address(mixed $content = '', array $attributes = []) Defines contact information for the author/owner of a document.
 * @method static applet(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;embed&gt; or &lt;object&gt; instead. Defines an embedded applet.
 * @method static string applet(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;embed&gt; or &lt;object&gt; instead. Defines an embedded applet.
 * @method static area(array $attributes = []) Defines an area inside an image map.
 * @method static string area(array $attributes = []) Defines an area inside an image map.
 * @method static article(mixed $content = '', array $attributes = []) Defines an article.
 * @method static string article(mixed $content = '', array $attributes = []) Defines an article.
 * @method static aside(mixed $content = '', array $attributes = []) Defines content aside from the page content.
 * @method static string aside(mixed $content = '', array $attributes = []) Defines content aside from the page content.
 * @method static audio(mixed $content = '', array $attributes = []) Defines embedded sound content.
 * @method static string audio(mixed $content = '', array $attributes = []) Defines embedded sound content.
 * @method static b(mixed $content = '', array $attributes = []) Defines bold text.
 * @method static string b(mixed $content = '', array $attributes = []) Defines bold text.
 * @method static base(array $attributes = []) Specifies the base URL/target for all relative URLs in a document.
 * @method static string base(array $attributes = []) Specifies the base URL/target for all relative URLs in a document.
 * @method static basefont(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Specifies a default color, size, and font for all text in a document.
 * @method static string basefont(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Specifies a default color, size, and font for all text in a document.
 * @method static bdi(mixed $content = '', array $attributes = []) Isolates a part of text that might be formatted in a different direction from other text outside it.
 * @method static string bdi(mixed $content = '', array $attributes = []) Isolates a part of text that might be formatted in a different direction from other text outside it.
 * @method static bdo(mixed $content = '', array $attributes = []) Overrides the current text direction.
 * @method static string bdo(mixed $content = '', array $attributes = []) Overrides the current text direction.
 * @method static big(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines big text.
 * @method static string big(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines big text.
 * @method static blockquote(mixed $content = '', array $attributes = []) Defines a section that is quoted from another source.
 * @method static string blockquote(mixed $content = '', array $attributes = []) Defines a section that is quoted from another source.
 * @method static body(mixed $content = '', array $attributes = []) Defines the document's body.
 * @method static string body(mixed $content = '', array $attributes = []) Defines the document's body.
 * @method static br(array $attributes = []) Defines a single line break.
 * @method static string br(array $attributes = []) Defines a single line break.
 * @method static button(mixed $content = '', array $attributes = []) Defines a clickable button.
 * @method static string button(mixed $content = '', array $attributes = []) Defines a clickable button.
 * @method static canvas(mixed $content = '', array $attributes = []) Used to draw graphics, on the fly, via scripting &#40;usually JavaScript&#41;.
 * @method static string canvas(mixed $content = '', array $attributes = []) Used to draw graphics, on the fly, via scripting &#40;usually JavaScript&#41;.
 * @method static caption(mixed $content = '', array $attributes = []) Defines a table caption.
 * @method static string caption(mixed $content = '', array $attributes = []) Defines a table caption.
 * @method static center(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines centered text.
 * @method static string center(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines centered text.
 * @method static cite(mixed $content = '', array $attributes = []) Defines the title of a work.
 * @method static string cite(mixed $content = '', array $attributes = []) Defines the title of a work.
 * @method static code(mixed $content = '', array $attributes = []) Defines a piece of computer code.
 * @method static string code(mixed $content = '', array $attributes = []) Defines a piece of computer code.
 * @method static col(array $attributes = []) Specifies column properties for each column within a &lt;colgroup&gt; element.
 * @method static string col(array $attributes = []) Specifies column properties for each column within a &lt;colgroup&gt; element.
 * @method static colgroup(mixed $content = '', array $attributes = []) Specifies a group of one or more columns in a table for formatting.
 * @method static string colgroup(mixed $content = '', array $attributes = []) Specifies a group of one or more columns in a table for formatting.
 * @method static data(mixed $content = '', array $attributes = []) Adds a machine-readable translation of a given content.
 * @method static string data(mixed $content = '', array $attributes = []) Adds a machine-readable translation of a given content.
 * @method static datalist(mixed $content = '', array $attributes = []) Specifies a list of pre-defined options for input controls.
 * @method static string datalist(mixed $content = '', array $attributes = []) Specifies a list of pre-defined options for input controls.
 * @method static dd(mixed $content = '', array $attributes = []) Defines a description/value of a term in a description list.
 * @method static string dd(mixed $content = '', array $attributes = []) Defines a description/value of a term in a description list.
 * @method static del(mixed $content = '', array $attributes = []) Defines text that has been deleted from a document.
 * @method static string del(mixed $content = '', array $attributes = []) Defines text that has been deleted from a document.
 * @method static details(mixed $content = '', array $attributes = []) Defines additional details that the user can view or hide.
 * @method static string details(mixed $content = '', array $attributes = []) Defines additional details that the user can view or hide.
 * @method static dfn(mixed $content = '', array $attributes = []) Specifies a term that is going to be defined within the content.
 * @method static string dfn(mixed $content = '', array $attributes = []) Specifies a term that is going to be defined within the content.
 * @method static dialog(mixed $content = '', array $attributes = []) Defines a dialog box or window.
 * @method static string dialog(mixed $content = '', array $attributes = []) Defines a dialog box or window.
 * @method static dir(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;ul&gt; instead. Defines a directory list.
 * @method static string dir(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;ul&gt; instead. Defines a directory list.
 * @method static div(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static string div(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static dl(mixed $content = '', array $attributes = []) Defines a description list.
 * @method static string dl(mixed $content = '', array $attributes = []) Defines a description list.
 * @method static dt(mixed $content = '', array $attributes = []) Defines a term/name in a description list.
 * @method static string dt(mixed $content = '', array $attributes = []) Defines a term/name in a description list.
 * @method static em(mixed $content = '', array $attributes = []) Defines emphasized text.
 * @method static string em(mixed $content = '', array $attributes = []) Defines emphasized text.
 * @method static embed(array $attributes = []) Defines a container for an external application.
 * @method static string embed(array $attributes = []) Defines a container for an external application.
 * @method static fieldset(mixed $content = '', array $attributes = []) Groups related elements in a form.
 * @method static string fieldset(mixed $content = '', array $attributes = []) Groups related elements in a form.
 * @method static figcaption(mixed $content = '', array $attributes = []) Defines a caption for a &lt;figure&gt; element.
 * @method static string figcaption(mixed $content = '', array $attributes = []) Defines a caption for a &lt;figure&gt; element.
 * @method static figure(mixed $content = '', array $attributes = []) Specifies self-contained content.
 * @method static string figure(mixed $content = '', array $attributes = []) Specifies self-contained content.
 * @method static font(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines font, color, and size for text.
 * @method static string font(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines font, color, and size for text.
 * @method static footer(mixed $content = '', array $attributes = []) Defines a footer for a document or section.
 * @method static string footer(mixed $content = '', array $attributes = []) Defines a footer for a document or section.
 * @method static form(mixed $content = '', array $attributes = []) Defines an HTML form for user input.
 * @method static string form(mixed $content = '', array $attributes = []) Defines an HTML form for user input.
 * @method static frame(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines a window &#40;a frame&#41; in a frameset.
 * @method static string frame(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines a window &#40;a frame&#41; in a frameset.
 * @method static frameset(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines a set of frames.
 * @method static string frameset(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines a set of frames.
 * @method static h1(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h1(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static h2(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h2(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static h3(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h3(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static h4(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h4(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static h5(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h5(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static h6(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static string h6(mixed $content = '', array $attributes = []) Defines HTML heading.
 * @method static head(mixed $content = '', array $attributes = []) Contains metadata/information for the document.
 * @method static string head(mixed $content = '', array $attributes = []) Contains metadata/information for the document.
 * @method static header(mixed $content = '', array $attributes = []) Defines a header for a document or section.
 * @method static string header(mixed $content = '', array $attributes = []) Defines a header for a document or section.
 * @method static hr(array $attributes = []) Defines a thematic change in the content.
 * @method static string hr(array $attributes = []) Defines a thematic change in the content.
 * @method static html(mixed $content = '', array $attributes = []) Defines the root of an HTML document.
 * @method static string html(mixed $content = '', array $attributes = []) Defines the root of an HTML document.
 * @method static i(mixed $content = '', array $attributes = []) Defines a part of text in an alternate voice or mood.
 * @method static string i(mixed $content = '', array $attributes = []) Defines a part of text in an alternate voice or mood.
 * @method static iframe(mixed $content = '', array $attributes = []) Defines an inline frame.
 * @method static string iframe(mixed $content = '', array $attributes = []) Defines an inline frame.
 * @method static img(array $attributes = []) Defines an image.
 * @method static string img(array $attributes = []) Defines an image.
 * @method static input(array $attributes = []) Defines an input control.
 * @method static string input(array $attributes = []) Defines an input control.
 * @method static ins(mixed $content = '', array $attributes = []) Defines a text that has been inserted into a document.
 * @method static string ins(mixed $content = '', array $attributes = []) Defines a text that has been inserted into a document.
 * @method static kbd(mixed $content = '', array $attributes = []) Defines keyboard input.
 * @method static string kbd(mixed $content = '', array $attributes = []) Defines keyboard input.
 * @method static label(mixed $content = '', array $attributes = []) Defines a label for an &lt;input&gt; element.
 * @method static string label(mixed $content = '', array $attributes = []) Defines a label for an &lt;input&gt; element.
 * @method static legend(mixed $content = '', array $attributes = []) Defines a caption for a &lt;fieldset&gt; element.
 * @method static string legend(mixed $content = '', array $attributes = []) Defines a caption for a &lt;fieldset&gt; element.
 * @method static li(mixed $content = '', array $attributes = []) Defines a list item.
 * @method static string li(mixed $content = '', array $attributes = []) Defines a list item.
 * @method static link(array $attributes = []) Defines the relationship between a document and an external resource &#40;most used to link to style sheets&#41;.
 * @method static string link(array $attributes = []) Defines the relationship between a document and an external resource &#40;most used to link to style sheets&#41;.
 * @method static main(mixed $content = '', array $attributes = []) Specifies the main content of a document.
 * @method static string main(mixed $content = '', array $attributes = []) Specifies the main content of a document.
 * @method static map(mixed $content = '', array $attributes = []) Defines an image map.
 * @method static string map(mixed $content = '', array $attributes = []) Defines an image map.
 * @method static mark(mixed $content = '', array $attributes = []) Defines marked/highlighted text.
 * @method static string mark(mixed $content = '', array $attributes = []) Defines marked/highlighted text.
 * @method static meta(array $attributes = []) Defines metadata about an HTML document.
 * @method static string meta(array $attributes = []) Defines metadata about an HTML document.
 * @method static meter(mixed $content = '', array $attributes = []) Defines a scalar measurement within a known range &#40;a gauge&#41;.
 * @method static string meter(mixed $content = '', array $attributes = []) Defines a scalar measurement within a known range &#40;a gauge&#41;.
 * @method static nav(mixed $content = '', array $attributes = []) Defines navigation links.
 * @method static string nav(mixed $content = '', array $attributes = []) Defines navigation links.
 * @method static noframes(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines an alternate content for users that do not support frames.
 * @method static string noframes(mixed $content = '', array $attributes = []) Not supported in HTML5. Defines an alternate content for users that do not support frames.
 * @method static noscript(mixed $content = '', array $attributes = []) Defines an alternate content for users that do not support client-side scripts.
 * @method static string noscript(mixed $content = '', array $attributes = []) Defines an alternate content for users that do not support client-side scripts.
 * @method static object(mixed $content = '', array $attributes = []) Defines a container for an external application.
 * @method static string object(mixed $content = '', array $attributes = []) Defines a container for an external application.
 * @method static ol(mixed $content = '', array $attributes = []) Defines an ordered list.
 * @method static string ol(mixed $content = '', array $attributes = []) Defines an ordered list.
 * @method static optgroup(mixed $content = '', array $attributes = []) Defines a group of related options in a drop-down list.
 * @method static string optgroup(mixed $content = '', array $attributes = []) Defines a group of related options in a drop-down list.
 * @method static option(mixed $content = '', array $attributes = []) Defines an option in a drop-down list.
 * @method static string option(mixed $content = '', array $attributes = []) Defines an option in a drop-down list.
 * @method static output(mixed $content = '', array $attributes = []) Defines the result of a calculation.
 * @method static string output(mixed $content = '', array $attributes = []) Defines the result of a calculation.
 * @method static p(mixed $content = '', array $attributes = []) Defines a paragraph.
 * @method static string p(mixed $content = '', array $attributes = []) Defines a paragraph.
 * @method static param(array $attributes = []) Defines a parameter for an object.
 * @method static string param(array $attributes = []) Defines a parameter for an object.
 * @method static picture(mixed $content = '', array $attributes = []) Defines a container for multiple image resources.
 * @method static string picture(mixed $content = '', array $attributes = []) Defines a container for multiple image resources.
 * @method static pre(mixed $content = '', array $attributes = []) Defines preformatted text.
 * @method static string pre(mixed $content = '', array $attributes = []) Defines preformatted text.
 * @method static progress(mixed $content = '', array $attributes = []) Represents the progress of a task.
 * @method static string progress(mixed $content = '', array $attributes = []) Represents the progress of a task.
 * @method static q(mixed $content = '', array $attributes = []) Defines a short quotation.
 * @method static string q(mixed $content = '', array $attributes = []) Defines a short quotation.
 * @method static rp(mixed $content = '', array $attributes = []) Defines what to show in browsers that do not support ruby annotations.
 * @method static string rp(mixed $content = '', array $attributes = []) Defines what to show in browsers that do not support ruby annotations.
 * @method static rt(mixed $content = '', array $attributes = []) Defines an explanation/pronunciation of characters &#40;for East Asian typography&#41;.
 * @method static string rt(mixed $content = '', array $attributes = []) Defines an explanation/pronunciation of characters &#40;for East Asian typography&#41;.
 * @method static ruby(mixed $content = '', array $attributes = []) Defines a ruby annotation &#40;for East Asian typography&#41;.
 * @method static string ruby(mixed $content = '', array $attributes = []) Defines a ruby annotation &#40;for East Asian typography&#41;.
 * @method static s(mixed $content = '', array $attributes = []) Defines text that is no longer correct.
 * @method static string s(mixed $content = '', array $attributes = []) Defines text that is no longer correct.
 * @method static samp(mixed $content = '', array $attributes = []) Defines sample output from a computer program.
 * @method static string samp(mixed $content = '', array $attributes = []) Defines sample output from a computer program.
 * @method static script(mixed $content = '', array $attributes = []) Defines a client-side script.
 * @method static string script(mixed $content = '', array $attributes = []) Defines a client-side script.
 * @method static section(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static string section(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static select(mixed $content = '', array $attributes = []) Defines a drop-down list.
 * @method static string select(mixed $content = '', array $attributes = []) Defines a drop-down list.
 * @method static small(mixed $content = '', array $attributes = []) Defines smaller text.
 * @method static string small(mixed $content = '', array $attributes = []) Defines smaller text.
 * @method static source(array $attributes = []) Defines multiple media resources for media elements &#40;&lt;video&gt; and &lt;audio&gt;&#41;.
 * @method static string source(array $attributes = []) Defines multiple media resources for media elements &#40;&lt;video&gt; and &lt;audio&gt;&#41;.
 * @method static span(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static string span(mixed $content = '', array $attributes = []) Defines a section in a document.
 * @method static strike(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;del&gt; or &lt;s&gt; instead. Defines strikethrough text.
 * @method static string strike(mixed $content = '', array $attributes = []) Not supported in HTML5. Use &lt;del&gt; or &lt;s&gt; instead. Defines strikethrough text.
 * @method static strong(mixed $content = '', array $attributes = []) Defines important text.
 * @method static string strong(mixed $content = '', array $attributes = []) Defines important text.
 * @method static style(mixed $content = '', array $attributes = []) Defines style information for a document.
 * @method static string style(mixed $content = '', array $attributes = []) Defines style information for a document.
 * @method static sub(mixed $content = '', array $attributes = []) Defines subscripted text.
 * @method static string sub(mixed $content = '', array $attributes = []) Defines subscripted text.
 * @method static summary(mixed $content = '', array $attributes = []) Defines a visible heading for a &lt;details&gt; element.
 * @method static string summary(mixed $content = '', array $attributes = []) Defines a visible heading for a &lt;details&gt; element.
 * @method static sup(mixed $content = '', array $attributes = []) Defines superscripted text.
 * @method static string sup(mixed $content = '', array $attributes = []) Defines superscripted text.
 * @method static svg(mixed $content = '', array $attributes = []) Defines a container for SVG graphics.
 * @method static string svg(mixed $content = '', array $attributes = []) Defines a container for SVG graphics.
 * @method static table(mixed $content = '', array $attributes = []) Defines a table.
 * @method static string table(mixed $content = '', array $attributes = []) Defines a table.
 * @method static tbody(mixed $content = '', array $attributes = []) Groups the body content in a table.
 * @method static string tbody(mixed $content = '', array $attributes = []) Groups the body content in a table.
 * @method static td(mixed $content = '', array $attributes = []) Defines a cell in a table.
 * @method static string td(mixed $content = '', array $attributes = []) Defines a cell in a table.
 * @method static template(mixed $content = '', array $attributes = []) Defines a container for content that should be hidden when the page loads.
 * @method static string template(mixed $content = '', array $attributes = []) Defines a container for content that should be hidden when the page loads.
 * @method static textarea(mixed $content = '', array $attributes = []) Defines a multiline input control &#40;text area&#41;.
 * @method static string textarea(mixed $content = '', array $attributes = []) Defines a multiline input control &#40;text area&#41;.
 * @method static tfoot(mixed $content = '', array $attributes = []) Groups the footer content in a table.
 * @method static string tfoot(mixed $content = '', array $attributes = []) Groups the footer content in a table.
 * @method static th(mixed $content = '', array $attributes = []) Defines a header cell in a table.
 * @method static string th(mixed $content = '', array $attributes = []) Defines a header cell in a table.
 * @method static thead(mixed $content = '', array $attributes = []) Groups the header content in a table.
 * @method static string thead(mixed $content = '', array $attributes = []) Groups the header content in a table.
 * @method static time(mixed $content = '', array $attributes = []) Defines a specific time &#40;or datetime&#41;.
 * @method static string time(mixed $content = '', array $attributes = []) Defines a specific time &#40;or datetime&#41;.
 * @method static title(mixed $content = '', array $attributes = []) Defines a title for the document.
 * @method static string title(mixed $content = '', array $attributes = []) Defines a title for the document.
 * @method static tr(mixed $content = '', array $attributes = []) Defines a row in a table.
 * @method static string tr(mixed $content = '', array $attributes = []) Defines a row in a table.
 * @method static track(array $attributes = []) Defines text tracks for media elements &#40;&lt;video&gt; and &lt;audio&gt;&#41;.
 * @method static string track(array $attributes = []) Defines text tracks for media elements &#40;&lt;video&gt; and &lt;audio&gt;&#41;.
 * @method static tt(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines teletype text.
 * @method static string tt(mixed $content = '', array $attributes = []) Not supported in HTML5. Use CSS instead. Defines teletype text.
 * @method static u(mixed $content = '', array $attributes = []) Defines some text that is unarticulated and styled differently from normal text.
 * @method static string u(mixed $content = '', array $attributes = []) Defines some text that is unarticulated and styled differently from normal text.
 * @method static ul(mixed $content = '', array $attributes = []) Defines an unordered list.
 * @method static string ul(mixed $content = '', array $attributes = []) Defines an unordered list.
 * @method static var(mixed $content = '', array $attributes = []) Defines a variable.
 * @method static string var(mixed $content = '', array $attributes = []) Defines a variable.
 * @method static video(mixed $content = '', array $attributes = []) Defines embedded video content.
 * @method static string video(mixed $content = '', array $attributes = []) Defines embedded video content.
 * @method static wbr(array $attributes = []) Defines a possible line-break.
 * @method static string wbr(array $attributes = []) Defines a possible line-break.
 */
class HTML
{
    /**
     * HTML tags.
     *
     * @link https://www.w3schools.com/TAgs/default.asp HTML Element Reference
     *
     * @var array
     */
    public const TAGS = [
        'a'          => ['void' => false, 'deprecated' => false],
        'abbr'       => ['void' => false, 'deprecated' => false],
        'acronym'    => ['void' => false, 'deprecated' => true],
        'address'    => ['void' => false, 'deprecated' => false],
        'applet'     => ['void' => false, 'deprecated' => true],
        'area'       => ['void' => true, 'deprecated' => false],
        'article'    => ['void' => false, 'deprecated' => false],
        'aside'      => ['void' => false, 'deprecated' => false],
        'audio'      => ['void' => false, 'deprecated' => false],
        'b'          => ['void' => false, 'deprecated' => false],
        'base'       => ['void' => true, 'deprecated' => false],
        'basefont'   => ['void' => false, 'deprecated' => true],
        'bdi'        => ['void' => false, 'deprecated' => false],
        'bdo'        => ['void' => false, 'deprecated' => false],
        'big'        => ['void' => false, 'deprecated' => true],
        'blockquote' => ['void' => false, 'deprecated' => false],
        'body'       => ['void' => false, 'deprecated' => false],
        'br'         => ['void' => true, 'deprecated' => false],
        'button'     => ['void' => false, 'deprecated' => false],
        'canvas'     => ['void' => false, 'deprecated' => false],
        'caption'    => ['void' => false, 'deprecated' => false],
        'center'     => ['void' => false, 'deprecated' => true],
        'cite'       => ['void' => false, 'deprecated' => false],
        'code'       => ['void' => false, 'deprecated' => false],
        'col'        => ['void' => true, 'deprecated' => false],
        'colgroup'   => ['void' => false, 'deprecated' => false],
        'data'       => ['void' => false, 'deprecated' => false],
        'datalist'   => ['void' => false, 'deprecated' => false],
        'dd'         => ['void' => false, 'deprecated' => false],
        'del'        => ['void' => false, 'deprecated' => false],
        'details'    => ['void' => false, 'deprecated' => false],
        'dfn'        => ['void' => false, 'deprecated' => false],
        'dialog'     => ['void' => false, 'deprecated' => false],
        'dir'        => ['void' => false, 'deprecated' => true],
        'div'        => ['void' => false, 'deprecated' => false],
        'dl'         => ['void' => false, 'deprecated' => false],
        'dt'         => ['void' => false, 'deprecated' => false],
        'em'         => ['void' => false, 'deprecated' => false],
        'embed'      => ['void' => true, 'deprecated' => false],
        'fieldset'   => ['void' => false, 'deprecated' => false],
        'figcaption' => ['void' => false, 'deprecated' => false],
        'figure'     => ['void' => false, 'deprecated' => false],
        'font'       => ['void' => false, 'deprecated' => true],
        'footer'     => ['void' => false, 'deprecated' => false],
        'form'       => ['void' => false, 'deprecated' => false],
        'frame'      => ['void' => false, 'deprecated' => true],
        'frameset'   => ['void' => false, 'deprecated' => true],
        'h1'         => ['void' => false, 'deprecated' => false],
        'h2'         => ['void' => false, 'deprecated' => false],
        'h3'         => ['void' => false, 'deprecated' => false],
        'h4'         => ['void' => false, 'deprecated' => false],
        'h5'         => ['void' => false, 'deprecated' => false],
        'h6'         => ['void' => false, 'deprecated' => false],
        'head'       => ['void' => false, 'deprecated' => false],
        'header'     => ['void' => false, 'deprecated' => false],
        'hr'         => ['void' => true, 'deprecated' => false],
        'html'       => ['void' => false, 'deprecated' => false],
        'i'          => ['void' => false, 'deprecated' => false],
        'iframe'     => ['void' => false, 'deprecated' => false],
        'img'        => ['void' => true, 'deprecated' => false],
        'input'      => ['void' => true, 'deprecated' => false],
        'ins'        => ['void' => false, 'deprecated' => false],
        'kbd'        => ['void' => false, 'deprecated' => false],
        'label'      => ['void' => false, 'deprecated' => false],
        'legend'     => ['void' => false, 'deprecated' => false],
        'li'         => ['void' => false, 'deprecated' => false],
        'link'       => ['void' => true, 'deprecated' => false],
        'main'       => ['void' => false, 'deprecated' => false],
        'map'        => ['void' => false, 'deprecated' => false],
        'mark'       => ['void' => false, 'deprecated' => false],
        'meta'       => ['void' => true, 'deprecated' => false],
        'meter'      => ['void' => false, 'deprecated' => false],
        'nav'        => ['void' => false, 'deprecated' => false],
        'noframes'   => ['void' => false, 'deprecated' => true],
        'noscript'   => ['void' => false, 'deprecated' => false],
        'object'     => ['void' => false, 'deprecated' => false],
        'ol'         => ['void' => false, 'deprecated' => false],
        'optgroup'   => ['void' => false, 'deprecated' => false],
        'option'     => ['void' => false, 'deprecated' => false],
        'output'     => ['void' => false, 'deprecated' => false],
        'p'          => ['void' => false, 'deprecated' => false],
        'param'      => ['void' => true, 'deprecated' => false],
        'picture'    => ['void' => false, 'deprecated' => false],
        'pre'        => ['void' => false, 'deprecated' => false],
        'progress'   => ['void' => false, 'deprecated' => false],
        'q'          => ['void' => false, 'deprecated' => false],
        'rp'         => ['void' => false, 'deprecated' => false],
        'rt'         => ['void' => false, 'deprecated' => false],
        'ruby'       => ['void' => false, 'deprecated' => false],
        's'          => ['void' => false, 'deprecated' => false],
        'samp'       => ['void' => false, 'deprecated' => false],
        'script'     => ['void' => false, 'deprecated' => false],
        'section'    => ['void' => false, 'deprecated' => false],
        'select'     => ['void' => false, 'deprecated' => false],
        'small'      => ['void' => false, 'deprecated' => false],
        'source'     => ['void' => true, 'deprecated' => false],
        'span'       => ['void' => false, 'deprecated' => false],
        'strike'     => ['void' => false, 'deprecated' => true],
        'strong'     => ['void' => false, 'deprecated' => false],
        'style'      => ['void' => false, 'deprecated' => false],
        'sub'        => ['void' => false, 'deprecated' => false],
        'summary'    => ['void' => false, 'deprecated' => false],
        'sup'        => ['void' => false, 'deprecated' => false],
        'svg'        => ['void' => false, 'deprecated' => false],
        'table'      => ['void' => false, 'deprecated' => false],
        'tbody'      => ['void' => false, 'deprecated' => false],
        'td'         => ['void' => false, 'deprecated' => false],
        'template'   => ['void' => false, 'deprecated' => false],
        'textarea'   => ['void' => false, 'deprecated' => false],
        'tfoot'      => ['void' => false, 'deprecated' => false],
        'th'         => ['void' => false, 'deprecated' => false],
        'thead'      => ['void' => false, 'deprecated' => false],
        'time'       => ['void' => false, 'deprecated' => false],
        'title'      => ['void' => false, 'deprecated' => false],
        'tr'         => ['void' => false, 'deprecated' => false],
        'track'      => ['void' => true, 'deprecated' => false],
        'tt'         => ['void' => false, 'deprecated' => true],
        'u'          => ['void' => false, 'deprecated' => false],
        'ul'         => ['void' => false, 'deprecated' => false],
        'var'        => ['void' => false, 'deprecated' => false],
        'video'      => ['void' => false, 'deprecated' => false],
        'wbr'        => ['void' => true, 'deprecated' => false],
    ];

    /**
     * Normal tag.
     *
     * @var int
     */
    protected const TAG_NORMAL = 0;

    /**
     * Opening tag.
     *
     * @var int
     */
    protected const TAG_OPENING = self::TAG_NORMAL + 1;

    /**
     * Closing tag.
     *
     * @var int
     */
    protected const TAG_CLOSING = self::TAG_NORMAL - 1;


    /**
     * Conditions track.
     *
     * @var array
     */
    protected array $conditions = [];

    /**
     * Current buffer.
     *
     * @var array
     */
    protected array $buffer = [];

    /**
     * Current stack (nesting).
     *
     * @var array
     */
    protected array $stack = [];


    /**
     * HTML constructor.
     *
     * @param bool $strict Whether to validate the generated HTML upon return or not.
     * @param bool $indent Whether to indent the generated HTML or not.
     */
    public function __construct(
        private bool $strict = false,
        private bool $indent = true,
    ) {
        $this->conditions = [];
        $this->buffer     = [];
        $this->stack      = [];
    }

    /**
     * Returns the current HTML buffer.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Makes HTML tags available as methods on the class.
     *
     * @param string $name
     * @param array<mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (!isset(self::TAGS[$name = strtolower($name)])) {
            throw new BadMethodCallException(
                strtr('Call to undefined method {class}::{method}()', [
                    '{class}'  => static::class,
                    '{method}' => $name,
                ])
            );
        }

        $content    = null;
        $attributes = $arguments[0] ?? $arguments['attributes'] ?? [];

        if (self::TAGS[$name]['void'] === false) {
            $content    = $arguments[0] ?? $arguments['content'] ?? (count($arguments) ? null : '');
            $attributes = $arguments[1] ?? $arguments['attributes'] ?? [];
        }

        return $this->element($name, $content, $attributes);
    }

    /**
     * Makes HTML tags available as static methods on the class.
     *
     * @param string $name
     * @param array<mixed> $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        static $self = null;

        if ($self === null) {
            $self = new self();
        }

        return (string)($self->{$name}(...$arguments));
    }


    /**
     * Creates an arbitrary text-node from the specified text and pass it to the buffer (useful to add some special tags, "&lt;!DOCTYPE html&gt;" for example).
     *
     * @param string $text The text to add to the buffer.
     *
     * @return static
     *
     * @throws Exception If the supplied text is invalid.
     */
    public function node(string $text): static
    {
        $this->assert(
            !strlen($text = trim($text)),
            'Invalid text supplied to {class}::{function}() in {file} on line {line}. ' .
            'Node text cannot be an empty string'
        );

        if ($this->isConditionTruthy()) {
            $this->write($text);
        }

        return $this;
    }

    /**
     * Creates an HTML comment from the specified text and pass it to the buffer.
     *
     * @param string $text The text content of the HTML comment without `<!--` and `-->`.
     *
     * @return static
     *
     * @throws Exception If the supplied text is invalid.
     */
    public function comment(string $text): static
    {
        $this->assert(
            !strlen($text = trim($text)),
            'Invalid text supplied to {class}::{function}() in {file} on line {line}. ' .
            'Comment text cannot be an empty string'
        );

        if ($this->isConditionTruthy()) {
            $this->write(
                $this->interpolate('<!-- {text} -->', ['text' => $text])
            );
        }

        return $this;
    }

    /**
     * Creates an HTML entity from the specified name and pass it to the buffer.
     *
     * @param string $name The name of the HTML entity without `&` nor `;`.
     *
     * @return static
     *
     * @throws Exception If the supplied name is invalid.
     */
    public function entity(string $name): static
    {
        $this->assert(
            !strlen($name = trim($name)),
            'Invalid name supplied to {class}::{function}() in {file} on line {line}. ' .
            'Entity name cannot be an empty string'
        );

        if ($this->isConditionTruthy()) {
            $this->write(
                $this->interpolate('&{name};', ['name' => trim($name, '& ;')])
            );
        }


        return $this;
    }

    /**
     * Creates a complete HTML element (opening and closing tags) constructed from the specified parameters and pass it to the buffer.
     *
     * @param string $name The name of the HTML tag.
     * @param mixed $content [optional] The textual or HTML content of the element (preferably scalar),
     *      passing null will make the tag a self-closing tag, all other types will simply get stringified (arrays and objects as JSON).
     * @param array<int|string,null|string|bool> $attributes [optional] An associative array of attributes.
     *      To indicate a boolean-attribute (no-value-attribute), simply provide a key with value `null`
     *      or provide only a value as the name of the attribute without a key.
     *      As a shortcut, setting the value as `false` will exclude the attribute.
     *
     * @return static
     *
     * @throws Exception If the supplied name is invalid.
     */
    public function element(string $name, mixed $content = '', array $attributes = []): static
    {
        $this->assert(
            !strlen($name = trim($name)),
            'Invalid name supplied to {class}::{function}() in {file} on line {line}. ' .
            'Tag name cannot be an empty string'
        );

        if ($this->isConditionTruthy()) {
            $tag        = $content !== null ? '<{name}{attributes}>{content}</{name}>' : '<{name}{attributes} />';
            $name       = $this->normalizeTagName($name);
            $attributes = $this->stringifyAttributes($attributes);

            $this->write(
                $this->interpolate($tag, compact('name', 'content', 'attributes'))
            );
        }

        return $this;
    }

    /**
     * Creates an HTML opening tag from the specified parameters and pass it to the buffer. Works in conjunction with `self::close()`.
     *
     * @param string $name A name of an HTML tag.
     * @param array<int|string,string|bool> $attributes [optional] An associative array of attributes.
     *      To indicate a boolean-attribute (no-value-attribute), simply provide a key with value `null`.
     *      Setting the value as `false` will exclude the attribute.
     *
     * @return static
     *
     * @throws Exception If the supplied name is invalid.
     */
    public function open(string $name, array $attributes = []): static
    {
        $this->assert(
            !strlen($name = trim($name)),
            'Invalid name supplied to {class}::{function}() in {file} on line {line}. ' .
            'Tag name cannot be an empty string'
        );

        if ($this->isConditionTruthy(self::TAG_OPENING)) {
            $tag        = '<{name}{attributes}>';
            $name       = $this->normalizeTagName($name);
            $attributes = $this->stringifyAttributes($attributes);

            $this->write(
                $this->interpolate($tag, compact('name', 'attributes'))
            );

            array_push($this->stack, $name);
        }

        return $this;
    }

    /**
     * Creates an HTML closing tag matching the last tag opened by `self::open()`.
     *
     * @return static
     *
     * @throws Exception If no tag has been opened.
     */
    public function close(): static
    {
        $this->assert(
            !count($this->stack),
            'Not in a context to close a tag! ' .
            'Call to {class}::{function}() in {file} on line {line} is superfluous'
        );

        if ($this->isConditionTruthy(self::TAG_CLOSING)) {
            $tag  = '</{name}>';
            $name = array_pop($this->stack);

            $this->write(
                $this->interpolate($tag, compact('name'))
            );
        }

        return $this;
    }

    /**
     * Takes a condition (some boolean value) to determine whether or not to create the very next element and pass it to the buffer.
     *
     * @param mixed $condition Any value that can be casted to a boolean.
     *
     * @return static
     */
    public function condition(mixed $condition): static
    {
        $this->conditions[] = (bool)($condition);

        return $this;
    }

    /**
     * Takes a callback and executes it after binding $this (HTML) to it, useful for example to execute any PHP code while creating the markup.
     *
     * @param callable $callback The callback to call and bind $this to, this callback will also be passed the instance it was called on as the first parameter.
     *
     * @return static
     */
    public function function(callable $callback): static
    {
        if ($this->isConditionTruthy()) {
            try {
                $callback = $callback instanceof Closure
                    ? $callback->bindTo($this)
                    : Closure::fromCallable($callback)->bindTo($this);
            } catch (Exception $e) {
                // ignore silently
            }

            $callback($this);
        }

        return $this;
    }

    /**
     * Alias for `self::condition()`. See the corresponding method for more details.
     *
     * @param mixed $condition
     *
     * @return static
     */
    public function if(mixed $condition): static
    {
        return $this->condition($condition);
    }

    /**
     * Alias for `self::function()`. See the corresponding method for more details.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function do(callable $callback): static
    {
        return $this->function($callback);
    }

    /**
     * Replaces variables in the passed string with values from the passed variables.
     *
     * @param string $text A string like `{var} Element`.
     * @param array<string,mixed> $variables An associative array like `['var' => 'HTML']`.
     *
     * @return string A string like `HTML Element`
     */
    private function interpolate(string $text, array $variables = []): string
    {
        $replacements = [];

        foreach ($variables as $key => $value) {
            $key   = sprintf('{%s}', trim($key));
            $value = is_scalar($value) || is_null($value) ? strval($value) : json_encode($value, JSON_UNESCAPED_SLASHES);

            $replacements[$key] = $value;
        }

        return strtr($text, $replacements);
    }

    /**
     * Checks if the passed condition and throws exception if it's not truthy.
     *      The message that is passed to this function should contain four `%s` placeholders for the
     *      `class`, `function`, `file` and `line` of the previous caller (offset 1 of the backtrace).
     *
     * @param bool $condition
     * @param string $message
     *
     * @return void
     *
     * @throws Exception
     */
    private function assert(bool $condition, string $message): void
    {
        if (!$condition) {
            return;
        }

        $variables    = ['class', 'function', 'file', 'line'];
        $backtrace    = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)[1] ?? [];
        $backtrace    = array_intersect_key($backtrace, array_flip($variables));
        $backtrace    = $backtrace ?: array_map(fn ($variable) => sprintf('{%s}', $variable), $variables);
        $placeholders = array_combine(array_map(fn ($variable) => sprintf('{%s}', $variable), array_keys($backtrace)), $backtrace);

        throw new Exception(strtr($message, $placeholders));
    }

    /**
     * Determines whether or not the last set condition is truthy or falsy.
     *
     * @param int $depth [optional] A flag to indicate condition depth `[+1 = opened, 0 = normal, -1 = closed]`.
     *
     * @return bool The result of the current condition.
     */
    protected function isConditionTruthy(int $depth = self::TAG_NORMAL): bool
    {
        static $parentConditions = [];

        $result = true;

        if (!empty($this->conditions) || !empty($parentConditions)) {
            $actualCondition = $this->conditions[count($this->conditions) - 1] ?? $result;
            $parentCondition = $parentConditions[count($parentConditions) - 1] ?? $result;
            $condition       = $parentCondition & $actualCondition;

            if (!$condition) {
                $result = false;
            }

            switch ($depth) {
                case self::TAG_OPENING:
                    array_push($parentConditions, $condition);

                    break;

                case self::TAG_CLOSING:
                    array_pop($parentConditions);

                    break;

                case self::TAG_NORMAL:
                    // do nothing
                    break;
            }

            array_pop($this->conditions);
        }

        return $result;
    }

    /**
     * Returns a normalized HTML tag name from the specified name.
     *
     * @param string $name The name of the tag.
     *
     * @return string
     */
    protected function normalizeTagName(string $name): string
    {
        return strtolower(trim($name));
    }

    /**
     * Returns an HTML attributes string from an associative array of attributes.
     *
     * @param array<int|string,null|string|bool> $attributes
     *
     * @return string
     */
    protected function stringifyAttributes(array $attributes): string
    {
        $string = '';

        foreach ($attributes as $name => $value) {
            if ($value === false) {
                continue;
            }

            $string .= is_string($name) === true && is_null($value) === false
                ? $this->interpolate(' {name}="{value}"', ['name' => $name, 'value' => $value])
                : $this->interpolate(' {attribute}', ['attribute' => $value ?: $name]);
        }

        return $string;
    }

    /**
     * Writes content to the HTML buffer.
     *
     * @param string $content The content to write.
     *      Note that the content will be indented if indentation is turned on
     *      (multiples of 4 spaces depending on the current stack).
     *
     * @return static
     */
    public function write(string $content): static
    {
        $prefix = $this->indent ? str_repeat(chr(32), 4 * count($this->stack)) : '';
        $suffix = $this->indent ? chr(10) : '';

        $this->buffer[] = $prefix . $content . $suffix;

        return $this;
    }

    /**
     * Returns the created HTML elements found in the buffer and empties it.
     *
     * @return string
     *
     * @throws Exception If not all open elements are closed.
     * @throws Exception If strict mode is turned on and the generated HTML is invalid.
     */
    public function render(): string
    {
        if (count($this->stack)) {
            $file = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)[1]['file'] ?? 'FILE';

            throw new Exception(
                strtr(
                    'Cannot return HTML in {file}. The following tag(s): "{tags}" has/have not been closed properly',
                    ['{file}' => $file, '{tags}' => implode(', ', $this->stack)]
                )
            );
        }

        $html = trim(implode('', $this->buffer));

        $this->buffer     = [];
        $this->stack      = [];
        $this->conditions = [];

        if ($this->strict) {
            $this->validate($html);
        }

        return $html;
    }

    /**
     * Asserts that the passed HTML is valid.
     *
     * @param string $html
     *
     * @return void
     *
     * @throws Exception If the passed HTML is invalid.
     */
    public static function validate(string $html): void
    {
        $html = !empty($html) ? $html : '<br/>';

        $previous = libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->validateOnParse = true;
        $dom->loadHTML($html);

        $ignoredCodes = [801];
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (!empty($errors) && !in_array($errors[0]->code, $ignoredCodes)) {
            $file = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)[2]['file'] ?? 'FILE';

            throw new Exception(
                strtr(
                    'HTML is invalid in {file}! Found {count} problem(s). ' .
                    'Last LibXMLError: [level:{level}/code:{code}] {message}',
                    [
                        '{file}'    => $file,
                        '{count}'   => count($errors),
                        '{level}'   => $errors[0]->level,
                        '{code}'    => $errors[0]->code,
                        '{message}' => $errors[0]->message,
                    ]
                )
            );
        }

        libxml_use_internal_errors($previous);
    }

    /**
     * Minifies HTML buffers by removing all unnecessary whitespaces and comments.
     *
     * @param string $html
     *
     * @return string
     */
    public static function minify(string $html): string
    {
        $patterns = [
            '/(\s)+/s'          => '$1', // shorten multiple whitespace sequences
            '/>[^\S ]+/s'       => '>',  // remove spaces after tag, except one space
            '/[^\S ]+</s'       => '<',  // remove spaces before tag, except one space
            '/<(\s|\t|\r?\n)+/' => '<',  // remove spaces, tabs, and new lines after start of the tag
            '/(\s|\t|\r?\n)+>/' => '>',  // remove spaces, tabs, and new lines before end of the tag
            '/<!--(.|\s)*?-->/' => '',   // remove comments
        ];

        $html = preg_replace(
            array_keys($patterns),
            array_values($patterns),
            $html
        );

        return trim($html);
    }
}
