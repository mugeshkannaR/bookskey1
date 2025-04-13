	 <?php
	try{
	$db= new PDO('mysql:host=localhost;dbname=bookstore;charset=utf8','root','');
	
	}
	catch(Exception $e){
		
		echo "Error has Occured";
	}
	
 	 
 

 $title=$_POST['title'];
 $price=$_POST['price'];
 $description=$_POST['description'];
 $file=$_FILES['photo'];
 $pdffile=$_FILES['pdf'];
 //PRINT_R( $file);
 
 $filename= $file['name'];
 $filepath= $file['tmp_name'];
 $fileerror= $file['error'];
 if($fileerror == 0){
 $destfile= '../../pic/book/'.$filename;
 move_uploaded_file($filepath, $destfile);
 }
 //ECHO  $destfile;
 $filepname= $pdffile['name'];
 $fileppath= $pdffile['tmp_name'];
 $fileperror= $pdffile['error'];
 if($fileperror == 0){
 $destpfile= '../../pic/pdf/'.$filepname;
 move_uploaded_file($fileppath, $destpfile);
 } 
 $stmt=$db->prepare("insert into product values(null,'$title', $price , '$description','$filename','$filepname',now(),'NO')");
 $stmt->execute();
 
header("location:../books.php");
exit();
?>