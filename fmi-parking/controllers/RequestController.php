<?php
require_once 'routes.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserService.php';
require_once __DIR__ . '/../models/ParkingSpotService.php';
require_once __DIR__ . '/../models/CourseService.php';

class RequestController
{
    private function errorResponse($errorMsg, $errCode)
    {
        http_response_code($errCode);
        echo json_encode(['error' => $errorMsg], JSON_UNESCAPED_UNICODE);
    }

    private function checkSubmitPost()
    {
        if (!isset($_POST['submit'])) {
            header("Location:" . INDEX_URL . "?action=error");
            exit();
        }
    }

    private function checkAdminAuthorisation()
    {
        if (!isset($_SESSION['u_id']) || $_SESSION['u_role'] != 'admin') {
            header("Location:" . INDEX_URL . "?action=unauthorised");
            exit();
        }
    }

    private function checkLoggedAuthorisation()
    {
        if (!isset($_SESSION['u_id'])) {
            header("Location:" . INDEX_URL . "?action=unauthorised");
            exit();
        }
    }

    private function mail_utf8($to, $subject = '(No subject)', $message = '')
    {
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

        $headers = "MIME-Version: 1.0" . "\r\n" .
            "Content-type: text/plain; charset=UTF-8" . "\r\n";

        return mail($to, $subject, $message, $headers);
    }

    /**
     * @return true if barrier can be lifted for that ID; false otherwise
     */
    private function liftBarrier($id)
    {
        $user = UserService::getUserById($id);
        return $user != null &&
               $this->shouldLiftBarrier($user->getURole(), $id);
    }

    
    private function shouldLiftBarrier($role, $id)
    {
        if (UserService::hasUserOccupiedParkingSpot($id)) {
            ParkingSpotService::freeParkingSpot($id);
            return true;
        }

        if (!ParkingSpotService::hasFreeParkingSpots()) {
            return false;
        }

        if ($role == 'admin' || $role == 'permanent') {
            ParkingSpotService::updateParkingSpot($id, null);
            return true;
        }

        if ($role == 'temporary') {
            date_default_timezone_set('Europe/Sofia');
            $curWeekday = date('l');
            $curTime = date('H:i:s');
            $duration = $this->calculateDuration($id, $curWeekday, $curTime);

            // Can't park today
            if ($duration == 0) {
                return false;
            }
            ParkingSpotService::updateParkingSpot($id, $duration);
            return true;
        }

        return false;
    }

  

