<?php include 'auth.php'; requireRole(['owner']); include 'db.php';
if($_POST){
$pass=password_hash($_POST['password'],PASSWORD_DEFAULT);
$stmt=$conn->prepare("INSERT INTO users(username,password,role)VALUES(?,?,?)");
$stmt->bind_param("sss",$_POST['username'],$pass,$_POST['role']);
$stmt->execute();
}
?>
<form method="POST">
<input name="username">
<input name="password">
<select name="role">
<option>owner</option>
<option>manager</option>
<option>staff</option>
</select>
<button>Add User</button>
</form>
