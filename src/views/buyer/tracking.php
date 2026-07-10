<h3>Tracking Pesanan</h3><?php if (!$order): ?>
    <div class="alert alert-warning">Pesanan tidak ditemukan.</div>
<?php else: ?>    <?php $steps = ['Menunggu Pembayaran', 'Pembayaran Dikonfirmasi', 'Sedang Diproses', 'Sedang Dikirim', 'Pesanan Diterima', 'Selesai'];
      $current = array_search($order['status'], $steps);
      if ($current === false)
          $current = 0;
      $percent = ($current) / (count($steps) - 1) * 100; ?>
    <div class="card">
        <div class="card-body">
            <h5><?= e($order['order_number']) ?></h5>
            <p>Status saat ini: <b><?= e($order['status']) ?></b></p>
            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="width: <?= $percent ?>%"></div>
            </div>
            <div class="timeline"><?php foreach ($steps as $idx => $s): ?>
                    <div class="timeline-item <?= $idx <= $current ? 'active' : '' ?>"><span></span><?= e($s) ?></div><?php endforeach; ?>
            </div>
        </div>
    </div><?php endif; ?>