<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> Form Menu </h1>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-0"> Products Form </h3>
                <form action="<?= base_url('products/updateProduct'); ?>" method="post" class="d-inline" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="inputProductsID" id="inputProductsID" value="<?= ($product) ? $product['product_id'] : ''; ?>">
                    <div class="form-group my-3 row">
                        <label for="inputProductCategory" class="col-sm-3">Product Category</label>
                        <div class="col-sm-9">
                            <select name="inputProductCategory" id="inputProductCategory" class="form-select">
                                <option value="">-- Choose Product Category --</option>
                                <?php foreach ($Categories as $category) : ?>
                                    <option value="<?= $category['product_category_id']; ?>" <?= ($product) ? ($product['product_category'] == $category['product_category_id']) ? 'selected' : '' : ''; ?>><?= $category['product_category_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-3 row">
                        <label for="inputProductName" class="col-sm-3">Product Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputProductName" id="inputProductName" value="<?= ($product) ? $product['product_name'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group my-3 row">
                        <label for="inputProductPrice" class="col-sm-3">Selling Price</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" name="inputProductPrice" id="inputProductPrice" value="<?= ($product) ? $product['price'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group  my-3 row">
                        <label for="inputProductImage" class="col-sm-3">Product Image</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="inputProductImage" id="inputProductImage" required>
                        </div>
                    </div>
                    <div class="form-group  my-3 row">
                        <label for="inputProductDescription" class="col-sm-3">Product Description</label>
                        <div class="col-sm-9">
                            <textarea name="inputProductDescription" id="inputProductDescription" class="form-control" cols="3" rows="10"><?= ($product) ? $product['product_description'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn btn-dark" type="submit">Update Data</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <h3 class="card-title">Product Information</h3>
                <table class="table">
                    <tr>
                        <th>Product Stock</th>
                        <td><?= $product['product_stock']; ?> Pcs</td>
                    </tr>
                    <tr>
                        <th>Last Purchase Price</th>
                        <td>Rp. <?= number_format(0); ?> </td>
                    </tr>
                    <tr>
                        <th>Cost of Goods Sold</th>
                        <td>Rp. <?= number_format($product['price']); ?> </td>
                    </tr>
                </table>
                <div class="text-center mb-2">
                    <img src="<?= 'http://localhost:8080/' . $product['product_image']; ?>' ?>" alt="product image">
                </div>
                <form action="<?= base_url('products/deleteProduct/' . $product['product_id']); ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-secondary">DELETE PRODUCT </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>