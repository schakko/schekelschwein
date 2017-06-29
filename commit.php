<?php
/*
 * This "API" expects the HTTP headers "Secret-Key" and "Mining-Rig" for uploading the data.
 * Data can be uploaded with cURL by using
 * <pre>
 * curl -v -X POST -H "Secret-Key: pw" -H "Mining-Rig: rig0.mining" --data-binary @rig0.mining.bak http://localhost:8080/commit.php 
 * </pre>
 */
define("ROOT", dirname(__FILE__));

include_once(ROOT . '/.config.php');

// required headers which must be present
$requiredHeaders = array('mining-rig' => '', 'secret-key' => '');

$headers = getallheaders();

foreach ($headers as $header => $value) {
    if (isset($requiredHeaders[strtolower($header)])) {
        $requiredHeaders[strtolower($header)] = $value;
    }
}

$secretKey = $requiredHeaders['secret-key'];

if (empty($secretKey)) {
    header("Status: 401 Unauthorized - Missing credentials");
    exit;
}

if ($secretKey != SHARED_SECRET_API) {
    header("Status: 401 Unauthorized - Invalid API key");
    exit;
}

$miningRig = $requiredHeaders['mining-rig'];

if (empty($miningRig)) {
    header("Status: 400 Missing 'mining-rig' header");
    exit;
}

if (!preg_match("/^(\w*)\.mining$/", $miningRig)) {
    header("Status: 400 'mining-rig' header must match xyz.mining");
    exit;
}

print_r($_POST);

$content = file_get_contents('php://input');

# $content = str_replace("\n", "\r\n", $content);

if (strlen($content) < 100) {
    header("Status: 411 The committed data must be atleast 100 bytes large");
    exit;
}

file_put_contents(DATA_DIR . '/' . $miningRig, $content);

header("Status: 200 Content for host " . $miningRig . " commited");
exit;
