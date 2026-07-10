<h3>Notifikasi</h3><?php if (isset($notifications)):
    while ($n = mysqli_fetch_assoc($notifications)): ?>
        <div class="alert <?= $n['is_read'] ? 'alert-light' : 'alert-success' ?> border">
            <?= e($n['message']) ?><br><small><?= e($n['created_at']) ?></small>
        </div><?php endwhile; else: ?>
    <div class="alert alert-info">Belum ada notifikasi.</div><?php endif; ?>