    public function register()
    {
        $this->checkSubmitPost();

        $first = $_POST['first'];
        $last  = $_POST['last'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $pwd = $_POST['pwd'];
        $pwdRepeat = $_POST["pwd-repeat"];

        // Error handlers
        // External use has found a way to register as admin
        if (isset($_SESSION['u_role']) && $_SESSION['u_role'] != 'admin' && $role == 'admin') {
            header("Location:" . INDEX_URL . "?action=unauthorized");
            exit();
        }

        // Check for empty fields
        if (empty($first) || empty($last) || empty($email) || empty($role)) {
            header("Location:" . REGISTER_URL . "?register=empty");
            exit();
        }
        // Check if input characters are valid
        if (
            !preg_match('/[??-????-??a-zA-Z]/u', $first) ||
            !preg_match('/[??-????-??a-zA-Z]/u', $last)
        ) {
            header("Location:" . REGISTER_URL . "?register=invalidNameSymbols");
            exit();
        }

        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:" . REGISTER_URL . "?register=invalidEmail");
            exit();
        }

        $emailIsAlreadyTaken = UserService::getUserByEmail($email) != null;
        if ($emailIsAlreadyTaken) {
            
            header("Location:" . REGISTER_URL . "?register=emailTaken");
            exit();
        }

        // Password check
        if ($pwd != $pwdRepeat) {
         
            header("Location:" . REGISTER_URL . "?register=passwordsNotMatch");
            exit();
        }
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        // Insert the user into the database
        $newUser = ['first' => $first, 'last' => $last, 'email' => $email, 'password' => $hashedPwd, 'role' => $role];
        UserService::insertNewUser($newUser);

        $user = UserService::getUserByEmail($email);
        if ($user != null) {
            if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
                $_SESSION['u_id'] = $user->getUId();
                $_SESSION['u_first'] = $user->getUFirst();
                $_SESSION['u_last'] = $user->getULast();
                $_SESSION['u_email'] = $user->getUEmail();
                $_SESSION['u_role'] = $user->getURole();
            }
            header("Location:" . INDEX_URL . "?register=success");
        } else {
            header("Location:" . REGISTER_URL . "?register=empty");
        }

        
        exit();
    }

    public function login()
    {
        // Error handlers
        if (isset($_SESSION['u_id'])) {
            header("Location:" . INDEX_URL . "?action=unauthorised");
            exit();
        }

        $this->checkSubmitPost();

        $email = $_POST['email'];
        $pwd   = $_POST['pwd'];
        $user = UserService::getUserByEmail($email);

        $credentialsAreValid = $user != null && password_verify($pwd, UserService::getPasswordHashByEmail($email));
        if ($credentialsAreValid) {
            // Log in the user
            $_SESSION['u_id'] = $user->getUId();
            $_SESSION['u_first'] = $user->getUFirst();
            $_SESSION['u_last'] = $user->getULast();
            $_SESSION['u_email'] = $user->getUEmail();
            $_SESSION['u_role'] = $user->getURole();
            header("Location:" . INDEX_URL . "?login=success");
        } else {
            header("Location:" . LOGIN_URL . "?login=wrongCredentials");
        }
    }

    public function logout()
    {
        $this->checkLoggedAuthorisation();
        //setcookie($_SESSION['email'],$_SESSION['role'],time()-1,'/');
        session_unset();
        session_destroy();
        header("Location:" . INDEX_URL . "?logout=success");
    }

    public function addCourse()
    {
        $this->checkAdminAuthorisation();
        $this->checkSubmitPost();

        $email = $_POST['email'];
        $name = $_POST['name'];
        $day = $_POST['day'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        //Error handlers
        //Check for empty fields
        if (empty($email) || empty($name) || empty($day) || empty($from) || empty($to)) {
            header("Location:" . ADD_COURSE_URL . "?addcourse=empty");
            exit();
        }
        //Format dates
        $from = date('H:i:s', strtotime($from));
        $to = date('H:i:s', strtotime($to));

        //Check if input characters are valid
        if ($from >= $to) {
            header("Location:" . ADD_COURSE_URL . "?addcourse=invalidTimes");
            exit();
        }

        $user = UserService::getUserByEmail($email);
        if ($user) {
            //Insert the course into the database
            $newCourse = ['name' => $name, 'teacher_id' => $user->getUId(), 'day' => $day, 'from' => $from, 'to' => $to];
            CourseService::insertNewCourse($newCourse);
            header("Location:" . INDEX_URL . "?addcourse=success");
        } else {
            header("Location:" . ADD_COURSE_URL . "?addcourse=noSuchEmail");
        }
    }

    public function changePass()
    {
        $this->checkLoggedAuthorisation();
        $this->checkSubmitPost();

        $pwd = $_POST['pwd'];
        $newPwd = $_POST['newPwd'];
        $newPwd2 = $_POST['newPwd2'];
        $email = $_SESSION['u_email'];
        $first = $_SESSION['u_first'];
        $last = $_SESSION['u_last'];

        if (empty($pwd) || empty($newPwd) || empty($newPwd2)) {
            header("Location:" . CHANGE_PASS_URL . "?changepass=empty");
            exit();
        }
        if ($newPwd != $newPwd2) {
            header("Location:" . CHANGE_PASS_URL . "?changepass=passwordsMismatch");
            exit();
        }

        if (password_verify($pwd, UserService::getPasswordHashByEmail($email))) {
            if (!UserService::changePasswordByEmail($email, $newPwd)) {
                header("Location:" . CHANGE_PASS_URL . "?changepass=fail");
                exit();
            }
 

            header("Location:" . CHANGE_PASS_URL . "?changepass=success");
        } else {
            header("Location:" . CHANGE_PASS_URL . "?changepass=wrongCredentials");
        }
    }

    public function changeStatus()
    {
        $this->checkAdminAuthorisation();
        $this->checkSubmitPost();

        $email = $_POST['email'];
        $role = $_POST['role'];

        if (empty($email) || empty($role)) {
            header("Location:" . CHANGE_STATUS_URL . "?changestatus=empty");
            exit();
        }

        $user = UserService::getUserByEmail($email);
        if ($user) {
            $firstName = $user->getUFirst();
            $lastName = $user->getULast();

            UserService::chageUserRoleByEmail($email, $role);

           

            header("Location:" . INDEX_URL . "?changestatus=success");
        } else {
            header("Location:" . CHANGE_STATUS_URL . "?changestatus=noSuchEmail");
        }
    }

    public function checkCode()
    {
        if (!isset($_GET['id'])) {

            header("HTTP/1.1 400 Bad Request");
            exit();
        }

        $id = $_GET['id'];
        if ($this->liftBarrier($id)) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    

    private function calculateDuration($id, $day, $curTime)
    {
        $query = CourseService::getCourseByTeacherAndDay($id, $day);

        $curWeekday = date('l');
        $row = $query->fetch(PDO::FETCH_ASSOC);

        $start = strtotime($row["course_from"]);
        $end = strtotime($row["course_to"]);
        $cur = strtotime($curTime);

        if (
            $row['course_day'] == $curWeekday &&
            $start - 3600 <= $cur && $cur <= $end
        ) {
            $duration = ceil(($end - $cur + 3600) / 3600);
            return $duration;
        }

        return 0;
    }
    public function removeCourse(){
        $this->checkAdminAuthorisation();
        $this->checkSubmitPost();

        $id = $_POST['id'];
        if (empty($id)) {
            header("Location:" . REMOVE_COURSE_URL . "?removecourse=empty");
            exit();
        }
        $result = UserService::deleteCourseById($id);
         if ($result) {
            header("Location:" . REMOVE_COURSE_URL . "?changestatus=success");
        } else {
            header("Location:" . REMOVE_COURSE_URL . "?changestatus=noSuchId");
        }

    }
    
}
