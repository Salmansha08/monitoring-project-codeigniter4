<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4"><?= esc($title) ?></h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Product Category</li>
      </ol>
      <div class="card mb-4">
        <div class="card-body">
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Product Category
            </div>
            <div class="card-body">
              <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add Category
              </button>

              <?php if (session('success')) : ?>
                <div class="alert alert-success" role="alert">
                  <?= session('success') ?>
                </div>
              <?php endif ?>

              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Category Name</th>
                    <th>Input Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($categoryList as $category) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= esc($category->categoryName) ?></td>
                      <td><?= date('Y-m-d H:i:s', strtotime($category->createdAt)) ?></td>
                      <td width="15%" class="text-center">

                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $category->categoryId ?>"><i class='fas fa-edit'></i>
                          Edit</button>

                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $category->categoryId ?>"><i class='fas fa-trash-alt'></i>
                          Delete</button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal Add -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-plus"></i> Add Product Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="<?= site_url('category/add') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="categoryName" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="categoryName" name="categoryName" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary btn-sm">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <?php foreach ($categoryList as $category) : ?>
    <div class="modal fade" id="editModal<?= $category->categoryId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Product Category</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?= site_url('category/edit/' . $category->categoryId) ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="PUT">
              <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" value="<?= esc($category->categoryName) ?>" required />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning btn-sm">Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>

  <!-- Modal Delete -->
  <?php foreach ($categoryList as $category) : ?>
    <div class="modal fade" id="deleteModal<?= $category->categoryId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-trash"></i> Delete Product Category</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?= site_url('category/delete/' . $category->categoryId) ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="DELETE">
              <p>Are you sure you want to delete category: <b><?= esc($category->categoryName) ?></b>?</p>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>

  <?= $this->endSection() ?>