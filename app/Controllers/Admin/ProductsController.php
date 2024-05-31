<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModelCategory;
use App\Models\ModelProduct;

class ProductsController extends BaseController
{
    protected $modelCategory;
    protected $modelProduct;
    public function __construct()
    {
        $this->modelCategory = new ModelCategory();
        $this->modelProduct = new ModelProduct();
    }
    // Product List
    public function product()
    {
        $data = [
            'title' => 'Product List',
            'category' => $this->modelCategory->findAll(),
            'content' => 'admin/products/index',
            'validation' => \Config\Services::validation(),
            'productList' => $this->modelProduct->orderBy('productId', 'DESC')->findAll(),
        ];
        return view('admin/products/index', $data);
    }

    public function addProduct()
    {
        // Validation
        $rules = $this->validate([
            'productName' => 'required',
            'categorySlug' => 'required',
            'description' => 'required',
            'image' => 'uploaded[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png]|ext_in[image,jpg,jpeg,png]',
        ]);

        // Error Validation
        if (!$rules) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        // Handle file upload
        $productImage = $this->request->getFile('image'); // This should be 'image' as in the form
        if ($productImage->isValid() && !$productImage->hasMoved()) {
            // Create a random name for the image
            $imageName = $productImage->getRandomName();
            $imagePath = WRITEPATH . '../public/asset-admin/img/';

            $productImage->move($imagePath, $imageName);
        } else {
            session()->setFlashdata('error', 'There was a problem uploading the image.');
            return redirect()->back()->withInput();
        }

        // Create slug for product
        $productName = esc($this->request->getPost('productName'));
        if ($productName) {
            $productSlug = url_title($productName, '-', true);

            $data = [
                'productSlug' => $productSlug,
                'productName' => esc($this->request->getPost('productName')),
                'categorySlug' => esc($this->request->getPost('categorySlug')),
                'description' => esc($this->request->getPost('description')),
                'productImage' => $imageName,
            ];
            $this->modelProduct->insert($data);

            return redirect()->back()->with('success', 'Product added successfully');
        } else {

            return redirect()->back()->with('error', 'Product name is required');
        }
    }

    public function editProduct($productId)
    {
        // Find Product
        $product = $this->modelProduct->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Validation
        $rules = $this->validate([
            'productName' => 'required',
            'categorySlug' => 'required',
            'description' => 'required',
            'image' => 'max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png]|ext_in[image,jpg,jpeg,png]',
        ]);
        if (!$rules) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        // Handle file upload
        $productImage = $this->request->getFile('image');
        if ($productImage->isValid() && !$productImage->hasMoved()) {
            // Create a random name for the image
            $imageName = $productImage->getRandomName();
            $imagePath = WRITEPATH . '../public/asset-admin/img/';
            $productImage->move($imagePath, $imageName);

            // Delete old image if exists
            if ($product->productImage && file_exists($imagePath . $product->productImage)) {
                unlink($imagePath . $product->productImage);
            }
        } else {
            $imageName = $product->productImage; // Keep old image if new image not uploaded
        }

        // Create slug for product
        $productName = esc($this->request->getVar('productName'));
        if ($productName) {
            $productSlug = url_title($productName, '-', true);

            $data = [
                'productName' => esc($this->request->getVar('productName')),
                'productSlug' => $productSlug,
                'categorySlug' => esc($this->request->getVar('categorySlug')),
                'description' => esc($this->request->getVar('description')),
                'productImage' => $imageName,
            ];
            $this->modelProduct->update($productId, $data);

            return redirect()->back()->with('success', 'Product updated successfully');
        } else {
            return redirect()->back()->with('error', 'Product name is required');
        }
        
    }


    // Category List
    public function category()
    {
        $data = [
            'title' => 'Category List',
            'content' => 'admin/products/category',
            'validation' => \Config\Services::validation(),
            'categoryList' => $this->modelCategory->orderBy('categoryId', 'DESC')->findAll(),
        ];
        return view('admin/products/category', $data);
    }

    // Add Category
    public function addCategory()
    {
        $rules = $this->validate([
            'categoryName' => 'required',
        ]);

        // Error Validation
        if (!$rules) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $categoryName = esc($this->request->getVar('categoryName'));

        if ($categoryName) {
            $categorySlug = url_title($categoryName, '-', true);

            $data = [
                'categoryName' => esc($categoryName),
                'categorySlug' => $categorySlug,
            ];
            $this->modelCategory->insert($data);

            return redirect()->back()->with('success', 'Category added successfully');
        } else {

            return redirect()->back()->with('error', 'Category name is required');
        }
    }

    // Edit Category
    public function editCategory($categoryId)
    {
        $categoryName = $this->request->getVar('categoryName');
        if ($categoryName) {
            $slug = url_title($categoryName, '-', true);

            $data = [
                'categoryName' => esc($categoryName),
                'categorySlug' => $slug,
            ];
            $this->modelCategory->update($categoryId, $data);

            return redirect()->back()->with('success', 'Category updated successfully');
        } else {

            return redirect()->back()->with('error', 'Category name is required');
        }
    }

    // Delete Category
    public function deleteCategory($categoryId)
    {
        $this->modelCategory->where('categoryId', $categoryId)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
