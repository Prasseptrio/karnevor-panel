<?php

namespace App\Controllers;



class Welcome extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		if (session()->get('isLoggedIn') == TRUE) {
			return redirect()->to(base_url('home'));
		}
		if (!$this->validate(['inputEmail'  => 'required'], ['inputBranch'  => 'required'])) {
			return view('common/login');
		} elseif ($this->request->getVar('inputBranch') == "") {
			return view('common/login');
		} else {
			$inputEmail 		= htmlspecialchars($this->request->getVar('inputEmail'));
			$inputPassword 		= htmlspecialchars($this->request->getVar('inputPassword'));
			$user 				= $this->userModel->getUser(username: $inputEmail);
			if ($user) {
				$password		= $user['password'];
				$verify = password_verify($inputPassword, $password);
				if ($verify) {
					session()->set([
						'username'		=> $user['username'],
						'role'			=> $user['role'],
						'branch'		=> $this->request->getVar('inputBranch'),
						'isLoggedIn' 	=> TRUE
					]);
					if ($user['role'] < 3) {
						return redirect()->to(base_url('home'));
					} else {
						return redirect()->to(base_url('poservice'));
					}
				} else {
					session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong !</b> ');
					return redirect()->to(base_url());
				}
			} else {
				session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong!</b> ');
				return redirect()->to(base_url());
			}
		}
	}
	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('/'));
	}

	public function forbiddenPage()
	{
		$data = array_merge($this->data, [
			'title'         => 'Forbidden Page'
		]);
		return view('common/forbidden', $data);
	}
	public function register()
	{
		return view('common/register');
	}
	public function registration()
	{
		if (!$this->validate([
			'inputEmail' 		=> ['label' => 'Email', 'rules' => 'is_unique[users.username]'],
			'inputPassword' 	=> ['label' => 'Password', 'rules' => 'required'],
			'inputPassword2' 	=> ['label' => 'Password Confirmation', 'rules' => 'matches[inputPassword]'],
		])) {
			$data = array_merge($this->data, [
				'title'         => 'Register Page',
			]);

			session()->setFlashdata('notif_error', $this->validation->getError('inputPassword2') . ' ' . $this->validation->getError('inputEmail'));
			return view('common/register', $data);
		} else {
			$inputFullname 		= htmlspecialchars($this->request->getVar('inputFullname'));
			$inputEmail 		= htmlspecialchars($this->request->getVar('inputEmail'));
			$inputPassword 		= htmlspecialchars($this->request->getVar('inputPassword'));
			$dataUser			= [
				'inputFullname' => $inputFullname,
				'inputUsername' => $inputEmail,
				'inputPassword' => $inputPassword,
				'inputRole' 	=> 1
			];
			$registration		= $this->userModel->createUser($dataUser);
			session()->setFlashdata('notif_success', '<b>Registration Successfully!</b> Please login with your account.');
			return view('common/login');
		}
	}
}
