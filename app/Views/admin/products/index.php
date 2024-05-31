<?= $this->extend('admin/layout/template') ?>

<?= $this->section('content') ?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4"><?= esc($title) ?></h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Product List</li>
      </ol>
      <div class="card mb-4">
        <div class="card-body">
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Product List
            </div>
            <div class="card-body">
              <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add Product
              </button>

              <!-- Alert Success -->
              <?php if (session('success')) : ?>
                <div class="alert alert-success" role="alert">
                  <?= session('success') ?>
                </div>
              <?php endif ?>

              <!-- Alert Error -->
              <?php if (session('error')) : ?>
                <div class="alert alert-danger" role="alert">
                  <?= session('error') ?>
                </div>
              <?php endif ?>

              <!-- Table -->
              <table id="datatablesSimple" class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Input Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($productList as $product) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= esc($product->productName) ?></td>
                      <td><?= esc($product->categorySlug) ?></td>
                      <td><?= date('Y-m-d H:i:s', strtotime($product->createdAt)) ?></td>
                      <td width="15%" class="text-center">
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $product->productId ?>"><i class='fas fa-info-circle'></i>
                          Detail</button>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $product->productId ?>"><i class='fas fa-edit'></i> Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $product->productId ?>"><i class='fas fa-trash-alt'></i>
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
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-plus"></i> Add Product</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="<?= site_url('product/add') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <!-- Product Name -->
            <div class="mb-3">
              <label for="productName" class="form-label">Product Name</label>
              <input type="text" class="form-control <?= $validation->hasError('productName') ? 'is-invalid' : null ?>" id="productName" name="productName" required />
              <?php if ($validation->getError('productName')) : ?>
                <div class='invalid-feedback'>
                  <?= $validation->getError('productName') ?>
                </div>
              <?php endif ?>
            </div>
            <!-- Category -->
            <div class="mb-3">
              <label for="categorySlug" class="form-label">Category</label>
              <select class="form-control <?= $validation->hasError('categorySlug') ? 'is-invalid' : null ?>" id="categorySlug" name="categorySlug" required>
                <option hidden>-- Select --</option>
                <?php foreach ($category as $cat) : ?>
                  <option value="<?= esc($cat->categorySlug) ?>"><?= esc($cat->categoryName) ?></option>
                <?php endforeach ?>
              </select>
              <?php if ($validation->getError('categorySlug')) : ?>
                <div class='invalid-feedback'>
                  <?= $error = $validation->getError('categorySlug') ?>
                </div>
              <?php endif ?>
            </div>
            <!-- Description -->
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea id="editor" name="description" class="form-control <?= $validation->hasError('description') ? 'is-invalid' : null ?>" rows="7" required></textarea>
              <?php if ($validation->getError('description')) : ?>
                <div class='invalid-feedback'>
                  <?= $error = $validation->getError('description') ?>
                </div>
              <?php endif ?>
            </div>
            <!-- Image -->
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input class="form-control <?= $validation->hasError('image') ? 'is-invalid' : null ?>" onchange="previewImage()" type="file" id="image" name="image" accept="image/*" enctype="multipart/form-data" required />
              <?php if ($validation->getError('image')) : ?>
                <div class='invalid-feedback'>
                  <?= $error = $validation->getError('image') ?>
                </div>
              <?php endif ?>
              <div class="d-flex mt-3 justify-content-center">
                <img id="preview" class="preview-img img-fluid" width="200" />
              </div>
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
  <?php foreach ($productList as $product) : ?>
    <div class="modal fade" id="editModal<?= $product->productId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="<?= site_url('product/edit/' . $product->productId) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="oldImage" value="<?= $product->productImage ?>">
              <!-- Product Name -->
              <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" value="<?= esc($product->productName) ?>" required>
              </div>
              <!-- Category -->
              <div class="mb-3">
                <label for="categorySlug" class="form-label">Category</label>
                <select class="form-select" id="categorySlug" name="categorySlug" required>
                  <?php foreach ($category as $cat) : ?>
                    <option value="<?= esc($cat->categorySlug) ?>" <?= $cat->categorySlug == $product->categorySlug ? 'selected' : '' ?>>
                      <?= esc($cat->categoryName) ?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>
              <!-- Description -->
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="editor" name="description" class="form-control" rows="7" required><?= esc($product->description) ?></textarea>
              </div>
              <!-- Image -->
              <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <div class="d-flex my-3 justify-content-center">
                  <img id="preview" src="<?= base_url('asset-admin/img/' . $product->productImage) ?>" class="preview-img img-fluid" width="200" />
                </div>
                <input class="form-control <?= $validation->hasError('image') ? 'is-invalid' : null ?>" onchange="previewImage()" type="file" id="image" name="image" accept="image/*" />
                <?php if ($validation->hasError('image')) : ?>
                  <div class='invalid-feedback'>
                    <?= $error = $validation->getError('image') ?>
                  </div>
                <?php endif ?>
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
  <?php foreach ($productList as $product) : ?>
    <div class="modal fade" id="deleteModal<?= $product->productId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-trash"></i> Delete Product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?= site_url('product/delete/' . $product->productId) ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="DELETE">
              <p>Are you sure you want to delete product: <b><?= esc($product->productName) ?></b>?</p>
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

  <?= $this->section('script') ?>
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      document.querySelectorAll('textarea').forEach((textarea) => {
        ClassicEditor
          .create(textarea, {
            toolbar: ['undo', 'redo', '|', 'bold', 'italic', '|', 'numberedList', 'bulletedList', 'blockQuote']
          })
          .catch(error => {
            console.error(error);
          });
      });
    });
  </script>

  <!-- Preview Image -->
  <script>
    function previewImage() {
      document.querySelectorAll('input[type="file"]').forEach((input) => {
        input.addEventListener('change', function() {
          const imgPreview = this.closest('.modal-body').querySelector('.preview-img');
          const fileReader = new FileReader();
          fileReader.readAsDataURL(this.files[0]);

          fileReader.onload = function(e) {
            imgPreview.src = e.target.result;
          }
        });
      });
    }
    document.addEventListener('DOMContentLoaded', previewImage);
  </script>
  <?= $this->endSection() ?>