<?php

namespace App\Controllers\Website;

use App\Models\WebsiteModel;
use App\Controllers\BaseController;

class Blogs extends BaseController
{
	protected $WebsiteModel;
	function __construct()
	{
		$this->WebsiteModel = new WebsiteModel();
	}

	public function index()
	{
		$blogID = $this->request->getGet('id');
		if ($blogID) {
			$data = array_merge($this->data, [
				'title'        => 'Blogs',
				'BlogCategory' => $this->WebsiteModel->getBlogCategory(),
				'blog'    	   => $this->WebsiteModel->getBlogPosts($blogID)
			]);
			return view('website/blog_detail', $data);
		}
		$data = array_merge($this->data, [
			'title'        => 'Blogs',
			'BlogCategory' => $this->WebsiteModel->getBlogCategory(),
			'BlogPosts'    => $this->WebsiteModel->getBlogPosts()
		]);
		return view('website/blog_list', $data);
	}
	public function form()
	{
		$data = array_merge($this->data, [
			'title'         => 'Blogs',
			'BlogCategory' 	=> $this->WebsiteModel->getBlogCategory(),
		]);
		return view('website/blog_form', $data);
	}

	public function createBlogCategory()
	{
		$createBlogCategory = $this->WebsiteModel->createBlogCategory($this->request->getPost(null));
		if ($createBlogCategory) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Blog Category</b>');
			return redirect()->to(base_url('blog'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Blog Category</b>');
			return redirect()->to(base_url('blog'));
		}
	}

	public function deleteBlogCategory($BlogCategoryID)
	{
		if (!$BlogCategoryID) {
			return redirect()->to(base_url('blog'));
		}
		$deleteBlogCategory = $this->WebsiteModel->deleteBlogCategory($BlogCategoryID);
		if ($deleteBlogCategory) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Blog Category</b>');
			return redirect()->to(base_url('blog'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Blog Category</b>');
			return redirect()->to(base_url('blog'));
		}
	}
	public function createBlogPosts()
	{
		$headerImage = $this->request->getFile('inputBlogHeaderImage');
		if (!$headerImage->hasMoved()) {
			$imageName 		= $headerImage->getRandomName();
			$headerImage->move('../../cdn/images', $imageName);
			$createBlogPosts = $this->WebsiteModel->createBlogPosts($this->request->getPost(null), $imageName);
			if ($createBlogPosts) {
				session()->setFlashdata('notif_success', '<b>Successfully added new Blog Posts</b>');
				return redirect()->to(base_url('blog'));
			} else {
				session()->setFlashdata('notif_error', '<b>Failed to add new Blog Posts</b>');
				return redirect()->to(base_url('blog'));
			}
		} else {
			session()->setFlashdata('notif_error', '<b>The file has already been moved.</b>');
			return redirect()->to(base_url('products'));
		}
	}
	public function updateBlogPosts()
	{
		$updateBlogPosts = $this->WebsiteModel->updateBlogPosts($this->request->getPost(null));
		if ($updateBlogPosts) {
			session()->setFlashdata('notif_success', '<b>Successfully update Blog Posts</b>');
			return redirect()->to(base_url('blog'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update Blog Posts</b>');
			return redirect()->to(base_url('blog'));
		}
	}
	public function deleteBlogPosts($BlogPostsID)
	{
		if (!$BlogPostsID) {
			return redirect()->to(base_url('blog'));
		}
		$deleteBlogPosts = $this->WebsiteModel->deleteBlogPosts($BlogPostsID);
		if ($deleteBlogPosts) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Blog Posts</b>');
			return redirect()->to(base_url('blog'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Blog Posts</b>');
			return redirect()->to(base_url('blog'));
		}
	}
}
