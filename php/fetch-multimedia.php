<?php
	require_once 'vendor/autoload.php';
	use MicrosoftAzure\Storage\Blob\BlobRestProxy;
	use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

	$connectionString = "DefaultEndpointsProtocol=https;AccountName=batid;AccountKey=Vq8tzPy1nGrtTERtNOqCGdoEyY8ceO41LkIn6SRuLUGIxNK1ofuhC4idwQy5moLjMiJgIx/isBFHE4zoietWkw==;";
	$blobClient = BlobRestProxy::createBlobService($connectionString);

	$all_multimedia = array();
	try {	
		$blob_list = $blobClient->listBlobs("multimedia");
		$blobs = $blob_list->getBlobs();
		foreach($blobs as $blob)
		{
			$key = explode("_", pathinfo($blob->getUrl())['filename'])[0];
			if(!array_key_exists($key, $all_multimedia)) {
				$all_multimedia[$key] = array($blob->getUrl());
			}
			else {
				array_push($all_multimedia[$key], $blob->getUrl());
			}
		}
		echo json_encode($all_multimedia);
	}
	catch(ServiceException $e){
		$code = $e->getCode();
		$error_message = $e->getMessage();
		echo $code.": ".$error_message."<br/>";
	}
?>