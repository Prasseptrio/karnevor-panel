<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\MenuModel;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers 	= ['cookie', 'date', 'security', 'menu', 'useraccess', 'dateindo'];
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */


	protected $data 	= [];
	protected $session;
	protected $segment;
	protected $db;
	protected $validation;
	protected $encrypter;
	protected $cart;
	protected $userModel;
	protected $menuModel;
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session 		= \Config\Services::session();
		$this->segment 	  	= \Config\Services::request();
		$this->validation 	= \Config\Services::validation();
		$this->encrypter 	= \Config\Services::encrypter();
		$this->cart 		= \Config\Services::cart();
		$this->userModel  	= new UserModel();
		$this->menuModel  	= new MenuModel();
		$user 				= $this->userModel->getUser(username: session()->get('username'));
		$segment 			= $this->request->uri->getSegment(1);
		if ($segment) {
			$subsegment 	= $this->request->uri->getSegment(2);
		} else {
			$subsegment 	= '';
		}
		$this->data			= [
			'segment' 		=> $segment,
			'subsegment' 	=> $subsegment,
			'user' 			=> $user,
			'MenuCategory' 	=> $this->userModel->getAccessMenuCategory(session()->get('role'))
		];
	}
}
