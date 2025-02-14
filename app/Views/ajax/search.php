<div class="card flex-fill">
    <table class="table table-hover my-0">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th class="d-none d-xl-table-cell">Email</th>
                <th>Role</th>
                <th>Active</th>
                <th class="d-none d-xl-table-cell">Created At</th>
                <th class="d-none d-xl-table-cell">Updated At</th>
            </tr>
        </thead>
        <?php $i = $currentPage * $maxRows - 1 ?>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $user['name'] ?></td>
                    <td class="d-none d-xl-table-cell"><?= $user['email'] ?></td>
                    <td>
                        <select class="form-select role-select" id="role_id" name="role_id" data-id="<?= $user['id'] ?>">
                            <?php foreach ($roles as $role) : ?>
                                <option <?= selected_option($role['role'], $user['role']) ?> value="<?= $role['id'] ?>">
                                    <?= $role['role'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </td>
                    <td>
                        <input class="form-check-input" type="checkbox" value="1" <?= ($user['is_active'] == 1) ? 'checked' : ''  ?> data-id="<?= $user['id'] ?>">
                    </td>
                    <td class="d-none d-xl-table-cell"><?= time_parsing($user['created_at']) ?></td>
                    <td class="d-none d-xl-table-cell"><?= time_parsing($user['updated_at']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?= $pager->links('user', 'user_pagination') ?>
</div>