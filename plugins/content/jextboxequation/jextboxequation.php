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

class plgContentJExtBOXEquation extends JPlugin
{

	function onContentPrepare($context, &$article, &$params, $limitstart=0)
	{

		$com_parameters = JComponentHelper::getParams('com_jextboxequation');

		if ($com_parameters->get('apply', 'whole-site') === 'whole-site')
		{
			return;
		}

		$input = JFactory::getApplication()->input;
		if ($input->get('option') !== 'com_content')
		{
			return;
		}

		if (strpos($article->text, '$$') === false && strpos($article->text, '\[') === false && strpos($article->text, '$') === false && strpos($article->text, '\(') === false && strpos($article->text, '\begin{eq') === false && strpos($article->text, '\begin{pspicture}') === false)
		{
			return;
		}

		$doc = JFactory::getDocument();
		if (is_null($input->get('jextbox_mathjax')))
		{
			$input->set('jextbox_mathjax', 'loaded');
			// Version
			$version = $com_parameters->get('version', '2.7.7');
			if (!preg_match('/^(2|3)\.[0-9]+\.[0-9]+$/', $version))
			{
				$version = '2.7.7';
			}
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
			$localmathjax = JUri::base(true).'/'.trim($com_parameters->get('localmathjax', 'media/MathJax'), '/').($v2 ? '/MathJax.js?config=TeX-MML-AM_CHTML' : '/tex-chtml.js');
			if ($com_parameters->get('source', 'cdn') === 'cdn') // CDN
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
				$doc->addScriptDeclaration('window.MathJax || document.write(\'<script src="'.$localmathjax.'"><\/script>\');');
			}
			else // Local Installation
			{
				$doc->addScript($localmathjax, 'text/javascript', false, true);
			}
		}
		// preparing for skip all equations inside all pre or code tags
		preg_match_all('/<pre[\s\S]*?>[\s\S]*?<\/pre>|<code[\s\S]*?>[\s\S]*?<\/code>/i', $article->text, $codes);
		foreach ($codes[0] as $code)
		{
			$replace = str_replace('$', 'jextboxequation_dollar_sign', $code);
			$article->text = str_replace($code, $replace, $article->text);
		}
		// converting line equations $$
		$article->text = preg_replace('/\$\$([^\$]+)\$\$/', '\[$1\]', $article->text);
		// converting inline equations $
		$article->text = preg_replace('/\$([^\$]+)\$/', '\($1\)', $article->text);
		// skipping all equations inside all pre or code tags
		$article->text = str_replace('jextboxequation_dollar_sign', '$', $article->text);
		// removes a space after line equation
		$article->text = str_replace('\] ', '\]', $article->text);
		$article->text = str_replace('\]&nbsp;', '\]', $article->text);
		$article->text = str_replace('\end{equation} ', '\end{equation}', $article->text);
		$article->text = str_replace('\end{equation}&nbsp;', '\end{equation}', $article->text);
		$article->text = str_replace('\end{eqnarray} ', '\end{eqnarray}', $article->text);
		$article->text = str_replace('\end{eqnarray}&nbsp;', '\end{eqnarray}', $article->text);
		$article->text = str_replace('\end{eqnarray*} ', '\end{eqnarray*}', $article->text);
		$article->text = str_replace('\end{eqnarray*}&nbsp;', '\end{eqnarray*}', $article->text);
		// LaTeX2HTML5 (pspicture) -- MathJax must be loaded
		if (strpos($article->text, '\begin{pspicture}') !== false) // checking for existing pspicture
		{
			// preparing for skips all pspictures inside all pre or code tags
			preg_match_all('/<pre[\s\S]*?>[\s\S]*?<\/pre>|<code[\s\S]*?>[\s\S]*?<\/code>/i', $article->text, $codes);
			foreach ($codes[0] as $code)
			{
				$replace = str_replace
				(
					array('\begin{pspicture}', '\end{pspicture}'),
					array('jextboxequation_beginpspicture', 'jextboxequation_endpspicture'),
					$code
				);
				$article->text = str_replace($code, $replace, $article->text);
			}
			// preparing all PSPictures for LaTeX2HTML5
			preg_match_all('/.begin.pspicture.[\s\S]*?.end.pspicture./i', $article->text, $pspictures);
			foreach ($pspictures[0] as $pspicture)
			{
				$replace = preg_replace('/<br ?\/?>/i', "\r\n", $pspicture);
				$replace = str_replace('&gt;', '>', $replace);
				$article->text = str_replace($pspicture, '<script type="text/latex">'.$replace.'</script>', $article->text);
			}
			// skipping all pspictures inside all pre or code tags
			$article->text = str_replace(
				array('jextboxequation_beginpspicture', 'jextboxequation_endpspicture'),
				array('\begin{pspicture}', '\end{pspicture}'),
				$article->text
			);
			if (is_null($input->get('jextbox_latex2html5')))
			{
				$input->set('jextbox_latex2html5', 'loaded');
				// CSS for LaTeX2HTML5
				$doc->addStyleSheet('plugins/content/jextboxequation/latex2html5/latex2js.css');
				// LaTeX2HTML5 javascript library
				$doc->addScript('plugins/content/jextboxequation/latex2html5/latex2html5.bundle.js');
				// adding launcher of LaTeX2HTML5
				$doc->addScriptDeclaration('document.addEventListener("DOMContentLoaded",function(){LaTeX2HTML5.init();});');
			}
		}

	}

}

?>
