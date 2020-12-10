<?php

/**
 * ObjectSerializer
 *
 * PHP version 5
 *
 * @category Class
 * @author   rodrigojob

 */
/**
 * Selling Partner API for Solicitations
 *
 * With the Solicitations API you can build applications that send non-critical solicitations to buyers. You can get a list of solicitation types that are available for an order that you specify, then call an operation that sends a solicitation to the buyer for that order. Buyers cannot respond to solicitations sent by this API, and these solicitations do not appear in the Messaging section of Seller Central or in the recipient's Message Center. The Solicitations API returns responses that are formed according to the <a href=https://tools.ietf.org/html/draft-kelly-json-hal-08>JSON Hypertext Application Language</a> (HAL) standard.
 *
 * OpenAPI spec version: v1
 *
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.20
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Api;

/**
 * Signature Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   rodrigojob
 */
class SignatureSellingPartner {

    /**
     * calculateSignature data
     *
     * @param string  $accessKey   the Selling Partner Access Key
     * @param string  $secretKey   the IAM secret
     * @param string  $region the region use AWS
     * @param string  $accessToken   the Selling Partner access-token
     * @param string  $userAgent   the user-agent to sign
     * @param string  $host   the host to sign
     * @param string  $method   the method to sign
     * @param string  $uri   the uri to sign
     * @param string  $queryString   the queryString to sign
     * @param mixed   $data   the data to sign
     *
     * @return array headers signed
     */
    public static function calculateSignature($accessKey, $secretKey, $region, $accessToken, $userAgent, $host, $method, $uri = "", $queryString = "", $data = array()){
        $service = 'execute-api';
        $terminationString = 'aws4_request';
        $algorithm = 'AWS4-HMAC-SHA256';
        $amzdate = gmdate('Ymd\THis\Z');
        $date = substr($amzdate, 0, 8);

        $param = json_encode($data);
        if ($param == "[]") {
            $requestPayload = "";
        } else {
            $requestPayload = strtolower($param);
        }
        $hashedPayload = hash('sha256', $requestPayload);

        $canonical_headers = "host:" . $host . "\n" . "user-agent:" . $userAgent . "\n" . "x-amz-access-token:" . $accessToken . "\n" . "x-amz-date:" . $amzdate . "\n";
        $credential_scope = $date . '/' . $region . '/' . $service . '/' . $terminationString;
        $signed_headers = 'host;user-agent;x-amz-access-token;x-amz-date';

        $canonical_request = $method . "\n" . $uri . "\n" . $queryString . "\n" . $canonical_headers . "\n" . $signed_headers . "\n" . $hashedPayload;

        $stringToSign = $algorithm . "\n" . $amzdate . "\n" . $credential_scope . "\n" . hash('sha256', $canonical_request);
        $kSecret = "AWS4" . $secretKey;
        $kDate = hash_hmac('sha256', $date, $kSecret, true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', $service, $kRegion, true);
        $kSigning = hash_hmac('sha256', $terminationString, $kService, true);

        $signature = trim(hash_hmac('sha256', $stringToSign, $kSigning)); // Without fourth parameter passed as true, returns lowercase hexits as called for by docs

        $authorization_header = $algorithm . " Credential={$accessKey}/{$credential_scope}, SignedHeaders={$signed_headers}, Signature={$signature}";
        $headers = array(
            "host" => $host,
            "Authorization" => $authorization_header,
            "user-agent" => $userAgent,
            "x-amz-access-token" => $accessToken,
            "x-amz-date" => $amzdate
        );

        return $headers;
    }

}
