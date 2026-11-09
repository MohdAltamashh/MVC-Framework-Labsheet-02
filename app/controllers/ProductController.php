<?php
class ProductController {
    public function index(): void { $products=(new ProductModel())->all(); $title='Products'; require __DIR__.'/../views/products/index.php'; }
    public function create(): void { $errors=$_SESSION['errors']??[]; $old=$_SESSION['old']??[]; unset($_SESSION['errors'],$_SESSION['old']); $title='Register Product'; require __DIR__.'/../views/products/create.php'; }
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD']!=='POST') { redirect('/?action=create'); }
        $errors=ValidationHelper::product($_POST); $imageName=null;
        if (!empty($_FILES['image']['name'])) {
            $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
            $mime=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES['image']['tmp_name']);
            if (!isset($allowed[$mime]) || $_FILES['image']['size']>2*1024*1024) $errors['image']='Upload JPG, PNG or WEBP image up to 2 MB.';
            else { $imageName=bin2hex(random_bytes(12)).'.'.$allowed[$mime]; }
        }
        if ($errors) { $_SESSION['errors']=$errors; $_SESSION['old']=$_POST; redirect('/?action=create'); }
        if ($imageName) {
            $dir=__DIR__.'/../../public/uploads/';
            if (!is_dir($dir)) mkdir($dir,0755,true);
            if (!move_uploaded_file($_FILES['image']['tmp_name'],$dir.$imageName)) { $_SESSION['errors']=['image'=>'Image upload failed.']; $_SESSION['old']=$_POST; redirect('/?action=create'); }
        }
        (new ProductModel())->create(['name'=>trim($_POST['name']),'price'=>(float)$_POST['price'],'quantity'=>(int)$_POST['quantity'],'image_name'=>$imageName]);
        flash('success','Product saved successfully.'); redirect('/');
    }
}
