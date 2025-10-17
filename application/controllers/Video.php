<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of VideoUpload
 *
 * @author https://roytuts.com
 */
class Video extends CI_Controller
{

    //variable for storing error message
    private $error;
    //variable for storing success message
    private $success;

    function __construct()
    {
        parent::__construct();
        //load this to validate the inputs in upload form
        $this->load->library('form_validation');
    }

    //appends all error messages
    private function handle_error($err)
    {
        $this->error .= $err . "\r\n";
    }

    //appends all success messages
    private function handle_success($succ)
    {
        $this->success .= $succ . "\r\n";
    }

    public function index()
    {
        $typeVideo = $_POST["type"];
        $IDChapitre = $_POST["IDChapitre"];
        $titre = trim(preg_replace('/\s+/', ' ', $_POST["titre"]));
        $titre = str_replace("  ", " ", $titre);
        $description = $_POST["description"];

        if ($this->input->post('video_upload')) {
            //set preferences
            //file upload destination

            print_r($_FILES);

            $upload_path = './uploads/';
            $config['upload_path'] = $upload_path;
            //allowed file types. * means all types
            $config['allowed_types'] = 'wmv|mp4|avi|mov';
            //allowed max file size. 0 means unlimited file size
            $config['max_size'] = '0';
            //max file name size
            $config['max_filename'] = '255';
            //whether file name should be encrypted or not
            $config['encrypt_name'] = FALSE;
            //store video info once uploaded
            $video_data = array();
            //check for errors
            $is_file_error = FALSE;

            //check if file was selected for upload
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select a video file.');
            }
            //if file was selected then proceed to upload
            if (!$is_file_error) {
                //load the preferences
                $this->load->library('upload', $config);
                //check file successfully uploaded. 'video_name' is the name of the input
                if (!$this->upload->do_upload('video_name')) {
                    //if file upload failed then catch the errors
                    print_r("ddddd");

                    $this->handle_error($this->upload->display_errors());
                    $is_file_error = TRUE;
                } else {
                    //store the video file info
                    $video_data = $this->upload->data();
                }
            }
            // There were errors, you have to delete the uploaded video
            if ($is_file_error) {
                if ($video_data) {
                    $file = $upload_path . $video_data['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                $data['video_name'] = $video_data['file_name'];
                $data['video_path'] = $upload_path;
                $data['video_type'] = $video_data['file_type'];
                $this->handle_success('Video was successfully uploaded to direcoty <strong>' . $upload_path . '</strong>.');
            }
        }
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;
        //load the view along with data
        $this->load->view('video_upload', $data);
    }

    public function video()
    {

        $IDVideoForm = $_POST["IDVideo"];
        $typeVideo = $_POST["type"];
        $IDChapitre = $_POST["IDChapitre"];
        $titre = trim(preg_replace('/\s+/', ' ', $_POST["titre"]));
        $titre = str_replace("  ", " ", $titre);
        $description = $_POST["description"];

        if ($_FILES && $_FILES["video_name"]["size"] > 0) {
            //set preferences
            //file upload destination
  
            $upload_path = './uploads/';
            $config['upload_path'] = $upload_path;
            //allowed file types. * means all types
            $config['allowed_types'] = 'wmv|mp4|avi|mov';
            //allowed max file size. 0 means unlimited file size
            $config['max_size'] = '0';
            //max file name size
            $config['max_filename'] = '255';
            //whether file name should be encrypted or not
            $config['encrypt_name'] = FALSE;
            //store video info once uploaded
            $video_data = array();
            //check for errors
            $is_file_error = FALSE;

            //check if file was selected for upload
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select a video file.');
            }
            //if file was selected then proceed to upload
            if (!$is_file_error) {
                //load the preferences
                $this->load->library('upload', $config);
                //check file successfully uploaded. 'video_name' is the name of the input
                if (!$this->upload->do_upload('video_name')) {
                    //if file upload failed then catch the errors
                    $this->handle_error($this->upload->display_errors());
                    $is_file_error = TRUE;
                } else {
                    //store the video file info
                    $video_data = $this->upload->data();
                }
            }
            // There were errors, you have to delete the uploaded video
            if ($is_file_error) {
                if ($video_data) {
                    $file = $upload_path . $video_data['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                $data['video_name'] = $video_data['file_name'];
                $data['video_path'] = $upload_path;
                $data['video_type'] = $video_data['file_type'];
                $this->handle_success('Video was successfully uploaded to direcoty <strong>' . $upload_path . '</strong>.');
                
                if ($IDVideoForm === "-1") {
                    $data = [
                        'IDChapitre' => $IDChapitre,
                        'path' => $data['video_name'],
                        'titre' => $titre,
                        'description' => $description,
                        'type' => $typeVideo
                    ];
                    $this->insert_dd("videos", $data);
                } else {
                    $data = [
                        'path' => $data['video_name'],
                        'titre' => $titre,
                        'description' => $description,
                    ];
    
                    $this->db->where('id', $IDVideoForm);
                    $this->db->update("videos", $data);
                }
    
    
                $arr_Res[] = array("id" => '1', "desc" => "");
                echo json_encode($arr_Res);
                exit;

            }

            $arr_Res[] = array("id" => '0', "desc" => "");
            echo json_encode($arr_Res);
            exit;
            
        }
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;

        
       
        if ($IDVideoForm !== "-1") {
  
            $data = [
                'titre' => $titre,
                'description' => $description,
            ];

            $this->db->where('id', $IDVideoForm);
            $this->db->update("videos", $data);

            $arr_Res[] = array("id" => '1', "desc" => "");
            echo json_encode($arr_Res);
            exit;
        }

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }

    public function uploadsVideo()
    {
        $path_folder_video = $_POST["path_folder_video"];
    
        log_message('error', $path_folder_video );

        if ($_FILES && $_FILES["video_name"]["size"] > 0) {
            //set preferences
            //file upload destination
  
            // $upload_path = './uploads/';
            $upload_path = './'.$path_folder_video.'/';
            $config['upload_path'] = $upload_path;
            //allowed file types. * means all types
            $config['allowed_types'] = 'wmv|mp4|avi|mov';
            //allowed max file size. 0 means unlimited file size
            $config['max_size'] = '0';
            //max file name size
            $config['max_filename'] = '255';
            //whether file name should be encrypted or not
            $config['encrypt_name'] = FALSE;
            //store video info once uploaded
            $video_data = array();
            //check for errors
            $is_file_error = FALSE;

            //check if file was selected for upload
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select a video file.');
            }
            //if file was selected then proceed to upload
            if (!$is_file_error) {
                //load the preferences
                $this->load->library('upload', $config);
                //check file successfully uploaded. 'video_name' is the name of the input
                if (!$this->upload->do_upload('video_name')) {
                    //if file upload failed then catch the errors
                    $this->handle_error($this->upload->display_errors());
                    $is_file_error = TRUE;
                } else {
                    //store the video file info
                    $video_data = $this->upload->data();
                }
            }
            // There were errors, you have to delete the uploaded video
            if ($is_file_error) {
                if ($video_data) {
                    $file = $upload_path . $video_data['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                $data['video_name'] = $video_data['file_name'];
                $data['video_path'] = $upload_path;
                $data['video_type'] = $video_data['file_type'];
                $this->handle_success('Video was successfully uploaded to direcoty <strong>' . $upload_path . '</strong>.');
            
                $arr_Res[] = array("id" => '1', "desc" => "");
                echo json_encode($arr_Res);
                exit;
            }

            $arr_Res[] = array("id" => '0', "desc" => "");
            echo json_encode($arr_Res);
            exit;
            
        }
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }


    public function uploadsAudio()
    {
        $path_folder_audio = $_POST["path_folder_audio"];
    
        log_message('error', $path_folder_audio );

        if ($_FILES && $_FILES["audio_name"]["size"] > 0) {
            //set preferences
            //file upload destination
  
            // $upload_path = './uploads/';
            $upload_path = './'.$path_folder_audio.'/';
            $config['upload_path'] = $upload_path;
            //allowed file types. * means all types
            $config['allowed_types'] = 'mp3';
            //allowed max file size. 0 means unlimited file size
            $config['max_size'] = '0';
            //max file name size
            $config['max_filename'] = '255';
            //whether file name should be encrypted or not
            $config['encrypt_name'] = FALSE;
            //store video info once uploaded
            $video_data = array();
            //check for errors
            $is_file_error = FALSE;

            //check if file was selected for upload
            if (!$_FILES) {
                $is_file_error = TRUE;
                $this->handle_error('Select a video file.');
            }
            //if file was selected then proceed to upload
            if (!$is_file_error) {
                //load the preferences
                $this->load->library('upload', $config);
                //check file successfully uploaded. 'video_name' is the name of the input
                if (!$this->upload->do_upload('audio_name')) {
                    //if file upload failed then catch the errors
                    $this->handle_error($this->upload->display_errors());
                    $is_file_error = TRUE;
                } else {
                    //store the video file info
                    $video_data = $this->upload->data();
                }
            }
            // There were errors, you have to delete the uploaded video
            if ($is_file_error) {
                if ($video_data) {
                    $file = $upload_path . $video_data['file_name'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            } else {
                $data['video_name'] = $video_data['file_name'];
                $data['video_path'] = $upload_path;
                $data['video_type'] = $video_data['file_type'];
                $this->handle_success('Video was successfully uploaded to direcoty <strong>' . $upload_path . '</strong>.');
            
                $arr_Res[] = array("id" => '1', "desc" => "");
                echo json_encode($arr_Res);
                exit;
            }

            $arr_Res[] = array("id" => '0', "desc" => "");
            echo json_encode($arr_Res);
            exit;
            
        }
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }

    public function video2()
    {

        $IDVideoForm = $_POST["IDVideo"];
        $pathVideo = $_POST["video_path"];
        $baseFolder =  "uploads/";
     
        if(strpos($pathVideo, $baseFolder) > -1){
            log_message('error', strpos($pathVideo, $baseFolder));
            $pathVideo = substr($pathVideo, strlen($baseFolder), strlen($pathVideo) - strlen($baseFolder));  
        }
        
       
        $typeVideo = $_POST["type"];
        $IDChapitre = $_POST["IDChapitre"];
        $titre = trim(preg_replace('/\s+/', ' ', $_POST["titre"]));
        $titre = str_replace("  ", " ", $titre);
        $description = $_POST["description"];

        
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;

        if ($IDVideoForm === "-1") {
            $data = [
                'IDChapitre' => $IDChapitre,
                'path' => $pathVideo,
                'titre' => $titre,
                'description' => $description,
                'type' => $typeVideo
            ];
            $this->insert_dd("videos", $data);

            $arr_Res[] = array("id" => '1', "desc" => "");
            echo json_encode($arr_Res);
            exit;
        }else if ($IDVideoForm !== "-1") {
  
            $data = [
                'titre' => $titre,
                'description' => $description,
                'path' => $pathVideo,
            ];

            $this->db->where('id', $IDVideoForm);
            $this->db->update("videos", $data);

            $arr_Res[] = array("id" => '1', "desc" => "");
            echo json_encode($arr_Res);
            exit;
        }

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }

    public function audio2()
    {

        $idFigure = $_POST["idFigure"];
        $pathVideo = $_POST["video_path"];
        $baseFolder =  "uploads/";
     
        if(strpos($pathVideo, $baseFolder) > -1){
            log_message('error', strpos($pathVideo, $baseFolder));
            $pathVideo = substr($pathVideo, strlen($baseFolder), strlen($pathVideo) - strlen($baseFolder));  
        }
        
        //load the error and success messages
        $data['errors'] = $this->error;
        $data['success'] = $this->success;

        if ($idFigure !== "-1") {
  
            $data = [
                'pathAudio' => $pathVideo,
            ];

            $this->db->where('id', $idFigure);
            $this->db->update("figures", $data);

            $arr_Res[] = array("id" => '1', "desc" => "");
            echo json_encode($arr_Res);
            exit;
        }

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }

    public function deleteAudio()
    {

        $idFigure = $_POST["idFigureSuppression"];
     
        if ($idFigure !== "-1") {
  
            $data = [
                'pathAudio' => null,
            ];

            $this->db->where('id', $idFigure);
            $this->db->update("figures", $data);

            $arr_Res[] = array("id" => '1', "desc" => "");
            echo json_encode($arr_Res);
            exit;
        }

        $arr_Res[] = array("id" => '0', "desc" => "");
        echo json_encode($arr_Res);
        exit;

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }

    public function listVideos()
    {

        log_message('error', "list videos" );

        $idChapitre = $_POST["idChapitre"];
        $idType = $_POST["idType"];

        $this->db->select('*');
        $this->db->from('videos');
        $this->db->Where("idChapitre = '$idChapitre' AND type = '$idType'");
        $resVideos = $this->db->get()->result_array();

        log_message('listVideo', json_encode($resVideos) );

        $arr_Res = array("id" => '1', "desc" => $resVideos);
        echo json_encode($arr_Res);

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }
    
    public function getAudioByFigure()
    {

        //log_message('error', "list videos" );

        $idFigure = $_POST["idFigure"];

        $this->db->select('*');
        $this->db->from('figures');
        $this->db->Where("id = '$idFigure'");
        $resAudio = $this->db->get()->result_array();

        //log_message('listVideo', json_encode($resVideos) );

        if (count($resAudio) > 0) {
            $arr_Res = array("id" => '1', "desc" => $resAudio[0]); // Use the first result if it exists
        } else {
            $arr_Res = array("id" => '1', "desc" => null); // Return null if no audio found
        }

        echo json_encode($arr_Res);

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }


    public function deleteVideo()
    {

        $idVideo = $_POST["idVideoSuppression"];
       
        $this->db->query("delete FROM `videos` WHERE id = '$idVideo' ;");

        $arr_Res = array("id" => '1', "desc" => "");
        echo json_encode($arr_Res);

        //load the view along with data
        //$this->load->view('video_upload', $data);
    }


    public function insert_dd($tablename, $data)
    {
        $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    // Modify this function to accept a type (audio or video)
    function getSubDirectories($dir, $type = null)
    {
        $subDir = array();
        // Get all files and directories in $dir
        $allFiles = glob($dir);
        $directories = array_filter($allFiles, 'is_dir');

        foreach ($allFiles as $file) {
            if (is_file($file)) {
                // Filter by type (audio or video) based on file extension
                if ($this->isFileType($file, $type)) {
                    $item = array(
                        "name" => basename($file),
                        "path" => $file,
                        "isFolder" => false,
                        "items" => array(),
                        "isOpen" => false
                    );
                    $subDir[] = $item; // Add the file if it matches the type
                }
            } else {
                $item = array(
                    "name" => basename($file),
                    "path" => $file,
                    "isFolder" => true,
                    "items" => $this->getSubDirectories($file . '/*', $type), // Recursive call with type
                    "isOpen" => false
                );
                $subDir[] = $item; // Add the directory
            }
        }

        // Return the list of subdirectories and files
        return $subDir;
    }

    // Helper function to filter by file type
    private function isFileType($file, $type)
    {
        // Define the allowed extensions for audio and video
        $audioExtensions = array('mp3', 'wav', 'aac', 'ogg');
        $videoExtensions = array('mp4', 'avi', 'mkv', 'mov');

        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        // Check if the file matches the specified type
        if ($type === 'audio' && in_array($fileExtension, $audioExtensions)) {
            return true;
        } elseif ($type === 'video' && in_array($fileExtension, $videoExtensions)) {
            return true;
        }

        return false; // Return false if no match
    }

    // Modify the function for videos
    public function getSubDirectoriesVideos()
    {
        $search_results = $this->getSubDirectories('uploads/*', 'video'); // Pass "video" as the type
        $json = json_encode($search_results);
        $arr_Res = array("id" => '1', "search_results" => $search_results);
        echo json_encode($arr_Res);
        exit;
    }

    // Modify the function for audio
    public function getSubDirectoriesAudio()
    {
        $search_results = $this->getSubDirectories('uploads/*', 'audio'); // Pass "audio" as the type
        $json = json_encode($search_results);
        $arr_Res = array("id" => '1', "search_results" => $search_results);
        echo json_encode($arr_Res);
        exit;
    }

    public function deleteAudioFromServer() {
        $this->load->helper('file'); // Load file helper

        // Get the JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        $audioPath = $input['path'];

        if (file_exists($audioPath)) {
            if (unlink($audioPath)) {
                // Return success response
                echo json_encode(['success' => true]);
            } else {
                // Return error response
                echo json_encode(['success' => false, 'message' => 'Could not delete file.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File does not exist.']);
        }
    }
    
}
