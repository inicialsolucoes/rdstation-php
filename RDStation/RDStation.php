<?php

namespace RDStation;

/**
 * RDStation
 * @author Fabiano Lima <facodeli@gmail.com>
 *
 * RD Station Help
 * @link http://ajuda.rdstation.com.br/hc/pt-br
 */
class RDStation
{
    /**
     * @access private
     * @var string
     */
    private $__apiBaseUrl = 'https://www.rdstation.com.br/api/';

    /**
     * @access private
     * @var string
     */
    private $__apiVersion = '1.3';

    /**
     * @access private
     * @var string
     */
    private $__apiPrivateToken = '';

    /**
     * @access private
     * @var string
     */
    private $__apiToken = '';

    /**
     * @access private
     * @var string
     */
    private $__leadEmail = '';

    /**
     * @access private
     * @var array
     */
    private $__leadData = array();

    /**
     * @access private
     * @var string
     */
    private $__debug = false;

    /**
     * CONSTRUCTOR
     *
     * URL to get tokens
     * https://www.rdstation.com.br/integracoes/tokens
     *
     * @param  string $leadEmail
     * @param  bool   $debug
     * @return object $this
     */
    public function __construct($leadEmail, $debug = false) {

        $this->__leadEmail = $leadEmail;
        $this->__debug     = $debug;

        return $this;
    }

