<?php
    
    class User
    {

        private $db; 
        private $error; 
        
        function __construct($db_conn)
        {
            $this->db = $db_conn;

           
            session_start();
        }

       
        public function register($name, $email, $password)
        {
            try
            {
                
                $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

                
                $query = $this->db->prepare("INSERT INTO tbLogin(name, email, password) VALUES(:name, :email, :pass)");
                $query->bindParam(":name", $name);
                $query->bindParam(":email", $email);
                $query->bindParam(":pass", $hashPasswd);
                $query->execute();

                return true;
            }catch(PDOException $e){
                
                if($e->errorInfo[0] == 23000){
                  
                    $this->error = "Email exits already!";
                    return false;
                }else{
                    echo $e->getMessage();
                    return false;
                }
            }
        }

        //Login user
        public function login($email, $password)
        {
            try
            {
                // Ambil data dari database
                $query = $this->db->prepare("SELECT * FROM tbLogin WHERE email = :email");
                $query->bindParam(":email", $email);
                $query->execute();
                $data = $query->fetch();

                // Jika jumlah baris > 0
                if($query->rowCount() > 0){
                    // jika password yang dimasukkan sesuai dengan yg ada di database
                    if(password_verify($password, $data['password'])){
                        $_SESSION['user_session'] = $data['id'];
                        return true;
                    }else{
                        $this->error = "cet e mail existe deja";
                        return false;
                    }
                }else{
                    $this->error = "cet e mail existe deja";
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // Cek apakah user sudah login
        public function isLoggedIn(){
            // Apakah user_session sudah ada di session
            if(isset($_SESSION['user_session']))
            {
                return true;
            }
        }

        // Ambil data user yang sudah login
        public function getUser(){
            // Cek apakah sudah login
            if(!$this->isLoggedIn()){
                return false;
            }

            try {
                // Ambil data user dari database
                $query = $this->db->prepare("SELECT * FROM tbLogin WHERE id = :id");
                $query->bindParam(":id", $_SESSION['user_session']);
                $query->execute();
                return $query->fetch();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // Logout user
        public function logout(){
            // Hapus session
            session_destroy();
            // Hapus user_session
            unset($_SESSION['user_session']);
            return true;
        }

        // Ambil error terakhir yg disimpan di variable error
        public function getLastError(){
            return $this->error;
        }
    }

?>
