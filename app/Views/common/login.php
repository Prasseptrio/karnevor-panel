<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Novapos - Point of Sale for Grooming Space Indonesia">
    <meta name="author" content="Gheav">
    <meta name="keywords" content="Gheav, Bonty, Bonty Cat">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png'); ?>" />
    <title>Novapos - Grooming Space Indonesia</title>
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <?= $this->include('common/alerts'); ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="text-center mt-3">
                                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Charles Hall" class="img-fluid" width="70%" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <form action="<?= base_url('GetLogin'); ?>" method="POST">
                                            <div class="my-3 ">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="inputEmail" placeholder="Enter your email" />
                                            </div>
                                            <div class="my-3 ">
                                                <label for="inputBranch">Branch</label>
                                                <div>
                                                    <select name="inputBranch" id="inputBranch" class="form-control form-select form-control-lg text-center">
                                                        <option value="">-- Choose Your Branch --</option>
                                                        <option value="1">-- GS Maguwoharjo --</option>
                                                        <option value="2">-- GS Giwangan --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="inputPassword" placeholder="Enter your password" />
                                            </div>
                                            <div class="d-grid gap-2 mt-3">

                                                <button type="submit" class="btn btn-block btn-dark">Sign in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>