<h3>Kelola Kategori</h3>
<form class="row g-2 mb-3" method="post">
    <div class="col-md-4"><input class="form-control" name="name" placeholder="Nama kategori"></div>
    <div class="col-md-6"><input class="form-control" name="description" placeholder="Deskripsi"></div>
    <div class="col-md-2"><button class="btn btn-success w-100">Tambah</button></div>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody><?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <tr>
                <td><?= e($c['name']) ?></td>
                <td><?= e($c['description']) ?></td>
            </tr><?php endwhile; ?>
    </tbody>
</table>