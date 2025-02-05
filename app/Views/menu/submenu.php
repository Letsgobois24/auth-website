<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Submenu Management</h1>

        <?= session()->getFlashdata('message') ?: '' ?>

        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-header">
                        <a href="" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addSubmenuModal">New Submenu</a>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Title</th>
                                <th class="d-none d-xl-table-cell">Url</th>
                                <th class="d-none d-xl-table-cell">Icon</th>
                                <th class="d-none d-xl-table-cell">Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($all_submenu as $sm) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $sm['menu'] ?></td>
                                    <td><?= $sm['title'] ?></td>
                                    <td class="d-none d-xl-table-cell"><?= $sm['url'] ?></td>
                                    <td class="d-none d-xl-table-cell"><?= $sm['icon'] ?></td>
                                    <td class="d-none d-xl-table-cell"><?= ($sm['is_active'] == 1) ? 'Active' : 'Nonactive' ?></td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editSubmenu" 
                                        data-id="<?= $sm['id']?>" data-submenu="<?= $sm['title'] ?>" data-menu="<?= $sm['menu'] ?>"
                                        data-url="<?= $sm['url'] ?>" data-icon="<?= $sm['icon'] ?>" data-active="<?= $sm['is_active'] ?>" data-menuId = "<?= $sm['menu_id'] ?>" >
                                            Edit
                                        </a>
                                        <a href="" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSubmenu" 
                                        data-submenu="<?= $sm['title'] ?>" data-id="<?= $sm['id'] ?>">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- addSubmenuModal -->
<div class="modal fade" id="addSubmenuModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Submenu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Insert submenu title">
                    
                    <div class="input-group mt-3">
                        <label class="input-group-text" for="menu_id">Menu</label>
                        <select class="form-select" id="menu_id" name="menu_id">
                            <?php foreach ($all_menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="input-group mt-3">
                        <label class="input-group-text" id="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Insert submenu url">
                    </div>
                    <div class="input-group mt-3">
                        <label class="input-group-text" id="icon">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Insert submenu icon">
                    </div>

                    <div class="input-group mt-3">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <span class="form-check-label">Active?</span>
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- editSubmenuModal -->
<div class="modal fade" id="editSubmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Submenu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="input-group mt-3">
                        <label class="input-group-text" for="menu">Submenu</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Insert submenu title">
                    </div>
                    
                    <div class="input-group mt-3">
                        <label class="input-group-text" for="menu_id">Menu</label>
                        <select class="form-select" id="menu_id" name="menu_id">
                            <?php foreach ($all_menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="input-group mt-3">
                        <label class="input-group-text" id="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Insert submenu url">
                    </div>
                    <div class="input-group mt-3">
                        <label class="input-group-text" id="icon">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Insert submenu icon">
                    </div>

                    <div class="input-group mt-3">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <span class="form-check-label">Active?</span>
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- deleteMenu Modal -->
<div class="modal fade" id="deleteSubmenu" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete <span id="submenuName"></span> submenu?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="post" id="deleteForm" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const editSubmenu = document.getElementById('editSubmenu');
    editSubmenu.addEventListener('show.bs.modal', function(event){
        const form = editSubmenu.getElementsByTagName('form')[0];
        const button = event.relatedTarget;
        const input = form.querySelectorAll('.input-group input, .input-group select');

        input[0].value = button.getAttribute('data-submenu');
        
        const select = input[1].querySelectorAll('option');
        const menuId = button.getAttribute('data-menuId');

        select.forEach(function(option){
            if (option.value == menuId){
                option.selected = true;
            }
        });

        input[2].value = button.getAttribute('data-url');
        input[3].value = button.getAttribute('data-icon');

        const is_active = button.getAttribute('data-active');
        if (is_active == 1) {
            input[4].checked = true;
        } else {
            input[4].checked = false;
        }

        const submenuId = button.getAttribute('data-id');
        form.action = '<?= base_url() ?>menu/submenu/' + submenuId;
        
    });
    
    const deleteSubmenu = document.getElementById('deleteSubmenu');
    deleteSubmenu.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const submenuName = button.getAttribute('data-submenu');
        const submenuId = button.getAttribute('data-id');
        
        const modalBodySpan = deleteSubmenu.querySelector('.modal-body #submenuName');
        const deleteForm = deleteSubmenu.querySelector('.modal-footer #deleteForm');
        
        modalBodySpan.textContent = submenuName;
        deleteForm.action = '<?= base_url() ?>menu/submenu/delete/' + submenuId;
    });
</script>

<?php $this->endSection() ?>