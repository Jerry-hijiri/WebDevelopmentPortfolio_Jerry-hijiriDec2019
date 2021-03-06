<?php
    // session_start();
    require_once 'database.php';
    class User extends database{
        public function register($username, $email, $password){
            $sql = "INSERT INTO `user`(username, email, password) VALUES('$username', '$email', '$password') ";

            if($this->conn->query($sql)){
                header("Location: register&login/login.php");
            }else{
                echo "Insertion Error";
            }
        }
        public function registerFromAdmin($username, $email, $password){
            $sql = "INSERT INTO `user`(username, email, password) VALUES('$username', '$email', '$password') ";

            if($this->conn->query($sql)){
                header("Location: indexAdmin.php");
            }else{
                echo "Insertion Error";
            }
        }
        public function login($yourName, $yourPass){
            $sql = "SELECT * FROM `user` WHERE username = '$yourName' AND password ='$yourPass'";

            
            $rows = array();
            $result = $this->conn->query($sql);
            
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        }
        public function about($userid){
            $sql = "SELECT * FROM `user` WHERE user_id = '$userid'";

            $rows = array();
            $result = $this->conn->query($sql);
            
            while($row = $result->fetch_assoc()){
                $rows[] = $row;

            }
            return $rows;
                    
        }
        public function updateProfile($userid, $uname, $bio, $uFName, $uLName, $email, $phone, $nationality, $occupation, $pword, $image_name, $birthday){
            $sql = "UPDATE `user` 
                SET username = '$uname', 
                bio = '$bio', 
                user_first_name = '$uFName', 
                user_last_name = '$uLName', 
                email = '$email', 
                phone = '$phone', 
                nationality = '$nationality', 
                occupation = '$occupation', 
                password = '$pword',
                user_picture = '$image_name',
                user_birthday = '$birthday' 
                
                WHERE user_id = '$userid'
                ";
            if($this->conn->query($sql)){
                
                // print_r($sql);
                header("Location: about.php");
            }
        }
        public function viewUsers($userid){
            $sql ="SELECT * FROM `user` WHERE user_status = 'U' AND NOT user.user_id = '$userid'";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row; 
            }
            return $rows;
        }
        public function deleteUser($userid){
            $sql = "DELETE FROM `user` WHERE user_id = '$userid'";
            if($this->conn->query($sql)){
                header("Location: indexAdmin.php");
            }
        }
        public function viewCategory(){
            $sql = "SELECT * FROM `categories`";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        } 
        public function deleteCategory($categoryid){
            $sql = "DELETE FROM `categories` WHERE category_id = '$categoryid'";
            if($this->conn->query($sql)){
                header("Location: indexAdmin.php");
            }
        }
        public function deletePost($postid, $status){
            $sql = "DELETE FROM `post` WHERE post_id = '$postid'";
            if($this->conn->query($sql)){
                if($status == "A")
                  header("Location: indexAdmin.php");
                else{
                    echo "a";
                  header("Location: about.php");
                }
            }
        }
        public function insertCategory($categoryName){
            $sql = "INSERT INTO `categories`(category)VALUE('$categoryName')";
            if($this->conn->query($sql)){
                header("Location: indexAdmin.php");
            }
        }
        public function getUserDetail($specID){
            $sql = "SELECT * FROM `user` WHERE user_id = '$specID'";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;

        }
        public function posting($image_name, $title, $categoryid, $content, $userid){
            $sql ="INSERT INTO `post`(post_image, title_name, post_content, category_id, user_id)
            VALUES ('$image_name', '$title', '$content', '$categoryid', '$userid')";
            if($this->conn->query($sql)){
                // print_r($sql);
                header("Location: index.php");
            }else {
                echo "error";
            }
        }
        public function viewPost(){
            $sql ="SELECT * FROM `post`
                INNER JOIN `user` ON post.user_id = user.user_id
                INNER JOIN `categories` ON post.category_id = categories.category_id
                order by post_date desc
                
            ";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        }
        public function postDetail($postid){
            $sql ="SELECT * FROM `post`
                INNER JOIN `user` ON post.user_id = user.user_id
                INNER JOIN `categories` ON post.category_id = categories.category_id

                WHERE post.post_id = '$postid'
            ";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        }
        public function usersPosts($userid){
            $sql ="SELECT * FROM `post`
                INNER JOIN `user` ON post.user_id = user.user_id
                INNER JOIN `categories` ON post.category_id = categories.category_id

                WHERE post.user_id = '$userid'
            ";
            $rows = array();
            $result = $this->conn->query($sql);
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        }
        public function uploatdPost1($image, $title, $categoryid, $content, $postid){
            $sql ="UPDATE `post`
                SET post_image = '$image',
                    title_name = '$title',
                    post_content = '$content',
                    category_id = '$categoryid' 

                WHERE post_id = '$postid'
                ";

                echo $sql;

            if($this->conn->query($sql)){
                header("Location: postDetailforUser.php?postid=$postid");
            }
        }
        public function uploatdPost2($image_name, $title, $categoryid, $content, $postid){
            $sql ="UPDATE `post`
                SET post_image = '$image_name',
                    title_name = '$title',
                    post_content = '$content',
                    category_id = '$categoryid' 

                WHERE post_id = '$postid'
                ";

                echo $sql;

            if($this->conn->query($sql)){
                header("Location: postDetailforUser.php?postid=$postid");
            }
        }
        public function follow($followid, $userid){
            $sql ="INSERT INTO `follow`(follow_id, follower_id) VALUES ('$followid', '$userid')";
            echo $sql;
            if($this->conn->query($sql)){
                header("Location:contact.php");
            }
        }
        public function checkFollow($followid, $userid){
            $sql ="SELECT * FROM `follow` where follow_id = '$followid' AND follower_id = '$userid'";
            $resutl = $this->conn->query($sql);
            if($result->num_rows > 0 ){
                $row = $result->fetch_assoc();
                
                echo "<input type='submit' name='follow' value='follow'>";
            }else{
                echo "<input type='submit' name='unfollow' value='unfollow'>";
                echo $userid;
            }
        }
        public function viewUsersinContact($userid){
            $sql ="SELECT * FROM `user` 
                INNER JOIN follow ON user.user_id = follow.user_id 
                WHERE user.user_status = 'U' AND user.user_id = '$userid'
             ";
             $rows = array();
             $result = $this->conn->query($sql);
             while($row = $result->fetch_assoc()){
                 $rows[] = $row;
             }
             return $rows;
        }
        public function followingOfNumber($userid){
            $sql ="SELECT COUNT( DISTINCT user_id, follower_id) FROM follow WHERE user_id = '$userid'";
            $result = $this->conn->query($sql); 
            if($result){
                // $row = $result->fetch_assoc();
                return $result;
            }else{
                echo "0";
            }
        }
    }
?>