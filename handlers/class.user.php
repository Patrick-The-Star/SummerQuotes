<?php
class USER
{
    /** @var PDO */
    public $db; //Database object

    function __construct($db_con)
    {
        $this->db = $db_con;
    }

    public function register($uname,$umail,$upass)
    {
        try
        {
            $new_password = password_hash($upass, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO tbl_users(user_name,user_email,user_password,joining_date) 
                                                       VALUES(:uname, :umail, :upass, NOW())");

            $stmt->bindParam(":uname", $uname);
            $stmt->bindParam(":umail", $umail);
            $stmt->bindParam(":upass", $new_password);
            $stmt->execute();

            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return false;
    }

    public function login($uname,$umail,$upass)
    {
        try
        {
            $stmt = $this->db->prepare("SELECT * FROM tbl_users WHERE user_name=:uname OR user_email=:umail LIMIT 1");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                if(password_verify($upass, $userRow['user_password']))
                {
                    $_SESSION['user_session'] = $userRow['user_id'];
                    $_SESSION['user_level'] = $userRow['user_level'];
                    $_SESSION['user'] = $userRow['user_name'];
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function remove(){

        if(isset($_Session['user_session'])){
            //Logged in
            if($_SESSION['user']);
        }
        //TODO remove user
    }

    public function is_loggedin()
    {
        return(isset($_SESSION['user_session']));
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    public function getUserType(){
        if($this->is_loggedin()) {
            switch ($_SESSION['user_level']) {
                case 2:
                    return 'Moderator';
                    break;
                case 3:
                    return 'Admin';
                    break;
                default:
                    return 'Member';
                    break;
            }
        } else {
            echo 'error';
        }
    }

    public function getUserName(){
        if($this->is_loggedin()){
            return $_SESSION['user'];
        }
        return '';
    }

    public function getUserQuotes($uname){

        /** @var PDOStatement $stmt */
        switch ($this->getUserType()){
            case 2:
                $stmt = $this->db->prepare("SELECT id_quote, quoteString, quotePoster, quoteAuthor, quoteCreated FROM tbl_quote JOIN tbl_users ON quotePoster = user_name WHERE tbl_users.user_level != 3");
                $stmt->execute(array(':uname'=>$uname));

                break;

            case 3:
                $stmt = $this->db->prepare("SELECT id_quote, quoteString, quotePoster, quoteAuthor, quoteCreated, user_level FROM tbl_quote JOIN tbl_users ON quotePoster = user_name"); // Gets all quotes
                $stmt->execute();
                break;

            default:
                $stmt = $this->db->prepare("SELECT id_quote, quoteString, quotePoster, quoteAuthor, quoteCreated FROM tbl_quote JOIN tbl_users ON quotePoster = user_name WHERE user_name=:uname");
                            $stmt->execute(array(':uname'=>$uname));

                    break;
        }

        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

        return json_encode($userRow);
    }

    public function getUserQuoteCount($uname){

    }

    public function updateUserQuote($id,$uname,$qAuthor,$qString)
    {
        //TODO add permissions to quote
        if ($_POST) {

            if ($this->getUserType() >= 2) {
                //Admins + Mods can edit and update any user's
                $stmt = $this->db->prepare("UPDATE tbl_quote SET quoteString=:qString,
 quoteAuthor=:uAuthName WHERE id_quote=:id");
            }
            $stmt = $this->db->prepare("UPDATE tbl_quote SET quoteString=:qString WHERE id_quote=:id");

            $stmt->bindParam(":qString", $qString);
            $stmt->bindParam(":uAuthName", $qAuthor);

            if ($stmt->execute()) {
                echo "Successfully updated quote";
            } else {
                echo "Query Problem";
            }
        }
    }
}
