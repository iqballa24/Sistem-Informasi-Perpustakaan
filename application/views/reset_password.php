<div class="row justify-content-center">
    <div class="card o-hidden border-0 shadow-lg col-md-8 p-4">
        <div class="card-body">
            <h3 class="mr-auto">
                <i class="fas fa-key"></i>
                Reset password
            </h3>
            <hr>
            <form class="user m-4" method="post" action="<?php echo site_url('petugas/reset/'); ?>">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="password_lama" value="<?= set_value('password_lama'); ?>" class="form-control form-control-user" placeholder="Masukan password yang lama .. ">
                    <?= form_error('password_lama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password_baru" value="<?= set_value('password_baru'); ?>" class="form-control form-control-user" placeholder="Masukan password yang baru ..">
                    <?= form_error('password_baru', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div>
                    <label>Confirm New Password</label>
                    <input type="password" name="password_baru_ulangi" value="<?= set_value('password_baru_ulangi'); ?>" class="form-control form-control-user" placeholder="Ulangi password yang baru ..">
                    <?= form_error('password_baru_ulangi', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <div>&nbsp;</div>
                    <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const flashdata = $('.flash-data').data('tempdata');
        // console.log(flashdata);
        if (flashdata) {
            Swal.fire({
                title: 'Success',
                text: flashdata,
                icon: 'success'
            });
        }
    })
</script>