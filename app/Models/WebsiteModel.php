<?php

namespace App\Models;

use CodeIgniter\Model;

class WebsiteModel extends Model
{
    public function getBlogCategory($BlogCategoryID = false)
    {
        if ($BlogCategoryID) {
            return $this->db->table('blog_category')
                ->where(['blog_category.id' => $BlogCategoryID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('blog_category')
                ->get()->getResultArray();
        }
    }

    public function createBlogCategory($dataBlogCategory)
    {
        return $this->db->table('blog_category')->insert([
            'name_category' => $dataBlogCategory['inputCategoryName'],
        ]);
    }


    public function updateBlogCategory($dataBlogCategory)
    {
        return $this->db->table('blog_category')->update([
            'name_category' => $dataBlogCategory['inputCategoryName'],
        ], ['id' => $dataBlogCategory['inputBlogCategoryID']]);
    }

    public function deleteBlogCategory($BlogCategoryID)
    {
        return $this->db->table('blog_category')->delete(['id' => $BlogCategoryID]);
    }

    public function getBlogPosts($BlogPostsID = false)
    {
        if ($BlogPostsID) {
            return $this->db->table('blog_posts')
                ->join('blog_category', 'blog_posts.blog_category = blog_category.blog_category_id')
                ->where(['blog_posts.blog_id' => $BlogPostsID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('blog_posts')
                ->join('blog_category', 'blog_posts.blog_category = blog_category.blog_category_id')
                ->get()->getResultArray();
        }
    }
    public function createBlogPosts($dataBlogPosts, $headerImage)
    {
        return $this->db->table('blog_posts')->insert([
            'blog_category'         => $dataBlogPosts['inputBlogCategory'],
            'blog_title'            => $dataBlogPosts['inputBlogTitle'],
            'blog_content'          => $dataBlogPosts['inputBlogContent'],
            'blog_author'           => 'Admin',
            'blog_status'           => $dataBlogPosts['inputBlogStatus'],
            'blog_slug'             => url_title($dataBlogPosts['inputBlogTitle']),
            'blog_header_image'     => $headerImage,
            'created_at'            => time(),
        ]);
    }
    public function updateBlogPosts($dataBlogPosts)
    {
        return $this->db->table('blog_posts')->update([
            'blog_category'         => $dataBlogPosts['inputBlogCategory'],
            'blog_title'            => $dataBlogPosts['inputBlogTitle'],
            'blog_content'          => $dataBlogPosts['inputBlogContent'],
            'blog_status'           => $dataBlogPosts['inputBlogStatus'],
            'blog_slug'             => $dataBlogPosts['inputBlogSlug'],
            'blog_header_image'     => $dataBlogPosts['inputBlogHeaderImage'],
            'updated_at'            => time(),
        ], ['id' => $dataBlogPosts['inputBlogPostsID']]);
    }

    public function deleteBlogPosts($BlogPostsID)
    {
        return $this->db->table('blog_posts')->delete(['blog_id' => $BlogPostsID]);
    }
}
