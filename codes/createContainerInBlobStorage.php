<?php

// required to work with azure blob storage
require_once "../vendor/autoload.php";

// just like import statement in python.Importing the classes definedin these filesr.
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Common\Models\Logging;
use MicrosoftAzure\Storage\Common\Models\Metrics;
use MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

function createContainerSample($blobClient){
     // OPTIONAL: Set public access policy and metadata.
     // Create container options object.
     $createContainerOptions = new CreateContainerOptions();

                // Set public access policy. Possible values are
                // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
                // CONTAINER_AND_BLOBS: full public read access for container and blob data.
                // BLOBS_ONLY: public read access for blobs. Container data not available.
                // If this value is not specified, container data is private to the account owner.
                $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

                // Set container metadata
                $createContainerOptions->addMetaData("key1", "value1");
                $createContainerOptions->addMetaData("key2", "value2");

                try {
                        // Create container.
                        global $myContainer;
                        $blobClient->createContainer($myContainer, $createContainerOptions);
			echo "$myContainer created successfully";
                } catch (ServiceException $e) {
                        $code = $e->getCode();
                        $error_message = $e->getMessage();
                        echo $code.": ".$error_message.PHP_EOL;
                }
        }


        function setBlobServiceProperties($blobClient){
                // Get blob service properties
                echo "Get Blob Service properties" . PHP_EOL;
                $originalProperties = $blobClient->getServiceProperties();
                // Set blob service properties
                echo "Set Blob Service properties" . PHP_EOL;
                $retentionPolicy = new RetentionPolicy();
                $retentionPolicy->setEnabled(true);
                $retentionPolicy->setDays(10);

                $logging = new Logging();
                $logging->setRetentionPolicy($retentionPolicy);
                $logging->setVersion('1.0');
                $logging->setDelete(true);
                $logging->setRead(true);
                $logging->setWrite(true);

                $metrics = new Metrics();
                $metrics->setRetentionPolicy($retentionPolicy);
                $metrics->setVersion('1.0');
                $metrics->setEnabled(true);
                $metrics->setIncludeAPIs(true);

                $serviceProperties = new ServiceProperties();
                $serviceProperties->setLogging($logging);
                $serviceProperties->setHourMetrics($metrics);
                $blobClient->setServiceProperties($serviceProperties);
                // revert back to original properties
                echo "Revert back to original service properties" . PHP_EOL;
                $blobClient->setServiceProperties($originalProperties->getValue());
                echo "Service properties sample completed" . PHP_EOL;
        }


// Lets test if the form has been submitted
if(isset($_POST['SubmitCheck'])) {

	// collected posted value from the form in html to variable in php
	$folderName = $_POST['folderName'];

	// Create Connection String
	$connectionString = 'DefaultEndpointsProtocol=https;AccountName=amitstoracc;AccountKey=pdBQltIRo8CvdaAJCEW8Q8wUM0WptAY45TOakC7ZjTgIhhKzvPNszJela1JhEOmxkma4F13FlleuWl1dJ/qtqQ==';

	// Create blob REST proxy i.e. client. (Instantiate a client object)
	$blobClient = BlobRestProxy::createBlobService($connectionString);

	// create container
	$myContainer = $folderName;

	// Get and Set Blob Service Properties
//	setBlobServiceProperties($blobClient);

	// To create a container call createContainer.
	createContainerSample($blobClient);
}

?>
