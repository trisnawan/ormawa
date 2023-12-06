<div>
    <input type="hidden" name="id" value="<?= $member['id'] ?>">
    <div class="text-center mb-3">
        <img src="<?= $user['avatar'] ?>" class="rounded-circle" width="120px" height="120px">
        <div class="fw-bold"><?= $user['full_name'] ?></div>
    </div>
    <div>
        <div class="mb-3">
            <label class="form-label">Alamat email</label>
            <input type="text" value="<?= $user['email'] ?>" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor telepon</label>
            <input type="text" value="<?= $user['phone'] ?>" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis kelamin</label>
            <input type="text" value="<?= ucwords($user['gender']) ?? '-' ?>" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan organisasi</label>
            <input type="text" name="position" value="<?= $member['position'] ?>" class="form-control" required>
        </div>
    </div>
</div>