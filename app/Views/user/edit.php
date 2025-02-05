<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Edit Profile</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <form action="<?= base_url() ?>user/edit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">

                            <input type="hidden" name="last-image" value="<?= $user['image'] ?>">
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="email" name="email" value="<?= $user['email'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= (session('errors.name')) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name', $user['name']) ?>">
                                    <div class="invalid-feedback"><?= session('errors.name') ?></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-2">Picture</div>
                                <div class="col-sm-10 row">
                                    <div class="col-sm-3">
                                        <img src= "<?= base_url() ?>img/photos/<?= $user['image'] ?>" class="img-thumbnail img-preview">
                                    </div>
                                    <div class="col-sm-9">
                                        <label for="image" class="form-label"></label>
                                        <input class="form-control <?= (session('errors.image')) ? 'is-invalid' : '' ?>"" type="file" id="image" name="image" onchange="previewImg()">
                                            <div class="invalid-feedback"><?= session('errors.image') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
	function previewImg(){
		const image = document.querySelector('#image');
		const imgPreview = document.querySelector('.img-preview');
	
		const imageFile = new FileReader();
		imageFile.readAsDataURL(image.files[0]);
	
		imageFile.onload = function(e) {
			imgPreview.src = e.target.result;
		}
	}

</script>

<?php $this->endSection() ?>