<?php

class User extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Function to find user is authenticatd one or not  
     * @param type $data
     * @return type
     */
    function findUser($data) {
        $this->db->select('id');
        $this->db->from('cdp_user');
        $this->db->where('email', $data['emailAddress']);
        $this->db->where('password', md5($data['userPwd']));
        $query = $this->db->get();
        $id = $query->row_array();
        return $id;
    }

    /**
     * To get password for particular user
     * @param type $pwd
     * @return type
     */
    function checkPassword($pwd) {
        $this->db->select('id');
        $query = $this->db->get_where('cdp_user', array('password' => md5($pwd)));
        $id = $query->row_array();
        return $id;
    }

    /**
     * To update password for authenticated user
     * @param type $pwd
     * @param type $id
     */
    function updatePwd($pwd, $id) {
        $data = array(
            'password' => md5($pwd),
        );
        $this->db->where('id', $id);
        $this->db->update('cdp_user', $data);
    }

    /**
     * To update password for authenticated user
     * @param type $newPwdData
     */
    function updatePwdByEmail($newPwdData) {
        $pwdData = array(
            'password' => md5($newPwdData['new_password']),
        );
        $this->db->where('email', $newPwdData['email_id']);
        $this->db->update('cdp_user', $pwdData);
    }

    /**
     * To get user by email id
     * @param type $email
     * @return type
     */
    function findUserByMail($email) {
        $this->db->select('id');
        $query = $this->db->get_where('cdp_user', array('email' => $email));
        $id = $query->row_array();
        return $id;
    }

    /**
     * To add new user in db table
     * @param type $data
     * @return type
     */
    function addNewUser($data) {
        $dataSet = array(
            'first_name' => $data['firstName'],
            'middle_name' => $data['middleName'],
            'last_name' => $data['lastName'],
            'address' => $data['mailingAddress1'] . " " . $data['mailingAddress2'] . " " . $data['mailingAddress3'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'phone_number' => $data['phone'],
            'phone_number_extension' => $data['phoneExt'],
            'phone_country' => $data['phoneCountry'],
            'fax' => $data['fax'],
            'fax_extension' => $data['faxExtension'],
            'fax_country' => $data['faxCountry'],
            'email' => $data['emailInput'],
            'communication_method' => $data['commMethod'],
        );
        $this->db->insert('cdp_user', $dataSet);
        $lastUserId = $this->db->insert_id();
        return $lastUserId;
    }

    /**
     * To set user password
     * @param type $data
     * @param type $userId
     * @return type
     */
    function setUserPassword($data, $userId) {
        $pwdData = array(
            'password' => md5($data['confirmNewPwd']),
            'pin' => $data['pin'],
            'birthday' => $data['dob'],
        );
        $this->db->where('id', $userId);
        $this->db->update('cdp_user', $pwdData);
        return;
    }

    /**
     * To get all proposal list for regular user
     * @param type $userId
     * @return type
     */
    function getAllProposalList($userId) {
        $this->db->select("cdp_proposal.id as proposalId,cdp_proposal.proposal_type,cdp_user.first_name,cdp_user.last_name,GROUP_CONCAT(cdp_code.original_section) as sections,cdp_proposal_status.name  as proposalStatus");
        $this->db->select("DATE_FORMAT(DATE_FORMAT(cdp_proposal.created_at,'%Y-%m-%d'),'%d %b %Y') as createdAt", FALSE);
        $this->db->select("DATE_FORMAT(DATE_FORMAT(cdp_proposal.edited_at,'%Y-%m-%d'),'%d %b %Y') as editedAt", FALSE);
        $this->db->from('cdp_user');
        $this->db->join('cdp_proposal', 'cdp_user.id = cdp_proposal.created_by', 'left');
        $this->db->join('cdp_proposal_collaboration', 'cdp_proposal_collaboration.id = cdp_proposal.id', 'left');
        $this->db->join('cdp_proposal_status', 'cdp_proposal_collaboration.status_id = cdp_proposal_status.id', 'left');
        $this->db->join('cdp_code', 'cdp_proposal.id = cdp_code.proposal_id', 'left');
        $this->db->where('cdp_user.id', $userId);
        $this->db->where('cdp_proposal.cycle_group', 9);
        $this->db->where('cdp_proposal.proposal_type !=', 'public_comment');
        $this->db->group_by('cdp_proposal.id');
        $proposalQuery = $this->db->get();
        return $proposalQuery->result_array();
    }

    /**
     * To get all proposal list for admin user
     * @param type $userId
     * @return type
     */
    function getAllProposalListForAdmin() {
        $this->db->select("cdp_proposal.id as proposalId,cdp_proposal.proposal_type,cdp_user.first_name,cdp_user.last_name,GROUP_CONCAT(cdp_code.original_section) as sections,cdp_proposal_status.name as proposalStatus,cdp_proposal.created_at as submittedAt");
        $this->db->select("DATE_FORMAT(DATE_FORMAT(cdp_proposal.created_at,'%Y-%m-%d'),'%d %b %Y') as createdAt", FALSE);
        $this->db->select("DATE_FORMAT(DATE_FORMAT(cdp_proposal.edited_at,'%Y-%m-%d'),'%d %b %Y') as editedAt", FALSE);
        $this->db->from('cdp_user');
        $this->db->join('cdp_proposal', 'cdp_user.id = cdp_proposal.created_by', 'left');
        $this->db->join('cdp_proposal_collaboration', 'cdp_proposal_collaboration.id = cdp_proposal.id', 'left');
        $this->db->join('cdp_proposal_status', 'cdp_proposal_collaboration.status_id = cdp_proposal_status.id', 'left');
        $this->db->join('cdp_code', 'cdp_proposal.id = cdp_code.proposal_id', 'left');
        $this->db->where('cdp_proposal.cycle_group', 9);
        $this->db->where('cdp_proposal.proposal_type !=', 'public_comment');
        $this->db->where('cdp_proposal_status.name !=', 'Unsubmitted');
        $this->db->group_by('cdp_proposal.id');
        $proposalQuery = $this->db->get();
        return $proposalQuery->result_array();
    }

    /**
     * To get book details
     * @return type
     */
    function getBookDetails() {
        $this->db->select('id,title,year');
        $this->db->from('cdp_books');
        $this->db->where_in('year', 2015);
        $booksQuery = $this->db->get();
        return $booksQuery->result_array();
    }

    /**
     * Get Book part
     * @param type $bookId
     * @return type
     */
    function getBookPart($bookId) {
        $this->db->select('id,title');
        $this->db->from('cdp_book_parts');
        $this->db->where("book_id", $bookId);
        $bookPartQuery = $this->db->get();
        return $bookPartQuery->result_array();
    }

    /**
     * Get Book part foe adding new section
     * @param type $bookId
     * @return type
     */
    function getNewBookPart($bookId) {
        $this->db->select('id,title');
        $this->db->from('cdp_book_parts');
        $this->db->where("book_id", $bookId);
        $bookPartQuery = $this->db->get();
        return $bookPartQuery->result_array();
    }

    /**
     * Get chapters by book part id
     * @param type $bookId
     * @return type
     */
    function getChaptersByBookPartId($bookId, $bookPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapters');
        $this->db->where("book_id", $bookId);
        $this->db->where("book_part_id", $bookPartId);
        $chapterQuery = $this->db->get();
        return $chapterQuery->result_array();
    }

    /**
     * To get chapters by book part id for adding new sections
     * @param type $bookId
     * @return type
     */
    function getNewChaptersByBookPartId($bookId, $bookPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapters');
        $this->db->where("book_id", $bookId);
        $this->db->where("book_part_id", $bookPartId);
        $chapterQuery = $this->db->get();
        return $chapterQuery->result_array();
    }

    /**
     *  To get chapters by book id 
     * @param type $bookId
     * @return type
     */
    function getChaptersByBookId($bookId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapters');
        $this->db->where("book_id", $bookId);
        $this->db->where_not_in('chapter_type', 'PRECONTENT');
        $chapterQuery = $this->db->get();
        return $chapterQuery->result_array();
    }

    /**
     * To get chapters by book id for adding new sections
     * @param type $bookId
     * @return type
     */
    function getNewChaptersByBookId($bookId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapters');
        $this->db->where("book_id", $bookId);
        $this->db->where_not_in('chapter_type', 'PRECONTENT');
        $chapterQuery = $this->db->get();
        return $chapterQuery->result_array();
    }

    /**
     * To get chapters part by chapter id
     * @param type $chapterId
     * @return type
     */
    function getChapterPartsById($chapterId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapter_parts');
        $this->db->where("chapter_id", $chapterId);
        $chapterPartQuery = $this->db->get();
        return $chapterPartQuery->result_array();
    }

    /**
     * To get chapters part by chapter id for adding new sections
     * @param type $chapterId
     * @return type
     */
    function getNewChapterPartsById($chapterId) {
        $this->db->select('id,title');
        $this->db->from('cdp_chapter_parts');
        $this->db->where("chapter_id", $chapterId);
        $chapterPartQuery = $this->db->get();
        $chapterParts = array();
        return $chapterPartQuery->result_array();
    }

    /**
     * To get section by chapter id 
     * @param type $chapterPartId
     * @return type
     */
    function getSectionsByChapterId($chapterPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_section');
        $this->db->where("chapter_id", $chapterPartId);
        $sectionQuery = $this->db->get();
        return $sectionQuery->result_array();
    }

    /**
     * To get section by chapter id for adding new sections
     * @param type $chapterPartId
     * @return type
     */
    function getNewSectionsByChapterId($chapterPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_section');
        $this->db->where("chapter_id", $chapterPartId);
        $sectionQuery = $this->db->get();
        return $sectionQuery->result_array();
    }

    /**
     * To get section by chapter part id
     * @param type $chapterPartId
     * @return type
     */
    function getSectionsByChapterPartId($chapterPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_section');
        $this->db->where("part_id", $chapterPartId);
        $sectionQuery = $this->db->get();
        return $sectionQuery->result_array();
    }

    /**
     * To get section by chapter id for adding new sections
     * @param type $chapterPartId
     * @return type
     */
    function getNewSectionsByChapterPartId($chapterPartId) {
        $this->db->select('id,title');
        $this->db->from('cdp_section');
        $this->db->where("part_id", $chapterPartId);
        $sectionQuery = $this->db->get();
        $sections = array();
        return $sectionQuery->result_array();
    }

    /**
     * To get section content
     * @param type $sectionId
     * @return type
     */
    function getSectionContents($sectionId) {
        $sectionContent = array();
        $isArrayCheck = array();
        //query to get sectioncontent for section id
        $sectionContent = $this->getSectionContentInformation($sectionId);
        foreach ($sectionContent as $sectionsss) {
            $returnVal = $this->getSectionContentInformation($sectionsss['id']);
            if (count($returnVal) > 0) {
                if (count($returnVal) >= 1) {
                    foreach ($returnVal as $r) {
                        $sectionContent[] = $r;
                    }
                } else {
                    $sectionContent[] = $returnVal;
                }
            }
            array_push($isArrayCheck, count($returnVal));
        }

        return $sectionContent;
    }

    /**
     *  To get section content for adding new sections
     * @param type $sectionId
     * @return type
     */
    function getNewSectionContents($sectionId) {
        $sectionContent = array();
        $isArrayCheck = array();
        //query to get sectioncontent for section id
        $sectionContent = $this->getSectionContentInformation($sectionId);
        foreach ($sectionContent as $sectionsss) {
            $returnVal = $this->getSectionContentInformation($sectionsss['id']);
            if (count($returnVal) > 0) {
                if (count($returnVal) >= 1) {
                    foreach ($returnVal as $r) {
                        $sectionContent[] = $r;
                    }
                } else {
                    $sectionContent[] = $returnVal;
                }
            }
            array_push($isArrayCheck, count($returnVal));
        }

        return $sectionContent;
    }

    /**
     * To get section for adding new sections
     * @param type $sectionId
     * @return type
     */
    function getSectionContent($contentId) {
        $this->db->select('book,title,year,section,original_section,content');
        $this->db->from('cdp_code');
        $this->db->where('id', $contentId);
        $sectionContentQuery = $this->db->get();
        return $sectionContentQuery->row_array();
    }

    /**
     * recursive function to get section contents 
     * @param type $parentId
     * @return type
     */
    function getSectionContentInformation($parentId) {
        $this->db->select('cdp_section.id,cdp_section.title,cdp_section.number,cdp_section_content.content_id,cdp_content.content');
        $this->db->from('cdp_section');
        $this->db->join('cdp_section_content', 'cdp_section_content.section_id = cdp_section.id', 'left');
        $this->db->join('cdp_content', 'cdp_content.id = cdp_section_content.content_id', 'left');
        $this->db->where("cdp_section.parent_id", $parentId);
        $sectionContentQuery = $this->db->get();
        return $sectionContentQuery->result_array();
    }

    /**
     * recursive function to get section contents 
     * @param type $parentId
     * @return type
     */
    function addExistingCodeInDb($proposalId, $codeData) {
        //query to insert in cdp_code table 
        $codeInformation = array(
            'proposal_id' => $proposalId,
            'book' => $codeData['book'],
            'content' => $codeData['existingSectionContents'],
            'section' => $codeData['sectionValues'],
            'original_section' => $codeData['sectionValues'],
            'cdp_code_id' => $codeData['cdpCodeID']
        );
        $this->db->insert('cdp_code', $codeInformation);
        $lastUserId = $this->db->insert_id();

        //query to insert in cdp_proposal_object table 
        $proposalObjectInformation = array(
            'proposal_id' => $proposalId,
            'proposal_object_type' => 'code'
        );
        $this->db->insert('cdp_proposal_objects', $proposalObjectInformation);
        $proposalObjectId = $this->db->insert_id();

        //query to insert in cdp_proposal_code_object table 
        $proposalCodeObjectInformation = array(
            'id' => $proposalObjectId,
            'proposal_object_id' => $lastUserId,
        );
        $this->db->insert('cdp_proposal_code_object', $proposalCodeObjectInformation);
        return $lastUserId;
    }

    /**
     * Add new code in cdp_code table
     * @param type $proposalId
     * @param type $codeData
     * @return type
     */
    function addNewCodeInDb($proposalId, $codeData) {
        //query to insert in cdp_code table 
        $codeInformation = array(
            'proposal_id' => $proposalId,
            'book' => $codeData['newBook'],
            'content' => $codeData['newSectionContents'],
            'section' => $codeData['newSectionValues'],
            'original_section' => $codeData['newSectionValues'],
            'cdp_code_id' => $codeData['cdpCodeID']
        );
        $this->db->insert('cdp_code', $codeInformation);
        $proposal_object_id = $this->db->insert_id();


        //query to insert in cdp_proposal_object table 
        $newProposalObjectInformation = array(
            'proposal_id' => $proposalId,
            'proposal_object_type' => 'code'
        );
        $this->db->insert('cdp_proposal_objects', $newProposalObjectInformation);
        $newProposalObjectId = $this->db->insert_id();

        //query to insert in cdp_proposal_code_object table 
        $newProposalCodeObjectInformation = array(
            'id' => $newProposalObjectId,
            'proposal_object_id' => $proposal_object_id,
        );
        $this->db->insert('cdp_proposal_code_object', $newProposalCodeObjectInformation);
        return $proposal_object_id;
    }

    /**
     * Get  all propoasal by Id
     * @param type $proposalId
     * @return type
     */
    function getAllProposalByPid($proposalId) {
        $this->db->select('cdp_code.book,cdp_code.id,cdp_code.original_section,cdp_proposal_objects.sort_order');
        $this->db->from('cdp_code');
        $this->db->join('cdp_proposal_code_object', 'cdp_proposal_code_object.proposal_object_id = cdp_code.id', 'left');
        $this->db->join('cdp_proposal_objects', 'cdp_proposal_objects.id = cdp_proposal_code_object.id', 'left');
        $this->db->where('cdp_code.proposal_id', $proposalId);
        $this->db->order_by("cdp_proposal_objects.sort_order", "asc");
        $sectionContentQuery = $this->db->get();
        return $sectionContentQuery->result_array();
    }

    /**
     * to update proposal sectons
     * @param type $updateSectionContentData
     */
    function updateProposalSections($updateSectionContentData) {
        $updateData = array(
            'title' => $updateSectionContentData['updatedTitle'],
            'content' => $updateSectionContentData['updatedContent'],
        );
        $this->db->where('id', $updateSectionContentData['selectedSectionId']);
        $this->db->update('cdp_code', $updateData);
    }

    /**
     * update proposal section
     * @param type $codeId
     * @return type
     */
    function getSelectedProposalChangesView($codeId) {
        $this->db->select('cdp_code.content as modified_content,cdp_code.cdp_code_id,cdp_content.content as original_content');
        $this->db->from('cdp_code');
        $this->db->join('cdp_content', 'cdp_content.id = cdp_code.cdp_code_id', 'left');
        $this->db->where('cdp_code.id', $codeId);
        $changeView = $this->db->get();
        return $changeView->result_array();
    }

    /**
     * To get user profile
     * @param type $userEmail
     */
    function getUserProfile($userEmail) {
        $this->db->select('first_name,middle_name,last_name,address,country,state,city,phone_number,birthday');
        $this->db->from('cdp_user');
        $this->db->where('email', $userEmail);
        $profileQuery = $this->db->get();

        return $profileQuery->result_array();
    }

    /**
     * Function to update user Profile
     * @param type $updateData
     */
    function updateUserProfile($userEmail, $updateData) {
        $updateProfile = array(
            'first_name' => $updateData['firstname'],
            'middle_name' => $updateData['middlename'],
            'last_name' => $updateData['lastname'],
            'address' => $updateData['useraddress'],
            'country' => $updateData['usercountry'],
            'state' => $updateData['userstate'],
            'city' => $updateData['usercity'],
            'phone_number' => $updateData['phone'],
            'birthday' => $updateData['dob'],
        );
        $this->db->where('email', $userEmail);
        $this->db->update('cdp_user', $updateProfile);
        return;
    }

    /**
     * Update section order
     * @param type $reorderData
     * @return type
     */
    function updateSectionSortOrder($reorderData) {
        //query to select id from cdp_proposal_object 
        $this->db->select('id');
        $this->db->from('cdp_proposal_code_object');
        $this->db->where('proposal_object_id', $reorderData['cdpCodeId']);
        $cdpProposalObjectQuery = $this->db->get();
        $cdpProposalObjectId = $cdpProposalObjectQuery->row_array();
        //update sort order in cdp_proposal_object
        $updateProfile = array(
            'sort_order' => $reorderData['newSortOrder'],
        );
        $this->db->where('id', $cdpProposalObjectId['id']);
        $this->db->update('cdp_proposal_objects', $updateProfile);
        return $cdpProposalObjectId['id'];
    }

    /**
     * delete proposal (unsubmitted only)
     * @param type $deleteProposalId
     */
    function deletePropsal($deleteProposalId) {
        $this->db->where('id', $deleteProposalId);
        $this->db->delete('cdp_proposal');
        return 1;
    }

    /**
     * 
     * @param type $updatedAdminPrivileges
     */
    function updatePrivileges($updatedAdminPrivileges, $proposaId) {
        //Query to get status id
        $this->db->select('id');
        $this->db->from('cdp_proposal_status');
        $this->db->where('name', $updatedAdminPrivileges['proposalStatus']);
        $statusIdQuery = $this->db->get();
        $statusId = $statusIdQuery->row_array();

        //Query to update proposal status
        $updateProposalCollaboration = array(
            'status_id' => $statusId['id']
        );
        $this->db->where('id', $proposaId);
        $this->db->update('cdp_proposal_collaboration', $updateProposalCollaboration);
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    function insertNewProposal($userId) {
        $currentDate = date('Y-m-d h:i:s');
        $dataSet = array(
            'created_by' => $userId,
            'edited_by' => $userId,
            'proposal_type' => 'standard',
            'privacy_id' => '3', //  private value set for now
            'created_at' => $currentDate,
            'edited_at' => $currentDate
        );
        $this->db->insert('cdp_proposal', $dataSet);
        $lastUserId = $this->db->insert_id();
        return $lastUserId;
    }

    /**
     * 
     * @param type $codeid
     */
    function removeProposalBySectionId($codeid, $proposalId) {
        //Query to delete entry from cdp_proposal_code_object object
//        $this->db->where('proposal_object_id', $codeid);
//        $this->db->delete('cdp_proposal_code_object');
//        
//         //Query to delete entry from cdp_proposal_objects
//        $this->db->where('proposal_id', $proposalId);
//        $this->db->delete('cdp_proposal_objects');
//      
//           //Query to delete entry from cdp_code table
//        $this->db->where('id', $codeid);
//        $this->db->delete('cdp_code');
    }

    /**
     * 
     * @param type $proposalId
     */
    function getProposalPrivilege($proposalId) {
        $proposalData = array();
        //
        $this->db->select('*');
        $this->db->from('cdp_proposal_status');
        $statusQuery = $this->db->get();
        $proposalData['status'] = $statusQuery->result_array();
        //
        $this->db->select('id,first_name,last_name');
        $this->db->from('cdp_user');
        $usersQuery = $this->db->get();
        $proposalData['users'] = $usersQuery->result_array();
        //
        $this->db->select('id,long_name');
        $this->db->from('cdp_classification');
        $this->db->where('classification_type', 'group');
        $groupQuery = $this->db->get();
        $proposalData['groups'] = $groupQuery->result_array();

        //
        $this->db->select('id,long_name');
        $this->db->from('cdp_classification');
        $this->db->where('classification_type', 'group');
        $groupQuery = $this->db->get();
        $proposalData['committee'] = $groupQuery->result_array();
        return $proposalData;
    }

    /**
     * 
     * @param type $keys
     * @param type $email
     */
    function setUserKey($keys, $email) {
        //Query to update proposal status
        $updateUserKeyInformation = array(
            'key' => $keys
        );
        $this->db->where('email', $email);
        $this->db->update('cdp_user', $updateUserKeyInformation);
    }

    /**
     * 
     * @param type $userkey
     */
    function checkKeyUser($userkey) {
        $this->db->select('email');
        $this->db->from('cdp_user');
        $this->db->where('key',$userkey);
        $userDataQuery = $this->db->get();
        $userEmail = $userDataQuery->result_array();
        if(isset($userEmail)){
            return $userEmail[0]['email'];
        }else{
            return 0;
        }
    }

}

?>