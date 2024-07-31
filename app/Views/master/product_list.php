<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Products List
            <button data-bs-toggle="modal" data-bs-target="#productForm" class="btn btn-dark btn-sm float-end">Create New Product</button>
            <button type="button" class="btn btn-secondary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#productCategoryForm">
                Product Category
            </button>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0 dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($Products as $product) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $product['product_name'] ?> </td>
                            <td>Rp. <?= number_format($product['price']); ?> </td>
                            <td><?= $product['product_stock'] ?> </td>
                            <td>
                                <a href="<?= base_url('products?id=' . $product['product_id']); ?> " class="btn btn-outline-secondary btn-sm">Delete</a>
                                <a href="<?= base_url('products?id=' . $product['product_id']); ?> " class="btn btn-outline-secondary btn-sm">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="productCategoryForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Category List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('products/createProductCategory'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="inputProductCategoryName" class="form-control" placeholder="Category Name" aria-label="Product Category" aria-describedby="button-addon2">
                        <button class="btn btn-dark" type="submit" id="saveProductCategory">Add</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Category</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($Categories as $category) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $category['product_category_name']; ?></td>
                                <td>
                                    <form action="<?= base_url('products/deleteProductCategory/' . $category['product_category_id']); ?>" method="post" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('products/createProduct'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group my-3 row">
                        <label for="inputProductCategory" class="col-sm-3">Product Category</label>
                        <div class="col-sm-9">
                            <select name="inputProductCategory" id="inputProductCategory" class="form-select">
                                <option value="">-- Choose Product Category --</option>
                                <?php foreach ($Categories as $category) : ?>
                                    <option value="<?= $category['product_category_id']; ?>"><?= $category['product_category_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-3 row">
                        <label for="inputProductName" class="col-sm-3">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputProductName" id="inputProductName" required>
                        </div>
                    </div>
                    <div class="form-group my-3 row">
                        <label for="inputProductName" class="col-sm-3">Product Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputPrice" id="inputPrice" required>
                        </div>
                    </div>
                    <div class="form-group my-3 row">
                        <label for="inputProductName" class="col-sm-3">Product Initial Stock</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputProductName" id="inputProductName" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>