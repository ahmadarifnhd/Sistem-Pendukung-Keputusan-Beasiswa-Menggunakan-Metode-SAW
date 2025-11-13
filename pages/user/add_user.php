<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
    </div>
    <form action="index.php?page=proses_add_user" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php?page=list_user" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>