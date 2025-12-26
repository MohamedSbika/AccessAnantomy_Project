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

    public function listVideos()
    {

        log_message('error', "list videos" );

        $idChapitre = $_POST["idChapitre"];
        $idType = $_POST["idType"];

        $this->db->select('*');
        $this->db->from('videos');
        $this->db->Where("idChapitre = '$idChapitre' AND type = '$idType'");
        $resVideos = $this->db->get()->result_array();

        log_message('debug', 'listVideo: ' . json_encode($resVideos) );

        $arr_Res = array("id" => '1', "desc" => $resVideos);
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

    function getSubDirectories($dir)
    {
        $subDir = array();
        // Get and add directories of $dir
        $allFiles = glob($dir);
        $directories = array_filter($allFiles, 'is_dir');

        foreach ($allFiles as $file){
            if(is_file($file)){
                $item = array(["name" => basename($file), "path" => $file, "isFolder" => false, "items" => array(), "isOpen" => false]);
                $subDir = array_merge($subDir, $item);
            }else{
                $item = array(["name" => basename($file), "path" => $file, "isFolder" => true, "items" => $this->getSubDirectories($file.'/*'), "isOpen" => false]);
                $subDir = array_merge($subDir, $item); 
            }
        }
        // Return list of sub directories
        return $subDir;
    }

    public function getSubDirectoriesVideos() 
    {
        $search_results = $this->getSubDirectories('uploads/*');
        $json = json_encode($search_results);
        // log_message('error', $json);
        $arr_Res = array("id" => '1', "search_results" => $search_results);
        echo json_encode($arr_Res);
        exit;
    }
}
