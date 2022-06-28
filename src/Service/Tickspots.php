<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Service;

/**
 * Description of Tickspot
 *
 * @author master
 */
class Tickspots {
	
    const BASE_URL = 'https://www.tickspot.com/';
    const API_ACT = '/api/v2';
    const USER_AGENT = 'MyCoolApp (%s)';

    // config data
    private $_token;
    private $_email;
    private $_subscription;

    // last request respones data
    private $_response;
    private $_info;

    /**
     * The API base url for performing screen scraping when necessary.
     * 
     * @var	string
     */
    private $_apiUrl;

    /**
     * Default constructor.
     */
    public function __construct($config = array())
    {
        if (empty($config) || !is_array($config)) {
                throw new Exception('You must provide a TickSpot config array.');
        }

        // store parameters
        if (!isset($config['token']) || !isset($config['email']) || !isset($config['subscription'])) {
                throw new Exception('You must specify a token, email address, and subscription.');
        }

        // set some vars
        $this->_token = $config['token'];
        $this->_email = $config['email'];
        $this->_subscription = $config['subscription'];

        // generate the base url
        $this->_apiUrl = self::BASE_URL . $this->_subscription . self::API_ACT;
    }
    
     /**
     * Return necessary heads for authentication.
     *
     * @access	private
     * @return	array
     */
    private function _getHeaders()
    {
        return array(
            'Authorization: Token token=' . $this->_token,
            'User-Agent: '  . sprintf(self::USER_AGENT, $this->_email)
        );
    }
       
