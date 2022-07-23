
<?php 
    if(!defined('SOCKETLABS_INJECTION_API_SAMPLE_ROOT_PATH'))
    define('SOCKETLABS_INJECTION_API_SAMPLE_ROOT_PATH', dirname(__DIR__) . '/');

    // check for parameter
    if (isset($_POST['fileNameOfExample'])) {
        runExample($_POST['fileNameOfExample']);
    }

    function runExample($fileNameOfExample){
        $exampleCodePath= "../../ExampleCode/$fileNameOfExample";

        include $exampleCodePath;

        $factory = new \Socketlabs\Core\InjectionRequestFactory(exampleConfig::serverId(), exampleConfig::password());
        $request = $factory->generateRequest($message);

        $response->responseMessage = $response->responseMessage;
        $output = array("request"=>$request, "response"=>$response);
        
        header('Content-Type: application/json');
        echo json_encode($output);
    }
?>