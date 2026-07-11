<?php
/**
 * jqGrid cURL API Functions
 * Provides complete CRUD operations for jqGrid via REST API
 * Supports HTTP authentication and SSL/non-SSL connections
 * @author Abu Ghufran (www.gridphp.com)
 * @since 08-Oct-2025
 */

class jqgrid_api {
    
    private $base_url;
    private $username;
    private $password;
    private $timeout = 30;
    private $connect_timeout = 10;
    
    /**
     * Constructor
     * @param string $base_url Base API URL
     * @param string $username HTTP Auth username (optional)
     * @param string $password HTTP Auth password (optional)
     */
    public function __construct($base_url, $username = null, $password = null) {
        $this->base_url = rtrim($base_url, '/');
        $this->username = $username;
        $this->password = $password;
    }
    
    /**
     * Initialize cURL with common settings
     * @param string $url Full URL for the request
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @return resource cURL handle
     */
    private function init_curl($url, $method = 'GET') {
        $ch = curl_init($url);
        
        // Common cURL options
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connect_timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            
            // SSL settings - Enable for HTTPS
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            
            // For development/testing only - Disable SSL verification
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        
        // Set HTTP method
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        // HTTP Authentication
        if ($this->username && $this->password) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        }
        
        return $ch;
    }
    
    /**
     * Execute cURL request and handle response
     * @param resource $ch cURL handle
     * @return array Response array with success, data, http_code, error
     */
    private function execute_curl($ch) {
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        
        curl_close($ch);
        
        // Handle cURL errors
        if ($errno) {
            return array(
                'success' => false,
                'error' => $error,
                'error_code' => $errno,
                'http_code' => $http_code
            );
        }
        
        // Handle HTTP errors
        if ($http_code >= 400) {
            return array(
                'success' => false,
                'http_code' => $http_code,
                'response' => $response,
                'error' => "HTTP Error $http_code"
            );
        }
        
        // Success
        $data = json_decode($response, true);
        return array(
            'success' => true,
            'http_code' => $http_code,
            'data' => $data !== null ? $data : $response,
            'raw_response' => $response
        );
    }
    
    /**
     * INSERT - Add new record to jqGrid
     * @param array $data Record data
     * @param string $endpoint API endpoint (default: empty)
     * @return array Response
     */
    public function insert($data, $endpoint = '') {
        $url = $this->base_url . ($endpoint ? '/' . ltrim($endpoint, '/') : '');
        
        // Clean up data - remove empty id field for inserts
        if (isset($data['id']) && ($data['id'] === '_empty' || $data['id'] === '' || $data['id'] === null)) {
            unset($data['id']);
        }
        
        // Add oper=add for jqGrid compatibility
        if (!isset($data['oper'])) {
            $data['oper'] = 'add';
        }
        
        $ch = $this->init_curl($url, 'POST');
        
        // Form data format (jqGrid standard)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        
        return $this->execute_curl($ch);
    }
    
    /**
     * SELECT/READ - Get records from jqGrid
     * @param array $params Query parameters (page, rows, sidx, sord, etc.)
     * @param string $endpoint API endpoint
     * @return array Response
     */
    public function select($params = array(), $endpoint = '') {
        $url = $this->base_url . ($endpoint ? '/' . ltrim($endpoint, '/') : '');

        // To fetch data (non-search)
        if (!isset($params['_search'])) 
            $params['_search'] = 'false';

        // To skip cache
        if (!isset($params['nd']))
            $params['nd'] = microtime();

        // use correct page var        
        if (isset($params['page'])) {
            $params["jqgrid_page"] = $params["page"];
            unset($params["page"]);
        }

        // Add query parameters
        if (!empty($params)) {
            $s = (strstr($url, "?")) ? "&":"?";
            $url .= $s . http_build_query($params);
        }
        
        $ch = $this->init_curl($url, 'GET');
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));
        
        return $this->execute_curl($ch);
    }
    
    /**
     * UPDATE - Update existing record in jqGrid
     * @param string $id Record ID
     * @param array $data Updated data
     * @param string $endpoint API endpoint
     * @return array Response
     */
    public function update($id, $data, $endpoint = '') {
        $url = $this->base_url . ($endpoint ? '/' . ltrim($endpoint, '/') : '');
        
        // Add ID to data if not present
        if ($id && !isset($data['id'])) {
            $data['id'] = $id;
        }
        
        // Add oper=edit for jqGrid compatibility
        if (!isset($data['oper'])) {
            $data['oper'] = 'edit';
        }
        
        $ch = $this->init_curl($url, 'POST');
        
        // Form data format (jqGrid standard)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        
        return $this->execute_curl($ch);
    }
    
    /**
     * DELETE - Delete record from jqGrid
     * @param string $id Record ID
     * @param string $endpoint API endpoint
     * @return array Response
     */
    public function delete($id, $endpoint = '') {
        $url = $this->base_url . ($endpoint ? '/' . ltrim($endpoint, '/') : '');
        
        // Prepare delete data with oper=del
        $data = array(
            'id' => $id,
            'oper' => 'del'
        );
        
        $ch = $this->init_curl($url, 'POST');
        
        // Form data format (jqGrid standard)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        
        return $this->execute_curl($ch);
    }
    
    /**
     * SEARCH - Search records with filters
     * @param array $filters Search filters
     * @param array $params Additional parameters
     * @param string $endpoint API endpoint
     * @return array Response
     */
    public function search($filters, $params = array(), $endpoint = '') {
    
        $search_params = array_merge($params, array(
            '_search' => 'true',
            'page' => '1',
            'filters' => json_encode($filters)
        ));
        
        return $this->select($search_params, $endpoint);
    }
    
    /**
     * Set timeout values
     * @param int $timeout Request timeout in seconds
     * @param int $connect_timeout Connection timeout in seconds
     */
    public function set_timeout($timeout, $connect_timeout = null) {
        $this->timeout = $timeout;
        if ($connect_timeout !== null) {
            $this->connect_timeout = $connect_timeout;
        }
    }
    
    /**
     * Custom request - For any custom API calls
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @param array $headers Additional headers
     * @return array Response
     */
    public function custom_request($method, $endpoint, $data = array(), $headers = array()) {
        $url = $this->base_url . ($endpoint ? '/' . ltrim($endpoint, '/') : '');
        
        $ch = $this->init_curl($url, strtoupper($method));
        
        if (!empty($data) && in_array(strtoupper($method), array('POST', 'PUT', 'PATCH'))) {
            // Form data format
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $default_headers = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            
            $headers = array_merge($default_headers, $headers);
        }
        
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        return $this->execute_curl($ch);
    }
}