     /**
     * Fire off a POST request.
     *
     * @access	public
     * @param	string	$url
     * @param	mixed	$data
     * @param	string	$referrer
     * @return	mixed
     */
    public function postRequest($method, $headers, $data)
    {
        try {
            $ch = curl_init();
            $url = $this->_apiUrl . '/' . $method . '.json';
            if(!empty($data))
            {
                $url .= '?' . http_build_query($data);
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($ch, CURLOPT_POST, true);
            /*if(!empty($data))
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }*/
            
            if(!empty($headers))
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            // avoid looking suspicious
            curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
            //curl_setopt($ch, CURLOPT_REFERER, $referrer);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

            // retrieve the response
            $this->_response = curl_exec($ch);
            $this->_info = curl_getinfo($ch);

            // close cURL
            curl_close($ch);

            return $this->_response;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Will return a list of all clients and can only be accessed by admins on
     * the subscription.
     *
     * @access	public
     * @return	array
     * @return	mixed
     */
    public function getClients()
    {
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('clients', $headers, null);
    }
    
    /**
     * The users method will return a list of users.
     *
     * @access	public
     * @return	mixed
     */
    public function getUsers()
    {
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('users', $headers, null);
    }

    /**
     * The projects method will return projects filtered by the parameters
     * provided. Admin can see all projects on the subscription, while
     * non-admins can only access the projects they are assigned.
     *
     * @access	public
     * @return	mixed
     */
    public function getProjects()
    {
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('projects', $headers, null);
    }

    /**
     * The projects method will return projects filtered by the parameters
     * provided. Admin can see all projects on the subscription, while
     * non-admins can only access the projects they are assigned.
     *
     * @access	public
     * @return	mixed
     */
    public function getTasks()
    {
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('tasks', $headers, null);
    }
    
    /**
     * The projects method will return projects filtered by the parameters
     * provided. Admin can see all projects on the subscription, while
     * non-admins can only access the projects they are assigned.
     *
     * @access	public
     * @param	int		$project_id
     * @return	mixed
     */
    public function getTasksForProject($project_id)
    {
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('/projects/'.$project_id.'/tasks', $headers, null);
    }

    /**
     * Will return a list of all clients, projects, and tasks that are assigned
     * to the user.
     *
     * @access	public
     * @param	int		$task_id
     * @return	mixed
     */
    public function getUserDetails($task_id)
    {
        // only needs auth params
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('/tasks/'.$task_id, $headers, null);
    }

    /**
     * Will return a list of all entries that meet the provided criteria. Either
     * a start and end date have to be provided or an updated_at time. The
     * entries will be in the start and end date range or they will be after
     * the updated_at time depending on what criteria is provided. Each of the
     * optional parameters will further filter the response.
     *
     * @access	public
     * @param	string	$updated_at
     * @param	string	$start_date
     * @param	string	$end_date
     * @param	int		$project_id
     * @param	int		$task_id
     * @param	int		$user_id
     * @param	string	$user_email
     * @param	int		$client_id
     * @param	bool	$entry_billable
     * @param	bool	$billed
     */
    public function getEntries(
        $updated_at = NULL,
        $start_date = NULL,
        $end_date = NULL,
        $project_id = NULL,
        $task_id = NULL,
        $user_id = NULL,
        $user_email = NULL,
        $client_id = NULL,
        $entry_billable = NULL,
        $billed = NULL)
    {
        $headers = $this->_getHeaders();
         
        // minimal requirements
        if ($updated_at === NULL && ($start_date === NULL || $end_date === NULL)) {
                throw new Exception('You must provide either updated_at or a combination of start_date and end_date.');
        }

        $params = array(
                'project_id' => $project_id,
                'task_id' => $task_id,
                'user_id' => $user_id,
                'user_email' => $user_email,
                'client_id' => $client_id,
                'entry_billable' => $entry_billable,
                'billed' => $billed
        );

        // determine which required params to add
        if ($updated_at !== NULL) {
                $params['updated_at'] = $updated_at;
        } else {
                $params['start_date'] = $start_date;
                $params['end_date'] = $end_date;
        }

        // fire off a post request
        return $this->postRequest('entries', $headers, $params);
    }
    
    /**
     * The projects method will return projects filtered by the parameters
     * provided. Admin can see all projects on the subscription, while
     * non-admins can only access the projects they are assigned.
     *
     * @access	public
     * @param	int		$user_id
     * @return	mixed
     */
    public function getEntriesForUser($user_id, $updated_at)
    {
        $headers = $this->_getHeaders();
        if ($updated_at === NULL) {
                throw new Exception('You must provide either updated_at or a combination of start_date and end_date.');
        }

        // determine which required params to add
        if ($updated_at !== NULL) {
                $params['updated_at'] = $updated_at;
        }

        // fire off a post request
        return $this->postRequest('/users/'.$user_id.'/entries', $headers, $params);
    }

    /**
     * Will return a list of the most recently used tasks. This is useful for
     * generating quick links for a user to select a task they have been using
     * recently.
     *
     * @access	public
     * @return	mixed
     */
    public function getRecentTasks()
    {
        // only needs auth params
        $headers = $this->_getHeaders();

        // fire off a post request
        return $this->postRequest('recent_tasks', $headers, null);
    }

    /**
     * The create_entry method will accept a time entry for a specified task_id
     * and return the created entry along with the task and project stats.
     *
     * @access	public
     * @param	int		$task_id
     * @param	float	$hours
     * @param	string	$date
     * @param	string	$notes
     * @return	mixed
     */
    public function createEntry($task_id, $hours, $date, $notes = NULL)
    {
        $params = array(
                'task_id' => $task_id,
                'hours' => $hours,
                'date' => $date,
                'notes' => $notes
        );
        $params += $this->_getAuthParams();

        // fire off a post request
        return $this->postRequest('create_entry', $params, null);
    }

    /**
     * The update_entry method will allow you to modify attributes of an existing
     * entry. The only required parameter is the id of the entry. Additional
     * parameters must be provided for any attribute that you wish to update.
     * For example, if you are only changing the billed attribute, your post
     * should only include the required parameters and the billed parameter.
     *
     * @access	public
     * @param	int		$id
     * @param	float	$hours
     * @param	string	$date
     * @param	bool	$billed
     * @param	int		$task_id
     * @param	int		$user_id
     * @param	string	$notes
     */
    public function updateEntry($id, $hours = NULL, $date = NULL, $billed = NULL, $task_id = NULL, $user_id = NULL, $notes = NULL)
    {
        $params = array(
                'id' => $task_id,
                'hours' => $hours,
                'date' => $date,
                'billed' => $billed,
                'task_id' => $task_id,
                'user_id' => $user_id,
                'notes' => $notes
        );
        $params += $this->_getAuthParams();

        // fire off a post request
        return $this->postRequest('update_entry', $params, null);
    }

    /**
     * This will return the methods passed into the function that do not require
     * further parameters than email and password.
     * 
     * It is a clear and easy way to return results from the api before passing
     * through any results.
     *
     * @access	public
     * @param	string	$method
     * @link	http://tickspot.com/api/
     */
    public function getRequest($method)
    {
        try {

            $data = $this->_getAuthParams();
            $data = http_build_query($data);

            // generate the GET url
            $url = $this->_apiUrl . '/' . $method . '?' . $data;

            // initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); 
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');

            // avoid looking suspicious
            curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

            // retrieve the response
            $this->_response = curl_exec($ch);
            $this->_info = curl_getinfo($ch);

            // close cURL
            curl_close($ch);

            return $this->_response;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Screen scraper handling to delete all projects.
     * Uses an undocumented API endpoint.
     *
     * @access	public
     * @return	void
     */
    public function deleteAllProjects()
    {
        // retrieve all current projects
        $xml = $this->getProjects();

        // convert returned XML
        $projects = new SimpleXMLElement($xml);

        // perform an actual HTTP login
        $this->authenticate();

        // iterate over projects and delete
        foreach ($projects->project as $project) {
                $deleteUrl = $this->_baseUrl . 'projects/delete_project/' . $project->id;
                $response = $this->postRequest($deleteUrl);
                echo 'Deleted project: ' . $project->name . "<br />\n";
        }

        echo 'Project deletion completed.';
    }

    /**
     * Screen scraper handling to close all projects.
     * Uses an undocumented API endpoint.
     *
     * @access	public
     * @return	void
     */
    public function closeAllProjects()
    {
        // retrieve all current projects
        $xml = $this->getProjects();

        // convert returned XML
        $projects = new SimpleXMLElement($xml);

        // perform an actual HTTP login
        $this->authenticate();

        // iterate over projects and delete
        foreach ($projects->project as $project) {
                $deleteUrl = $this->_baseUrl . 'projects/close_project/' . $project->id;
                $response = $this->postRequest($deleteUrl);
                echo 'Closed project: ' . $project->name . "<br />\n";
        }

        echo 'Project close completed.';
    }

    /**
     * Screen scraper handling to open all projects.
     * Uses an undocumented API endpoint.
     *
     * @access	public
     * @return	void
     */
    public function openAllProjects()
    {
        // retrieve all current projects
        $xml = $this->getProjects();

        // convert returned XML
        $projects = new SimpleXMLElement($xml);

        // perform an actual HTTP login
        $this->authenticate();

        // iterate over projects and delete
        foreach ($projects->project as $project) {
                $deleteUrl = $this->_baseUrl . 'projects/open_project/' . $project->id;
                $response = $this->postRequest($deleteUrl);
                echo 'Opened project: ' . $project->name . "<br />\n";
        }

        echo 'Project open completed.';
    }
}