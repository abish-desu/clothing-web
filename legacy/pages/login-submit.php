<!-- <?php
require "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST request
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $validCredentials = [
        ["email" => "hygy@gfg.com", "password" => sha1("p12345")], // Example valid credentials
        // Add more valid credentials if needed
    ];

    $valid = false;
    foreach ($validCredentials as $cred) {
        if ($cred["email"] === $email && $cred["password"] === sha1($password)) {
            $valid = true;
            break;
        }
    }
    
    if (!$valid) {
        die("Invalid Credentials");
    }
    
    // If correct credentials, redirect to home page
    header("Location:../project/ecommerce/index.html");
    exit;
}
?>

    // Check if valid credentials exist in database
    // Replace `$validCredentials` with actual query result
    // $validCredentials = ["email", "password"]; // Example array containing valid credentials
    // if (!in_array([$email, sha1($password)], $validCredentials)) {
    //     die("Invalid Credentials");
    // }
    
    // If correct credentials, redirect to home page
//     header("Location: /home.php");
//     exit;
// }



// if (isset($_POST['submit'])) {
//     $email = $_POST['email'];
//     $pwd = $_POST['password'];

//     $sql = "select * from users where email = '$email' and password = '$pwd'";  
//     $result = mysqli_query($conn, $sql);  
//     $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
//     $count = mysqli_num_rows($result);  
    
//     if($count == 1){  
//         header("Location: index.html");
//     }  
//     else{  
//         echo  '<script>
//                     window.location.href = "login.html";
//                     alert("Login failed. Invalid username or password!!")
//                 </script>';
//     }     
// }
?> -->