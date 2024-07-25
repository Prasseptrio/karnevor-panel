<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card text-left">
    <img class="card-img-top" src="https://cdn.groomingspace.id/images/<?= $blog['blog_header_image'] ?>" alt="<?= $blog['blog_title']; ?>">
    <div class="card-body">
        <h1 class="card-title h1"><?= $blog['blog_title']; ?></h1>
        <?= $blog['blog_content']; ?>
    </div>
</div>

<?= $this->endSection(); ?>