// ============================================================================
// USAGE EXAMPLES
// ============================================================================
// ini_set("display_errors",1);

// Example 1: Initialize API without authentication
// $api = new jqgrid_api('https://domain.com/gridphp/demos/editing/index.php?grid_id=list1');

// Example 2: Initialize API with HTTP Basic Authentication
// $api = new jqgrid_api('https://domain.com/gridphp/demos/editing/index.php?grid_id=list1', 'username', 'password');

// Example 3: INSERT a new record
// $new_record = array(
//     'name' => 'John Doe',
//     'company' => 'Test Co',
//     'gender' => 'Male'
// );
// $result = $api->insert($new_record);

// if ($result['success']) {
//     echo "Record inserted! ID: " . $result['data']['id'];
// } else {
//     echo "Error: " . $result['http_code'] ." - ". $result['response'];
// }

// Example 5: SELECT/READ records with pagination
// $params = array(
//     'page' => 1,
//     'rows' => 10,
//     'sidx' => 'name',
//     'sord' => 'asc'
// );
// $result = $api->select($params);

// if ($result['success']) {
//     print_r($result['data']);
// }

// Example 6: UPDATE a record
// $update_data = array(
//     'name' => 'John Smith',
//     'company' => 'XYZ Solutions',
//     'gender' => 'Male'
// );
// $result = $api->update('94', $update_data);
// if ($result['success']) {
//     echo "Record Updated! ID: " . $result['data']['id'];
// } else {
//     echo "Error: " . $result['http_code'] ." - ". $result['response'];
// }

// Example 8: DELETE a record
// $result = $api->delete('94');
// if ($result['success']) {
//     echo "Record deleted!";
// } else {
//     echo "Error: " . $result['http_code'] ." - ". $result['response'];
// }

// Example 10: SEARCH with filters
// $filters = array(
//     'groupOp' => 'AND',
//     'rules' => array(
//         array('field' => 'name', 'op' => 'cn', 'data' => 'John'),
//         array('field' => 'gender', 'op' => 'eq', 'data' => 'Male')
//     )
// );
// $result = $api->search($filters);
// if ($result['success']) {
//     print_r($result['data']);
// }

// Example 11: SEARCH for specific age range
// $filters = array(
//     'groupOp' => 'AND',
//     'rules' => array(
//         array('field' => 'client_id', 'op' => 'ge', 'data' => '25'),
//         array('field' => 'client_id', 'op' => 'le', 'data' => '35')
//     )
// );
// $result = $api->search($filters);
// if ($result['success']) {
//     print_r($result['data']);
// }

// Example 12: Custom request with Bearer token
// $api = new jqgrid_api('https://domain.com/gridphp/demos/editing/index.php?grid_id=list1');
// $result = $api->custom_request(
//     'POST',
//     '',
//     array('name' => 'Test User', 'company' => 'ABC Solutions', 'gender' => 'Male'),
//     array('Authorization: Bearer your_token_here'),
//     true
// );

// Example 13: Change timeout settings
// $api->set_timeout(60, 20); // 60 seconds timeout, 20 seconds connect timeout

// Example 14: Complete workflow - Insert, Update, Delete
// $api = new jqgrid_api('https://domain.com/gridphp/demos/editing/index.php?grid_id=list1', 'admin', 'password');
//
// Insert new record
// $insert_data = array(
//     'name' => 'Alice Johnson',
//     'company' => 'ABC Solutions',
//     'gender' => 'Female',
// );
// $insert_result = $api->insert($insert_data);

// if ($insert_result['success']) {
//     $new_id = $insert_result['data']['id'];
//     echo "Inserted record with ID: $new_id\n";
    
//     // Update the record
//     $update_data = array(
//         'name' => 'Alice Johnson-Smith',
//         'company' => 'ABC Solutions',
//         'gender' => 'Female'
//     );
//     $update_result = $api->update($new_id, $update_data);
    
//     if ($update_result['success']) {
//         echo "Updated record successfully\n";
//     }
    
//     // Delete the record
//     $delete_result = $api->delete($new_id);
//     if ($delete_result['success']) {
//         echo "Deleted record successfully\n";
//     }
// }