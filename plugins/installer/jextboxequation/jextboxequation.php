<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 * @package     Installer - JExtBOX Equation
 * @author      Galaa
 * @publisher   JExtBOX.com - BOX of Joomla Extensions (www.jextbox.com)
 * @copyright   Copyright (C) 2017-2021 Galaa
 * @authorUrl   www.galaa.mn
 * @license     This extension in released under the GNU/GPL License - http://www.gnu.org/copyleft/gpl.html
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
jimport( 'joomla.plugin.plugin' );

class plgInstallerJExtBOXEquation extends JPlugin
{

	/**
	 * Handle adding credentials to package download request
	 *
	 * @param   string  $url        url from which package is going to be downloaded
	 * @param   array   $headers    headers to be sent along the download request (key => value format)
	 *
	 * @return  boolean true if credentials have been added to request or not our business, false otherwise (credentials not set by user)
	 *
	 * @since   2.5
	 */
	public function onInstallerBeforePackageDownload(&$url, &$headers)
	{

		if (stripos($url, 'jextbox.com/download?extension=165&update=true') === false)
			return false;
		JLoader::import('joomla.application.component.helper');
		$paymentid = JComponentHelper::getComponent('com_jextboxequation')->params->get('paymentid', '');
		if (empty($paymentid))
			throw new Exception('To update the paid full version of JExtBOX Equation, Payment or Invoice ID is required. If you have the valid ID, please enter it to configuration of JExtBOX Equation component.');
		$ch = curl_init('https://jextbox.com/download?extension=165&update=true');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('payment-id: '.$paymentid, 'authorization: true'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
		$response = curl_exec($ch);
		curl_close($ch);
		if ($response === false)
			throw new Exception('An error has occured during authorization of your Payment or Invoice ID for the extension JExtBOX Equation.');
		$response = json_decode($response);
		if (json_last_error() != JSON_ERROR_NONE || !isset($response->authorized) || !isset($response->message))
			throw new Exception('Connection has failed for the extension JExtBOX Equation.');
		if (!$response->authorized)
			throw new Exception($response->message);
		$headers['payment-id'] = $paymentid;
		return true;

	}

}

?>
