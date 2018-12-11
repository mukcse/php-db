<?php



// // Basic : declaration, iteration, function
//  $age = array(
//      "john" => 25,
//      "Mary" => 27,
//      "Bob" => 33
//  );
//  echo $age["Mary"];
//  echo count($age);
//  print_r($age);
//  for($i=0; $i<count($age); $i++){
//      echo $i.'<br />';
//  }
//  foreach ($age as $n => $a){
//      echo 'name = '.$n.' age = '.$a. '<br />';
//  }
//  function  greet($name="Mansur"){
//      $string = 'hello world!, I am '.$name ;
//      echo strtoupper($string);
//  }
//  greet();





////methods & visibility

//  class User{
     
//      private  $id;
//      private $username;
//      private $password;
//      private $email;
     
//      public function __construct($username, $password){
//          $this->username = $username;
//          $this->password = $password;
//      }
//      public function register(){
//          echo "User registered";
//      }
//      public function login(){
//          $this->auth_user();
//      }
//      public function auth_user(){
//          echo $this->username." is authenticated";
//      }
//      public function __destruct(){
//          echo "Destructor called";
//      }
//  }
 
//  $user = new User('Mansur', '1234');
//  $user->register();
//  $user->login();





// // getter & setter magic methods

// class Post{
//     private $name;
//     public function __set($name, $value){
//         echo 'setting '.$name.' to '.$value.'<br />';
//         $this->name = $value;
//     }
//     public function __get($name){
//         echo 'Getting '.$name.' <strong>'.$this->name.'</strong>';
//     }
//     public function __isset($name){
//         echo 'Is '.$name.' setted?<br />';
//         return isset($this->name);
//     }
// }

// $post = new Post;
// $post->name = "Testing";
// echo $post->name;
// var_dump(isset($post->name));

// //Inheritance
// class First{
//     public $name;
// }
// class Second extends First{
//     public function getName(){
//         echo $this->name;
//     }
// }
// $second = new Second;
// echo $second->name;
// $second->getName();

// // static method, variable
// class User{
//     public static $minPassLength = 8;
//     public static function validatePass($password){
//         if(strlen($password) >= self::$minPassLength)    {
//             return true;
//         } else{
//             return false;
//         }
//     }
// }
// echo User::$minPassLength;
// echo  User::validatePass('mansur1234');









require 'classes/Database.php';

$database = new Database;
//$database->query('select * from posts');
//$database->query('select * from posts where id = :id');
//$database->bind(':id', 2);
//$rows = $database->resultset();
//print_r($rows);

//if($_POST['submit']){
//	echo 'SUBMITTED';
//}

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if($post['submit']){
	$id = $post['id'];
	$title = $post['title'];
	$body = $post['body'];
	//echo $title;
	//$database->query('INSERT INTO posts(title, body) VALUES(:title, :body)');
	$database->query('UPDATE posts SET title = :title, body = :body where id = :id');
	$database->bind(':id', $id);
	$database->bind(':title', $title);
	$database->bind(':body', $body);
	$database->execute();
	//if($database->lastInsertId()){
	//	echo '<p>New Post added</p>';
	//}
}
if($post['delete']){
	$id = $post['id'];
	$database->query('DELETE from posts where id = :id');
	$database->bind(':id', $id);
	$database->execute();
}

$database->query('select * from posts');
$rows = $database->resultset();
?>

<h1>Add Posts</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
	<label>Post ID</label><br />
	<input type="text" name="id" placeholder="Specify ID" /><br /><br />
	<label>Post Title</label><br />
	<input type="text" name="title" placeholder="Add a Title"/><br /><br />
	<label>Post Body</label><br />
	<textarea name="body"></textarea><br />
	<input type="submit" name="submit" value="Submit"/>
</form>

<h1>Posts</h1>
<div>
	<?php foreach ($rows as $row){ ?>
		<div>
			<h3><?php echo $row['title'];?></h3>
			<p><?php  echo $row['body']; ?></p>
			<br />
			<form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
				<input type="hidden" name="id" value = "<?php echo $row['id'];?>">
				<input type="submit" name="delete" value="Delete"/>
			</form>
		</div>	
	<?php } ?>
</div>