    /**
     * PERFORM REQUEST TO API
     *
     * API can be set as:
     *
     * conversions (Use to send a new lead)
     * leads       (Use to update lead data)
     * tags        (Use to insert tags on lead)
     * generic     (Use to change lead status)
     *
     * @param string $method (POST, PUT)
     * @param string $api    (conversions, leads, tags, generic)
     * @return array
     */
    private function __request($method, $api) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL           , $this->__apiURL($api));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST , $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS    , http_build_query($this->__leadData));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_VERBOSE       , $this->__debug);
        curl_setopt($curl, CURLOPT_IPRESOLVE     , CURL_IPRESOLVE_V4);

        $result = curl_exec($curl);

        $response = array();
        $response['result'] = json_decode ($result);

        if ($this->__debug) {

            $response['error']  = curl_error  ($curl);
            $response['info']   = curl_getinfo($curl);
        }

        curl_close($curl);

        return $response;
    }

    /**
     * GET API URL
     *
     * API can be set as:
     *
     * conversions (Use to send a new lead)
     * leads       (Use to update lead data)
     * tags        (Use to insert tags on lead)
     * generic     (Use to change lead status)
     *
     * @param  string $api
     * @return string
     */
    private function __apiURL($api = 'conversions') {

        switch ($api) {

            case 'conversions':
                return $this->__apiBaseUrl.$this->__apiVersion.'/conversions';
                break;

            case 'leads':
                return $this->__apiBaseUrl.$this->__apiVersion.'/leads/'.$this->__leadEmail;
                break;

            case 'tags':
                return $this->__apiBaseUrl.$this->__apiVersion.'/leads/'.$this->__leadEmail.'/tags';
                break;

            case 'generic':
                return $this->__apiBaseUrl.$this->__apiVersion.'/services/'.$this->__apiPrivateToken.'/generic';
                break;

            default:
                throw new \Exception('Unsupported API!');
                break;
        }
    }

    /**
     * SET LEAD EMAIL
     *
     * @param  string $leadEmail
     * @return object $this
     */
    public function setLeadEmail($leadEmail) {

        $this->__leadEmail = $leadEmail;

        return $this;
    }

    /**
     * SET API BASE URL
     *
     * @param  string $apiBaseUrl
     * @return object $this
     */
    public function setApiBaseUrl($apiBaseUrl) {

        $this->__apiBaseUrl = $apiBaseUrl;

        return $this;
    }

    /**
     * SET API VERSION
     *
     * @param  string $apiVersion
     * @return object $this
     */
    public function setApiVersion($apiVersion) {

        $this->__apiVersion = $apiVersion;

        return $this;
    }

    /**
     * SET API PRIVATE TOKEN
     *
     * @param  string $apiPrivateToken
     * @return object $this
     */
    public function setApiPrivateToken($apiPrivateToken) {

        $this->__apiPrivateToken = $apiPrivateToken;

        return $this;
    }

    /**
     * SET API TOKEN
     *
     * @param  string $apiToken
     * @return object $this
     */
    public function setApiToken($apiToken) {

        $this->__apiToken = $apiToken;

        return $this;
    }

    /**
     * SET LEAD DATA
     *
     * Default Lead Data:
     *
     * identificador, nome, cargo, empresa, cargo
     * telefone, celular, estado, cidade, website
     * twitter, c_utmz, traffic_source, cliente_id, tags
     *
     * Custom lead data can be set end send to RD Station
     *
     * @param  string $param
     * @param  mixed  $value
     * @return object $this
     */
    public function setLeadData($param, $value) {

        $this->__leadData[$param] = $value;

        return $this;
    }

    /**
     * SEND NEW LEAD
     *
     * Required Lead Data
     *
     * identificador (Identifier of the conversion event)
     *
     * Optional Lead Data
     *
     * nome, cargo, empresa, cargo, telefone, celular, estado, cidade
     * website, twitter, c_utmz, traffic_source, cliente_id, tags
     *
     * Custom lead data can be set end send to RD Station
     *
     * @return RDStation::__request()
     */
    public function sendLead() {

        /////////////////////////////////////////////////////////////////////
        // CHECK REQUIRED DATA //////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        if (is_null($this->__apiToken)) {
            throw new \Exception("API Token must be setted!");
        }

        if (is_null($this->__leadEmail)) {
            throw new \Exception("Lead email must be setted!");
        }

        if (!isset($this->__leadData['identificador'])) {
            throw new \Exception("Lead data 'identificador' must be setted!");
        }

        /////////////////////////////////////////////////////////////////////
        // PREPARE DATA COLLECTION //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        $this->__leadData['token_rdstation'] = $this->__apiToken;
        $this->__leadData['email']           = $this->__leadEmail;

        /////////////////////////////////////////////////////////////////////
        // PERFORM REQUEST TO API ///////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        return $this->__request('POST', 'conversions');
    }

    /**
     * UPDATE LEAD
     *
     * Optional Lead Data
     *
     * nome, cargo, empresa, cargo, telefone, celular, estado, cidade
     * website, twitter, c_utmz, traffic_source, cliente_id, tags
     *
     * Custom lead data can be set end send to RD Station
     *
     * @return RDStation::__request()
     */
    public function updateLead() {

        /////////////////////////////////////////////////////////////////////
        // CHECK REQUIRED DATA //////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        if (is_null($this->__apiPrivateToken)) {
            throw new \Exception("API Private Token must be setted!");
        }

        if (is_null($this->__leadEmail)) {
            throw new \Exception("Lead email must be setted!");
        }

        /////////////////////////////////////////////////////////////////////
        // PREPARE DATA COLLECTION //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        $leadData               = array();
        $leadData['auth_token'] = $this->__apiPrivateToken;
        $leadData['lead']       = $this->__leadData;

        $this->__leadData = $leadData;

        /////////////////////////////////////////////////////////////////////
        // PERFORM REQUEST TO API ///////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        return $this->__request('PUT', 'leads');
    }

    /**
     * INSERT TAGS ON LEAD
     *
     * Required Lead Data
     *
     * tags (Separated by comma)
     *
     * @return RDStation::__request()
     */
    public function sendLeadTags() {

        /////////////////////////////////////////////////////////////////////
        // CHECK REQUIRED DATA //////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        if (is_null($this->__apiPrivateToken)) {
            throw new \Exception("API Private Token must be setted!");
        }

        if (is_null($this->__leadEmail)) {
            throw new \Exception("Lead email must be setted!");
        }

        if (!isset($this->__leadData['tags'])) {
            throw new \Exception("Lead data 'tags' must be setted!");
        }

        /////////////////////////////////////////////////////////////////////
        // PREPARE DATA COLLECTION //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        $this->__leadData['auth_token'] = $this->__apiPrivateToken;

        /////////////////////////////////////////////////////////////////////
        // PERFORM REQUEST TO API ///////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        return $this->__request('POST', 'tags');
    }

    /**
     * UPDATE LEAD STAGE
     *
     * Required Lead Data
     *
     * lifecycle_stage (0 - Lead, 1 - Qualified lead, 2 - Client)
     *
     * Optional Lead Data
     *
     * opportunity (true or false, to check lead as opportunity)
     *
     * @return RDStation::__request()
     */
    public function updateLeadStage() {

        /////////////////////////////////////////////////////////////////////
        // CHECK REQUIRED DATA //////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        if (is_null($this->__apiPrivateToken)) {
            throw new \Exception("API Private Token must be setted!");
        }

        if (is_null($this->__leadEmail)) {
            throw new \Exception("Lead email must be setted!");
        }

        if (!isset($this->__leadData['lifecycle_stage'])) {
            throw new \Exception("Lead data 'lifecycle_stage' must be setted!");
        }

        /////////////////////////////////////////////////////////////////////
        // PREPARE DATA COLLECTION //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        $lead = array();

        if (isset($this->__leadData['lifecycle_stage'])) {
            $lead['lifecycle_stage'] = $this->__leadData['lifecycle_stage'];
        }

        if (isset($this->__leadData['opportunity'])) {
            $lead['opportunity'] = $this->__leadData['opportunity'];
        }

        $leadData               = array();
        $leadData['auth_token'] = $this->__apiPrivateToken;
        $leadData['lead']       = $lead;

        $this->__leadData = $leadData;

        /////////////////////////////////////////////////////////////////////
        // PERFORM REQUEST TO API ///////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        return $this->__request('PUT','leads');
    }

    /**
     * UPDATE LEAD STATUS
     *
     * Required Lead Data
     *
     * status (won, lost)
     *
     * Optional Lead Data
     *
     * value       (Conversion amount, if status is won)
     * lost_reason (Reason of the lost, if status is lost)
     *
     * @return RDStation::__request()
     */
    public function updateLeadStatus() {

        /////////////////////////////////////////////////////////////////////
        // CHECK REQUIRED DATA //////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        if (is_null($this->__apiPrivateToken)) {
            throw new \Exception("API Private Token must be setted!");
        }

        if (is_null($this->__leadEmail)) {
            throw new \Exception("Lead email must be setted!");
        }

        if (!isset($this->__leadData['status'])) {
            throw new \Exception("Lead data 'status' must be setted!");
        }

        /////////////////////////////////////////////////////////////////////
        // PREPARE DATA COLLECTION //////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        $this->__leadData['email'] = $this->__leadEmail;

        /////////////////////////////////////////////////////////////////////
        // PERFORM REQUEST TO API ///////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////

        return $this->__request('POST', 'generic');
    }
}