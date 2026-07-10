<h3>Keranjang Belanja</h3><?php if (empty($cart)): ?>
    <div class="alert alert-info">Keranjang kosong.</div><?php else: ?>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php $total = 0;
            foreach ($cart as $i):
                $sub = $i['price'] * $i['quantity'];
                $total += $sub; ?>
                    <tr>
                        <td><?= e($i['name']) ?></td>
                        <td><?= money($i['price']) ?></td>
                        <td><input class="form-control qty-input" style="width:90px" data-id="<?= $i['id'] ?>"
                                value="<?= $i['quantity'] ?>" type="number" min="1"></td>
                        <td id="subtotal-<?= $i['id'] ?>"><?= money($sub) ?></td>
                        <td><a class="btn btn-sm btn-danger" href="index.php?page=remove-cart&id=<?= $i['id'] ?>">Hapus</a></td>
                    </tr><?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <h4>Total: <span id="cart-total"><?= money($total) ?></span></h4><a class="btn btn-success"
        href="index.php?page=checkout">Checkout</a><?php endif; ?>