<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Blogs List
            <a href="<?= base_url('blog/form'); ?>" class="btn btn-dark btn-sm float-end">Create New Blog</a>
            <button type="button" class="btn btn-secondary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#blogCategoryForm">
                Blog Category
            </button>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Blog Category</th>
                        <th>Blog Title</th>
                        <th>Blog Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($BlogPosts as $blogposts) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $blogposts['name_category'] ?></td>
                            <td><?= $blogposts['blog_title'] ?> </td>
                            <td><?= $blogposts['blog_author'] ?> </td>
                            <td>
                                <a href="<?= base_url('blog?id=' . $blogposts['blog_id']); ?>" class="btn btn-secondary btn-sm">Details</a>
                                <form action="<?= base_url('blog/delete/' . $blogposts['blog_id']); ?>" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-outline-dark btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="blogCategoryForm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Blog Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('blog/create-category'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="inputCategoryName" class="form-control" placeholder="Category Name" aria-label="Product Category" aria-describedby="button-addon2">
                        <button class="btn btn-dark" type="submit" id="saveBlogCategory">Add</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Name Category</th>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($BlogCategory as $blogcategory) : ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= $blogcategory['name_category'] ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>