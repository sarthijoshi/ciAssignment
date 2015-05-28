<?php

class Users extends CI_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('phpmailer');
        $this->load->helper('file');
        $this->load->model('user');
        session_start();

        /**
         * code for tiny mce editor
         */
        $this->tinyMce = '
			<!-- TinyMCE -->
			<script type="text/javascript" src="/current/assets/js/tiny_mce/js/tinymce/tinymce.min.js"></script>
			<script type="text/javascript">
				tinyMCE.init({
					// General options
                                        toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
					mode : "textareas",
                                        theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
                                        font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
        				theme : "modern"
				});
			</script>
			<!-- /TinyMCE -->
			';
    }

    /**
     * First function to be called
     */
    function index() {
        if ($this->session->userdata('userInformation')) {
            redirect("/users/proposal");
        } else {
            redirect("/users/login");
        }
    }

    /**
     * This function is used to login for regular user.
     */
    public function login() {
        if ($this->session->userdata('userInformation')) {
            redirect("/users/proposal");
        } else {
            $this->form_validation->set_rules('emailAddress', 'Mail id', 'valid_email');
            $this->form_validation->set_rules('userPwd', 'Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('loginError', 'Invalid email and password');
                $this->load->view("templates/header");
                $this->load->view("login/login");
                $this->load->view("templates/footer");
            } else {
                $loginData = $this->input->post();
//                print_r($loginData);die;
                //code to set cookie for remember me functionality
                if (!empty($loginData['loginkeeping'])) {
                    setcookie("emailAddress", $loginData['emailAddress'], time() + (86400 * 30), "/");
                } else {
                    setcookie("emailAddress", $loginData['emailAddress'], time() - (86400 * 30), "/");
                }
                $loginResult = $this->user->findUser($loginData);
                if (empty($loginResult)) {
                    $this->session->set_flashdata('loginError', 'Please enter registered email address and password.');
                    redirect("/users/login", loginError);
                } else {
                    $userInfo = array('userEmail' => $loginData['emailAddress'],
                        'userId' => $loginResult['id']);
                    $this->session->set_userdata('userInformation', $userInfo);
                    if ($loginData['emailAddress'] === "admin@admin.com") {
                        redirect("/users/adminProposal");
                    } else {
                        redirect("/users/proposal");
                    }
                }
            }
        }
    }

    /**
     * Function is used for registering new user.
     */
    public function registration() {
        $userInfo = $this->session->userdata('userInformation');
        if (!$userInfo['userEmail']) {
            $this->form_validation->set_rules('firstName', 'First Name', 'required|min_length[1]|max_length[20]|alpha_numeric');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required|min_length[1]|max_length[20]|alpha_numeric');
            $this->form_validation->set_rules('emailInput', 'Mail id', 'valid_email');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('registrationError', 'Invalid inputs.Please try again');
                $this->load->view("templates/header");
                $this->load->view("registration/registration");
                $this->load->view("templates/footer");
            } else {
                $registrationData = $this->input->post();
                $validateResult = $this->user->findUserByMail($registrationData['emailInput']);
                //check if user already registered or not 
                if (!empty($validateResult)) {
                    $this->session->set_flashdata('registrationError', 'User already registered with this email address.Please try with another email address');
                    redirect("/users/registration", registrationError);
                } else {
                    $userId = $this->user->addNewUser($registrationData);
                    if (!empty($userId)) {
                        $userInfo = array('userEmail' => $registrationData['emailInput'],
                            'userId' => $userId, 'firstName' => $registrationData['firstName']);
                        $this->session->set_userdata('userInformation', $userInfo);
                        //welcome message to be send to new user 
                        $welcomeMsg = '<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></head>
                                    <body>
                                        <div style="border:10px solid #acacac;width:800px;">
                                          <img src="https://cdn.eventplanner.tv/imgs/xr6226_6-tips-to-make-your-online-participants-feel-welcome-in-a-hybrid-event@2x.jpg" height="180" width="400";margin-left: 185px;>
                                          <p style="font-family: \'Arial\',sans-serif; font-size: 13px; font-weight: normal; color: #5e5e5e; margin: 0pt 0pt 16px; padding-left: 20px">
                                               <b style="color: #5e5e5e;font-family:Arial,sans-serif;font-size: 21px;">Thank you for registering to the site, still in alpha phase.<br/>
                                               Please visit : </b> "http://localhost/current"
                                          </p>
                                        </div>  
                                    </body>';
                        $this->sendMail($registrationData['emailInput'], $welcomeMsg);
                    }
                }
                redirect("users/setPassword");
            }
        } else {
            redirect("/users/login");
        }
    }

    /**
     * This function is used to set password and pin for new user.
     */
    public function setPassword() {
        $this->form_validation->set_rules('newPwd', 'New Password', 'required');
        $this->form_validation->set_rules('confirmNewPwd', 'Confirm Password', 'required');
        $this->form_validation->set_rules('pin', 'Pin', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('setPasswordError', 'Invalid inputs.Please try again');
            $this->load->view("templates/header");
            $this->load->view("registration/setPassword");
            $this->load->view("templates/footer");
        } else {
            $setPasswordData = $this->input->post();
            if ($setPasswordData['newPwd'] != $setPasswordData['confirmNewPwd']) {
                $this->session->set_flashdata('setPasswordError', 'New and confirm password must be same');
                redirect("/users/setPassword");
            } else {
                $userInformation = $this->session->userdata('userInformation');
                $this->user->setUserPassword($setPasswordData, $userInformation['userId']);
                redirect("/users/proposal");
            }
        }
    }

    /**
     * Forget Password : To send mail to user requesting to change or recover password.
     */
    public function forgetPassword() {
        $userInfo = $this->session->userdata('userInformation');
        if (!$userInfo['userEmail']) {
            $this->form_validation->set_rules('userEmail', 'Mail id', 'valid_email');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('forgetPwdError', 'Please enter valid email address ');
                $this->load->view("templates/header");
                $this->load->view("login/forgetPassword");
                $this->load->view("templates/footer");
            } else {
                $emailData = $this->input->post();
                $validateResult = $this->user->findUserByMail($emailData['userEmail']);
                if (empty($validateResult)) {
                    $this->session->set_flashdata('forgetPwdError', 'Please enter registered email address.');
                    redirect("/users/forgetPassword", forgetPwdError);
                } else {
                    $curerent_time = time();
                    $key = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 1) . substr(md5($curerent_time), 1);
                    $keys = substr($key, 18);
                    $this->user->setUserKey($keys, $emailData['userEmail']);
                    //email to user to manage password 
                    $forgetPwdMessage = '<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></head>
                                    <body>
                                        <div style="border:10px solid #acacac;width:800px;">
                                          <img src="https://cdn.eventplanner.tv/imgs/xr6226_6-tips-to-make-your-online-participants-feel-welcome-in-a-hybrid-event@2x.jpg" height="180" width="400";margin-left: 185px;>
                                          <p style="font-family: \'Arial\',sans-serif; font-size: 13px; font-weight: normal; color: #5e5e5e; margin: 0pt 0pt 16px; padding-left: 20px">
                                               <b style="color: #5e5e5e;font-family:Arial,sans-serif;font-size: 21px;">
                                               Hello User.To manage password, please visit http://localhost/current/users/managePassword?' . $keys . '</b>
                                          </p>
                                        </div>  
                                    </body>';
                    $this->sendMail($emailData['userEmail'], $forgetPwdMessage);
                    redirect("/users/index");
                }
            }
        } else {
            //if user already logged in..redirect him to proposal listing page  
            redirect("/users/proposal");
        }
    }

    /**
     * Change Password : To change password of user 
     */
    public function changePassword() {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            $this->form_validation->set_rules('oldPassword', 'Password', 'required');
            $this->form_validation->set_rules('newPassword', 'Password', 'required');
            $this->form_validation->set_rules('confirmPassword', 'Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('changePwdError', 'Invalid old or new password');
                $this->load->view("templates/header");
                $this->load->view("login/changePassword");
                $this->load->view("templates/footer");
            } else {
                $changePwdData = $this->input->post();
                // check if old and new password is same or not
                if ($changePwdData['oldPassword'] === $changePwdData['newPassword']) {
                    $this->session->set_flashdata('changePwdError', 'Old and new password must be different');
                    redirect("/users/changePassword", changePwdError);
                }
                //validate old password from table
                $pwdData = $this->user->checkPassword($changePwdData['oldPassword']);
                if (empty($pwdData)) {
                    $this->session->set_flashdata('changePwdError', 'Please enter correct old password');
                    redirect("/users/changePassword", changePwdError);
                } else {
                    $this->user->updatePwd($changePwdData['newPassword'], $userInfo['userId']);
                    //email to user to notify chnange in password 
                    $forgetPwdMessage = '<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></head>
                                    <body>
                                        <div style="border:10px solid #acacac;width:800px;">
                                          <img src="https://cdn.eventplanner.tv/imgs/xr6226_6-tips-to-make-your-online-participants-feel-welcome-in-a-hybrid-event@2x.jpg" height="180" width="400";margin-left: 185px;>
                                          <p style="font-family: \'Arial\',sans-serif; font-size: 13px; font-weight: normal; color: #5e5e5e; margin: 0pt 0pt 16px; padding-left: 20px">
                                               <b style="color: #5e5e5e;font-family:Arial,sans-serif;font-size: 21px;">
                                               Hello User, your password changed just now.<br/> If not by you then please visit site : http://localhost/current</b>
                                          </p>
                                        </div>  
                                    </body>';
                    $this->sendMail($userInfo['userEmail'], $forgetPwdMessage);
                    redirect("/users/index");
                }
            }
        } else {
            redirect("/users/index");
        }
    }

    /**
     * To display proposal list 
     */
    public function proposal() {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            $data['list'] = $this->user->getAllProposalList($userInfo['userId']);
            $this->load->view("templates/header");
            $this->load->view("proposal/proposal", $data);
            $this->load->view("templates/footer");
        } else {
            redirect("/users/index");
        }
    }

    /**
     * To display proposal list 
     */
    public function adminProposal() {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            $data['list'] = $this->user->getAllProposalListForAdmin();
            $this->load->view("templates/header");
            $this->load->view("proposal/adminProposal", $data);
            $this->load->view("templates/footer");
        } else {
            redirect("/users/index");
        }
    }

    /**
     * Open Proposal: Get open proposal by proposal id  
     */
    public function openProposal($id) {
        //Code to check weather given value is numeric or not
        if (!is_numeric($id)) {
            $this->session->set_flashdata('openProposalError', 'Invalid proposal Id.Please try with valid proposal id');
            $this->load->view("templates/header");
            $this->load->view("proposal/errorPage");
            $this->load->view("templates/footer");
        } else {
            $userInfo = $this->session->userdata('userInformation');
            if ($userInfo['userEmail']) {
                $userInfo = $this->session->userdata('userInformation');
                $userInfo['pid'] = $id;
                $this->session->set_userdata('userInformation', $userInfo);
                $ProposalSection['proposalData'] = $this->user->getProposalPrivilege($id);
//                echo "<pre>";
//                print_r($ProposalSection);die;
                $ProposalSection['userEmailId'] = $userInfo['userEmail'];
                $ProposalSection['bookData'] = $this->user->getBookDetails();
                $this->load->view("templates/header");
                $this->load->view("proposal/openProposal", $ProposalSection);
                $this->load->view("templates/footer");
            } else {
                redirect("/users/index");
            }
        }
    }

    /**
     * Create Proposal: Get open proposal by proposal id  
     */
    public function createProposal() {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            //Query to insert new proposal 
            $proposalId = $this->user->insertNewProposal($userInfo['userId']);
            $userInfo = $this->session->userdata('userInformation');
            $userInfo['pid'] = $proposalId;
            $this->session->set_userdata('userInformation', $userInfo);
            $ProposalSection['bookData'] = $this->user->getBookDetails();
            $this->load->view("templates/header");
            $this->load->view("proposal/createProposal", $ProposalSection);
            $this->load->view("templates/footer");
        } else {
            redirect("/users/index");
        }
    }

    /**
     * Code to get book parts
     */
    public function getBookParts() {
        $book = $this->input->post();
        $bookPart = $this->user->getBookPart($book['bookId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($bookPart));
    }

    /**
     * Code to get parts for newly added section
     */
    public function getNewBookParts() {
        $newBook = $this->input->post();
        $newBookPart = $this->user->getNewBookPart($newBook['newBookId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newBookPart));
    }

    /**
     * Code to get chapter by book part for existing section
     */
    public function getChaptersByBookPart() {
        $books = $this->input->post();
        $chapters = $this->user->getChaptersByBookPartId($books['bookId'], $books['bookPartId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($chapters));
    }

    /**
     *  Code to get chapter by book part for new section
     */
    public function getNewChaptersByBookPart() {
        $newBooks = $this->input->post();
        $newChapters = $this->user->getNewChaptersByBookPartId($newBooks['newBookId'], $newBooks['newBookPartId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newChapters));
    }

    /**
     * Code to get chapter by book  for existing section
     */
    public function getChaptersByBook() {
        $books = $this->input->post();
        $chapters = $this->user->getChaptersByBookId($books['bookId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($chapters));
    }

    /**
     * Code to get chapter by book  for newly added section
     */
    public function getNewChaptersByBook() {
        $newBooks = $this->input->post();
        $newChapters = $this->user->getNewChaptersByBookId($newBooks['newBookId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newChapters));
    }

    /**
     * To get chapter parts
     */
    public function getChapterParts() {
        $chapterData = $this->input->post();
        $chapterParts = $this->user->getChapterPartsById($chapterData['chapterId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($chapterParts));
    }

    /**
     * Code to get chapter parts for newly added section
     */
    public function getNewChapterParts() {
        $newChapterData = $this->input->post();
        $newChapterParts = $this->user->getNewChapterPartsById($newChapterData['newChapterId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newChapterParts));
    }

    /**
     * To get section by chapter
     */
    public function getSectionsByChapter() {
        $chapterInformation = $this->input->post();
        $sections = $this->user->getSectionsByChapterId($chapterInformation['chapterId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($sections));
    }

    /**
     * Code to get section by chapter id for newly added section
     */
    public function getNewSectionsByChapter() {
        $newChapterInformation = $this->input->post();
        $newSections = $this->user->getNewSectionsByChapterId($newChapterInformation['newChapterId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newSections));
    }

    /**
     * get section by chapter part part
     */
    public function getSectionsByChapterPart() {
        $chapterInformation = $this->input->post();
        $sections = $this->user->getSectionsByChapterPartId($chapterInformation['chapterPartId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($sections));
    }

    /**
     * Code to get section by chapter part id for newly added section
     */
    public function getNewSectionsByChapterPart() {
        $newChapterInformation = $this->input->post();
        $newSections = $this->user->getNewSectionsByChapterPartId($newChapterInformation['newChapterPartId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newSections));
    }

    /**
     * Get section content by section id
     */
    public function getSectionsContent() {
        $sectionInformation = $this->input->post();
        $sections = $this->user->getSectionContents($sectionInformation['sectionId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($sections));
    }

    /**
     * Code to get section content for newly added section
     */
    public function getNewSectionsContent() {
        $newSectionInformation = $this->input->post();
        $newSections = $this->user->getNewSectionContents($newSectionInformation['newSectionId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newSections));
    }

    /**
     * Code to get existing content 
     */
    public function getContent() {
        $sectionInformation = $this->input->post();
        $sectionContents = $this->user->getSectionContent($sectionInformation['selectedSectionId']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($sectionContents));
    }

    /**
     * Email user using smtp  
     * @param type $userEmail
     * @return type
     */
    public function sendMail($userEmail, $msg) {
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "sarthijoshi87@gmail.com";
        $mail->Password = "sarthihello";
        $mail->SetFrom("sarthijoshi87@gmail.com");
        $mail->Subject = 'a message from sarthi'; // "Your Gmail SMTP Mail";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8 \r\n";
        $headers .= "From: sarthijoshi87@gmail.com";
        $message = $msg;
        $mail->Body = $message;
        $mail->AddAddress($userEmail);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
    }

    /**
     * Logout function which clears session
     */
    public function logout() {
        $this->session->unset_userdata('userInformation');
        $this->session->sess_destroy();
        redirect("/");
    }

    /**
     * Add section in cdp_code table for add existing section
     */
    public function addExistingSectionCode() {
        $userInfo = $this->session->userdata('userInformation');
        $newSectionInformation = $this->input->post();
        //function call to insert in databse
        $newSections = $this->user->addExistingCodeInDb($userInfo['pid'], $newSectionInformation);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newSections));
    }

    /**
     * Add section in cdp_code table for add new section
     */
    public function addNewSectionCode() {
        $userInfo = $this->session->userdata('userInformation');
        $newSectionInformation = $this->input->post();
        //function call to insert in databse
        $newSections = $this->user->addNewCodeInDb($userInfo['pid'], $newSectionInformation);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($newSections));
    }

    /**
     * TO get all section from cdp_code table for particular proposal id
     */
    public function getAllSectionProposalByPid() {
        $userInfo = $this->session->userdata('userInformation');
        $allProposal = $this->user->getAllProposalByPid($userInfo['pid']);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($allProposal));
    }

    /**
     * TO update code by cdp_code id
     */
    public function updateSectionCode() {
        $updatedSectionInformation = $this->input->post();
        $allProposal = $this->user->updateProposalSections($updatedSectionInformation);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($allProposal));
    }

    /**
     * TO update code by cdp_code id
     */
    public function viewChangeProposal($codeId) {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            $sectionProposalId = $this->input->post();
            $proposalSection['sectionInformation'] = $this->user->getSelectedProposalChangesView($codeId);
            $this->load->view("templates/header");
            $this->load->view("proposal/viewChangeProposal", $proposalSection);
            $this->load->view("templates/footer");
        } else {
            redirect("/users/index");
        }
    }

    /**
     * function to load help view
     */
    public function help() {
        $this->load->view("templates/header");
        $this->load->view("help");
        $this->load->view("templates/footer");
    }

    /**
     * function to get user profile and render profile page
     */
    public function profile() {
        $userInfo = $this->session->userdata('userInformation');
        if ($userInfo['userEmail']) {
            $profile['profile'] = $this->user->getUserProfile($userInfo['userEmail']);
            $this->load->view("templates/header");
            $this->load->view("profile", $profile);
            $this->load->view("templates/footer");
        } else {
            redirect("/users/index");
        }
    }

    /**
     * function to get user profile and render profile page
     */
    public function updateProfile() {
        $userInformation = $this->session->userdata('userInformation');
        $profile = $this->input->post();
        $updatedUserId = $this->user->updateUserProfile($userInformation['userEmail'], $profile);
        redirect("/users/index");
    }

    /**
     * 
     */
    public function managePassword() {
        $userkey = $_SERVER['QUERY_STRING'];
        $emailInformation['emailAddress'] = $this->user->checkKeyUser($userkey);
        if ($emailInformation['emailAddress'] == 0) {
            $this->load->view("templates/header");
            $this->load->view("login/managePassword", $emailInformation);
            $this->load->view("templates/footer");
        } else {
            //   print_r($emailInformation['emailAddress']);die;
            $this->load->view("templates/header");
            $this->load->view("login/managePassword", $emailInformation);
            $this->load->view("templates/footer");
        }
    }

    /**
     * Create new password: To create new password for user who forgot his password 
     */
    public function createNewPassword() {
        $userInfo = $this->session->userdata('userInformation');
        if (!$userInfo['userEmail']) {
            $this->form_validation->set_rules('email_id', 'Mail id', 'valid_email');
            $this->form_validation->set_rules('new_password', 'New Password', 'required');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('createNewPasswordError', 'Invalid new or confirm password');
                redirect("/users/managePassword");
            } else {
                $createNewPasswordData = $this->input->post();
                //validate email 
                $validateEmail = $this->user->findUserByMail($createNewPasswordData['email_id']);
                if (empty($validateEmail)) {
                    $this->session->set_flashdata('createNewPasswordError', 'Please enter registered email address.');
                    redirect("/users/managePassword", createNewPasswordError);
                } else {
                    //code to set new password   
                    $this->user->updatePwdByEmail($createNewPasswordData);
                    //email to user to notify change in password 
                    $newPwdMessage = '<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"></head>
                                    <body>
                                        <div style="border:10px solid #acacac;width:800px;">
                                          <img src="https://cdn.eventplanner.tv/imgs/xr6226_6-tips-to-make-your-online-participants-feel-welcome-in-a-hybrid-event@2x.jpg" height="180" width="400";margin-left: 185px;>
                                          <p style="font-family: \'Arial\',sans-serif; font-size: 13px; font-weight: normal; color: #5e5e5e; margin: 0pt 0pt 16px; padding-left: 20px">
                                               <b style="color: #5e5e5e;font-family:Arial,sans-serif;font-size: 21px;">
                                               Hello User, as requested, your password reset successfully. If not by you then please visit site : http://localhost/current</b>
                                          </p>
                                        </div>  
                                    </body>';
                    $this->sendMail($createNewPasswordData['email_id'], $newPwdMessage);
                    redirect("/users/index");
                }
            }
        } else {
            redirect("/users/index");
        }
    }

    /**
     * To delete regular user proposal
     */
    public function reorderSection() {
        $reorderData = $this->input->post();
        $updateSuccess = $this->user->updateSectionSortOrder($reorderData);
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($updateSuccess));
    }

    /**
     * To delete regular user proposal
     */
    public function deleteProposal($deletedSectionId) {
        if (!is_numeric($deletedSectionId)) {
            $this->session->set_flashdata('deleteProposalError', 'Invalid proposal Id.Please try with valid proposal id');
            $this->load->view("templates/header");
            $this->load->view("proposal/errorPage");
            $this->load->view("templates/footer");
        } else {
            $deleteID = $this->user->deletePropsal($deletedSectionId);
            redirect("/users/proposal");
        }
    }

    /**
     * To delete regular user proposal
     */
    public function updateAdminPrivileges() {
        $userInfo = $this->session->userdata('userInformation');
        $updatedAdminPrivileges = $this->input->post();
        $updateSuccess = $this->user->updatePrivileges($updatedAdminPrivileges, $userInfo['pid']);
    }

    /**
     * To delete regular user proposal
     */
    public function removeSection() {
        $userInfo = $this->session->userdata('userInformation');
        $sectionData = $this->input->post();
        $this->user->removeProposalBySectionId($sectionData['sectionid'], $userInfo['pid']);
    }

}

?>