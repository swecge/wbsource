<?php

     include_once("azureAuthority.php");

	 function getAzureKeyVaultSecrets($azureTenantId, $azureKeyVaultUrl, $azureKeyVaultClientSecret)
	 {
	    $results = array();

		$accessToken = getAzureKeyVaultToken();
		  
		$secretItems = getAzureKeyVaultSecretItems($azureKeyVaultUrl, $accessToken);
		$secrets = $secretItems->value;

		foreach($secrets as $secret)
		{
			$secret_id_parts = parse_url($secret->id);
			$secret_path_parts = explode("/", $secret_id_parts["path"]);
			$secretName = $secret_path_parts[2];
			$secret = getAzureKeyVaultSecret($azureKeyVaultUrl, $accessToken, $secretName);
			$secretValue = $secret->value;

			$results[$secretName] = $secretValue ;
		}

		   return $results;

	 }


	 function getAzureKeyVaultSecret($azureKeyVaultUrl, $accessToken, $secretName)
	 {
		$url = $azureKeyVaultUrl . "/secrets/" . $secretName . "/?api-version=7.0" ;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'User-Agent: 0',
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $accessToken  
		));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		$error = curl_error($ch);

		curl_close($ch);

		if (!is_string($result) || !strlen($result)) 
		{
			return $error;
		}
		else 
		{
			return json_decode($result);
		}
	}


	function getAzureKeyVaultSecretItems($azureKeyVaultUrl, $accessToken)
	{
		$url = $azureKeyVaultUrl . "/secrets?maxresults=10&api-version=7.0";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'User-Agent: 0',
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $accessToken  
		));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		$error = curl_error($ch);

		curl_close($ch);

		if (!is_string($result) || !strlen($result)) 
		{
			return $error;
		}
		else 
		{
			return json_decode($result);
		}
	}


	function getAzureKeyVaultToken()
	{
		return getAzToken();
	}

?>