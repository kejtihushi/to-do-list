<?php
//Starting the session so we can save tasks.
//We use session to keep tasks without a database.
session_start();

//This line checks if the tasks list doesn't exist yet.If it doesn't,it creates an empty one and by that we have a place to store them(the tasks).
if (!isset($_SESSION['tasks'])) {
$_SESSION['tasks']=[];    
}

//Here it is checked if the html form is submitted and the task is not empty so we only add valid tasks to the list.
if ($_SERVER['REQUEST_METHOD'] ==='POST' && !empty($_POST['task'])){
//The input is cleaned to avoid bad 
$_SESSION['tasks'][] = htmlspecialchars($_POST['task']);

//Redirect to the same page after adding to avoid resubmission (of the form).
header("Location:".$_SERVER['PHP_SELF']);
exit();
}

//Here we check for a delete request so the user can remove a specific task from the list.
if (isset($_GET['delete'])){
$index=(int)$_GET['delete'];

//To prevent errors in case someone tries to delete a task that doesn't exist.
if(isset($_SESSION['tasks'][$index])){
unset($_SESSION['tasks'][$index]);
   
//To keep the task list clean after erasing a task.
$_SESSION['tasks'] = array_values($_SESSION['tasks']);
}

//We redirect to prevent the same task from being deleted again if the page is refreshed.
header("Location:" .$_SERVER['PHP_SELF']);
exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>To do list </title>
<style>

/*Center the whole page content */
body {
font-family: Arial,sans-serif;
display: flex; /*To easily align and arrange content*/
flex-direction:column; /*So elements stack vertically in order*/
align-items:center; /*To keep content centered horizontally*/
justify-content:flex-start; /*To start content from the top of the page*/
min-height:100vh; /*To make sure body covers full screen height*/
margin:0;
background:#f5f5f5; /*To give a light background color*/
padding: 20px; /*To add some space around the content*/
}

/*To make the content area clear and easy to read*/
.container {
background:white;
padding 20px 30px;
border-radius:8px; 
box-shadow:0 0 10px rgba(0,0,0,0.1);
width: 320px;
text-align: center; /*To center text inside the container*/

}
h1{
margin-botom:20px;
color:#333; /*To give a dark color to the title*/
}

form{
margin-bottom:20px; /*To add space below the form*/

}

input[type="text"] {
width: 70%; /*To make the input take most of the width*/
padding: 8px 10px; /*To add space inside the input*/
font-size:16px; /*To make the text inside the input larger*/
border:1px solid #ddd; /*To give a light border around the input*/
border-radius:4px; /*To round the corners of the input*/

}
button{
padding: 9px 15px; /*To add space inside the button*/
font-size: 16px; /*To make the button text larger*/
border: none; /*To remove the default border*/ 
background-color:#28a745; /*Green*/
color:white; /*To make the button text white*/
border-radius:4px; /*To round the corners of the button*/
cursor:pointer; /*To change the cursor to a pointer when hovering over the button*/
margin-left: 10px; /*To add space between the input and the button*/
}

button:hover {
background-color:#218838; /*To darken the button color on hover*/
}   

ul {
list-style:none; /*To remove the default button style from the listt */
padding:0; /*To remove pading from the list */
max-height:300px;
overflow-y:auto; /*To add a scroll bar if the list is too long */
text-align:left; /*To align the text to the left */    
}

li {
padding:8px 10px; /*To add space inside each list item */
border-bottom:1px solid #eee; /*To add a light border below each item */
display:flex; /*To arrange the delete button next to the task */
justify-content:space-between; /*To space out the task and the delete button */
align-items:center;
}

a{
color:#dc3545; /*Red for delete */
text-decoration:none; /*To remove underline from the link */
font-weight:bold; /*To make the delete link bold */
cursor:pointer; /*To change the cursor to a pointer when hovering over the link */
}

a:hover{
text-decoration:underline; /*To underline the link and make it look clickable */
}
</style>
</head>
<body>
<div class="container">
<h1>To do list</h1>
<!-- Here "required" is used so users can't add empty tasks.This keeps the list clean and easy to read.-->
<form method ="post" action="">
<input type="text" name="task" placeholder="Add a new task" required />
<button type ="submit">Add</button>  
</form>

<ul>
<?php foreach ($_SESSION['tasks']as $index=>$task):?>
<li>
<?=$task ?>
<!--Delete link next to each task.Clicking sends a GET request with task index to remove it.-->
<a href="?delete=<?=$index ?>">[Delete]</a>
</li>

<?php endforeach; ?>
</ul>
</div>
</body>
</html>



