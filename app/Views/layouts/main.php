<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Karnevor Indonesia ">
	<meta name="author" content="Gheav">
	<meta name="keywords" content="Gheav, Bonty, Bonty Cat">
	<link rel="shortcut icon" href="<?= base_url('assets/images/taskbar.png'); ?>" />
	<title>Karnevor Indonesia</title>
	<link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet">
	<link href="<?= base_url('plugins/summernote/summernote-bs4.min.css'); ?>" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body data-theme="light">
	<div class="wrapper">
		<?= $this->include('layouts/sidebar'); ?>
		<div class="main">
			<!-- HEADER: MENU + HEROE SECTION -->
			<?= $this->include('layouts/header'); ?>
			<!-- CONTENT -->
			<main class="content">
				<div class="container-fluid p-0">
					<?= $this->include('common/alerts'); ?>
					<?= $this->renderSection('content'); ?>
				</div>
			</main>
			<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->
			<?= $this->include('layouts/footer'); ?>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="<?= base_url('assets/js/app.js') ?>"></script>
	<script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
	<script src="<?= base_url('plugins/summernote/summernote-bs4.min.js'); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<?= $this->renderSection('javascript'); ?>
	<script>
		$(document).ready(function() {
			$('.datatable').dataTable({
				responsive: true
			});
			$('.summernote').summernote({
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']]
				],
				tabsize: 2,
				height: 210
			});
			$('.select2').select2();
		});
	</script>
</body>

</html>