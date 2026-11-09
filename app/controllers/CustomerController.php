<?php
class CustomerController {
 public function create(): void { $title='Customer Registration'; $errors=$_SESSION['errors']??[]; $old=$_SESSION['old']??[]; unset($_SESSION['errors'],$_SESSION['old']); require __DIR__.'/../views/customers/create.php'; }
 public function store(): void {
  $name=trim($_POST['name']??''); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $phone=trim($_POST['phone']??'');
  $errors=[]; if($name==='')$errors['name']='Name is required.'; if(!$email)$errors['email']='Valid email is required.';
  if($errors){$_SESSION['errors']=$errors;$_SESSION['old']=$_POST;redirect('/?page=customer');}
  try{(new CustomerModel())->create(['name'=>$name,'email'=>$email,'phone'=>$phone]);flash('success','Customer registered.');redirect('/?page=customer');}
  catch(PDOException $e){$_SESSION['errors']=['email'=>'Email may already be registered.'];$_SESSION['old']=$_POST;redirect('/?page=customer');}
 }
}
