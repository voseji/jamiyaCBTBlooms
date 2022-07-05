<?php

/**
* @extension     JExtBOX Equation
* @author        Galaa
* @authorUrl     www.galaa.mn
* @publisher     JExtBOX - BOX of Joomla Extensions
* @publisherURL  www.jextbox.com
* @copyright     Copyright (C) 2013-2021 Galaa
* @license       This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.html.parameter' );

class plgSystemJExtBOXEquation extends JPlugin
{

	function onBeforeCompileHead ()
	{

		$app = JFactory::getApplication();
		if ($app->isClient('administrator'))
			return;

		$com_parameters = JComponentHelper::getParams('com_jextboxequation');
		if ($com_parameters->get('apply', 'whole-site') !== 'whole-site')
			return;

		$input = JFactory::getApplication()->input;
		if ((($option = $input->get('option')) === 'com_content' && $input->get('view') === 'form') || $option === 'com_jextboxequation')
			return;

		// Version
		$version = $com_parameters->get('version', '2.7.7');
		if (!preg_match('/^(2|3)\.[0-9]+\.[0-9]+$/', $version))
		{
			$version = '2.7.7';
		}
		// Add MathJax Scripts
		$doc = JFactory::getDocument();
		// MathJax Configuration
		if ($v2 = version_compare($version, '3.0.0', '<')) // v2
		{
			$doc->addScriptDeclaration($com_parameters->get('mathjaxconfig', 'MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "AMS"} }, showMathMenu: false, messageStyle: "none" });'), 'text/x-mathjax-config');
		}
		else // v3
		{
			$doc->addScriptDeclaration($com_parameters->get('mathjaxconfig', 'window.MathJax = { tex: {tags: "ams"}, options: {enableMenu: false} };'), 'text/x-mathjax-config');
		}
		// MathJax Script
		if (($localmathjax = $com_parameters->get('localmathjax', '')) != '')
		{
			$localmathjax = JUri::base(true).'/'.trim($localmathjax, '/').($v2 ? '/MathJax.js?config=TeX-MML-AM_CHTML' : '/tex-chtml.js');
		}
		if ($com_parameters->get('source', 'cdn') === 'cdn' || $localmathjax == '') // CDN
		{
			$doc->addScript
			(
				(
					$v2 ? // check for version
					'//cdnjs.cloudflare.com/ajax/libs/mathjax/'.$version.'/latest.js?config=TeX-MML-AM_CHTML' : // specific or latest version
					'//cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js' // latest version only
				), 'text/javascript', false, true
			);
			// Fallback to Local Installation
			if ($localmathjax != '')
			{
				$doc->addScriptDeclaration('window.MathJax || document.write(\'<script src="'.$localmathjax.'"><\/script>\');');
			}
		}
		else // Local Installation
		{
			$doc->addScript($localmathjax, 'text/javascript', false, true);
		}

		// CSS for LaTeX2HTML5
		$doc->addStyleSheet('plugins/content/jextboxequation/latex2html5/latex2js.css');
		// LaTeX2HTML5 javascript library
		$doc->addScript('plugins/content/jextboxequation/latex2html5/latex2html5.bundle.js');
		// adding launcher of LaTeX2HTML5
		$doc->addScriptDeclaration('document.addEventListener("DOMContentLoaded",function(){LaTeX2HTML5.init();});');
		// Listener for DOM changes
		$doc->addScriptDeclaration('document.addEventListener("DOMSubtreeModified", function (ev) { '.($v2 ? 'MathJax.Hub.Queue(["Typeset",MathJax.Hub]);' : 'MathJax.typeset();').' }, false);');

	}

	function onAfterRender ()
	{

		$app = JFactory::getApplication();
		if ($app->isClient('administrator'))
			return;

		$com_parameters = JComponentHelper::getParams('com_jextboxequation');
		if ($com_parameters->get('apply', 'whole-site') !== 'whole-site')
			return;

		$input = $app->input;
		if ((($option = $input->get('option')) === 'com_content' && $input->get('view') === 'form') || $option === 'com_jextboxequation')
			return;

		$html = $app->getBody();

		if (strpos($html, '$$') === false and strpos($html, '\[') === false and strpos($html, '$') === false and strpos($html, '\(') === false and strpos($html, '\begin{eq') === false and strpos($html, '\begin{pspicture}') === false)
			return;

		// escape dollar sign
		$html = str_replace('\$', '&#36;', $html);
		// escape dollar sign inside all pre or code tags
		preg_match_all('/<pre[\s\S]*?>[\s\S]*?<\/pre>|<code[\s\S]*?>[\s\S]*?<\/code>/i', $html, $codes);
		foreach ($codes[0] as $code)
		{
			$replace = str_replace('$', '&#36;', $code);
			$html = str_replace($code, $replace, $html);
		}
		// converting line equations $$
		$html = preg_replace('/\$\$([^\$]+)\$\$/', '\[$1\]', $html);
		// converting inline equations $
		$body = strip_tags(preg_replace('/.*<\/head>|<\/html>|<script[\s\S]*?>[\s\S]*?<\/script>|<pre[\s\S]*?>[\s\S]*?<\/pre>|<code[\s\S]*?>[\s\S]*?<\/code>/i', '', $html));
		preg_match_all('/\$([^\$]+)\$/', $body, $equations);
		foreach ($equations[1] as &$equation)
			$equation = '\('.$equation.'\)';
		$html = str_replace($equations[0], $equations[1], $html);
		// removes a space after line equation
		$html = str_replace('\] ', '\]', $html);
		$html = str_replace('\]&nbsp;', '\]', $html);
		$html = str_replace('\end{equation} ', '\end{equation}', $html);
		$html = str_replace('\end{equation}&nbsp;', '\end{equation}', $html);
		$html = str_replace('\end{eqnarray} ', '\end{eqnarray}', $html);
		$html = str_replace('\end{eqnarray}&nbsp;', '\end{eqnarray}', $html);
		$html = str_replace('\end{eqnarray*} ', '\end{eqnarray*}', $html);
		$html = str_replace('\end{eqnarray*}&nbsp;', '\end{eqnarray*}', $html);
		// LaTeX2HTML5 (pspicture) -- MathJax must be loaded
		if (strpos($html, '\begin{pspicture}') !== false) // checking for existing pspicture
		{
			// preparing for skips all pspictures inside all pre or code tags
			preg_match_all('/<pre[\s\S]*?>[\s\S]*?<\/pre>|<code[\s\S]*?>[\s\S]*?<\/code>/i', $html, $codes);
			foreach ($codes[0] as $code)
			{
				$replace = str_replace(
					array('\begin{pspicture}', '\end{pspicture}'),
					array('jextboxequation_beginpspicture', 'jextboxequation_endpspicture'),
					$code
				);
				$html = str_replace($code, $replace, $html);
			}
			// preparing all PSPictures for LaTeX2HTML5
			preg_match_all('/.begin.pspicture.[\s\S]*?.end.pspicture./i', $html, $pspictures);
			foreach ($pspictures[0] as $pspicture)
			{
				$replace = preg_replace('/<br ?\/?>/i', "\r\n", $pspicture);
				$replace = str_replace('&gt;', '>', $replace);
				$html = str_replace($pspicture, '<script type="text/latex">'.$replace.'</script>', $html);
			}
			// skipping all pspictures inside all pre or code tags
			$html = str_replace(
				array('jextboxequation_beginpspicture', 'jextboxequation_endpspicture'),
				array('\begin{pspicture}', '\end{pspicture}'),
				$html
			);
		}
		$app->setBody($html);

	}

}

?>
