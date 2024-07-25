<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> Form Menu </h1>
<div class="card">
    <div class="card-body">
        <form action="<?= base_url('blog/create'); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <input type="hidden" class="form-control" name="inputPostId" id="inputPostId" required>
                    <div class="form-group mb-3">
                        <label for="inputBlogCategory" class="mb-1">Blog Category</label>
                        <select name="inputBlogCategory" id="inputBlogCategory" class="form-select">
                            <option value="">-- Choose Category --</option>
                            <?php foreach ($BlogCategory as $category) : ?>
                                <option value="<?= $category['blog_category_id']; ?>"><?= $category['name_category']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputBlogTitle" class="mb-1">Blog Title</label>
                        <input type="text" class="form-control" name="inputBlogTitle" id="inputBlogTitle" required>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputBlogStatus" class="mb-1">Blog Status</label>
                        <select name="inputBlogStatus" id="inputBlogStatus" class="form-control" required>
                            <option value="">-- Choose Status --</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <label for="inputBlogHeaderImage" class="mb-1">Blog Header Image</label>
                        <input type="file" class="form-control" name="inputBlogHeaderImage" id="inputBlogHeaderImage">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputBlogContent">Blog Content</label>
                        <textarea name="inputBlogContent" id="inputBlogContent" cols="30" rows="20" class="form-control summernote"></textarea>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-dark" type="submit">Save Data</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>