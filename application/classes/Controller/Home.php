<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_Home extends Controller_Template
{
    // Default template
    public $template    = 'template'; 
    public $limit = 10;

 
    public function action_index()
    {
        $template   = $this->template; 

        $this->template->header     = View::factory('header');  
        $this->template->content    = View::factory('home'); 
        $this->template->footer     = View::factory('footer'); 
        $this->template->script     = '';   
    }

    public function action_about()
    {
        $template   = $this->template; 

        $this->template->header     = View::factory('header');  
        $this->template->content    = View::factory('about'); 
        $this->template->footer     = View::factory('footer'); 
        $this->template->script     = '';  
    }

    public function action_profile()
    {
        $template   = $this->template; 

        $this->template->header     = View::factory('header');  
        $this->template->content    = View::factory('profile_view'); 
        $this->template->footer     = View::factory('footer'); 
        $this->template->script     = View::factory('profile_script');  
    }


    // Function for upload photo    
    public function action_upload_photo() {
        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';          

        if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $date       = date('Y_m_d_H_i_s');          
            $ext        = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename   = 'PROFILE_' . $date . '.' . $ext;
            $path       = APPPATH . '../assets/img/upload/'.$filename;
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
            echo $filename;
        }
    }

    // Function for adding new profile   
    public function action_add_profile() {
        $db_home    = Model::factory('home');

        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';  
        
        $title      = $this->request->post('title');
        $filename   = $this->request->post('filename');
        $img_url    = '/assets/img/upload/'.$filename;

        $result = $db_home->add_profile($title, $filename, $img_url);

        if ($result){
            $offset = 1;
            $position = (($offset-1) * $this->limit);
         
            $result = $db_home->get_all_profile_list($position);
            $count  = count($result);    

            $choice = $count / $this->limit;
            $pages  = floor($choice)+1;

            echo json_encode(array('pages'=>$pages,'list'=>$result));
        } else {
            echo 'Error!';
        }        
    }

    // Function for editing profile    
    public function action_update_profile() {
        $db_home    = Model::factory('home');

        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';  
        
        $id         = $this->request->post('id');
        $title      = $this->request->post('title');
        $filename   = $this->request->post('filename');
        $photo_old  = $this->request->post('photo_old');
        $img_url    = ($filename!=='')?'/assets/img/upload/'.$filename:'';
        
        $result = $db_home->update_profile($id, $title, $filename, $img_url);
        if ($result){          
            //Delete old Image
            if ($filename!==''){      
                $path = APPPATH . '../assets/img/upload/' . $photo_old;
                try { unlink($path); } catch(Exception $e) {}
            }

            $offset = 1;
            $position = (($offset-1) * $this->limit);
         
            $result = $db_home->get_all_profile_list($position);
            $count  = count($result);    

            $choice = $count / $this->limit;
            $pages  = floor($choice)+1;

            echo json_encode(array('pages'=>$pages,'list'=>$result));
        } else {
            echo 'Error!';
        }        
    }

    // Function for deleting profile   
    public function action_delete_profile() {
        $db_home    = Model::factory('home');

        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';  
        
        $id     = $this->request->post('id');
        $file   = $this->request->post('file');

        $result = $db_home->delete_profile($id);
        if ($result){
            $path   = APPPATH . '../assets/img/upload/' . $file;
            try { unlink($path); } catch(Exception $e) {}
            
            $offset = 1;
            $position = (($offset-1) * $this->limit);
         
            $result = $db_home->get_all_profile_list($position);
            $count  = count($result);    

            $choice = $count / $this->limit;
            $pages  = floor($choice)+1;

            echo json_encode(array('pages'=>$pages,'list'=>$result));
        } else {
            echo 'Error!';
        }        
    }


    // Function for searching profile   
    public function action_search_profile() {
        $db_home    = Model::factory('home');

        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';  
        
        $offset = $this->request->post('offset');
        $search = $this->request->post('search');
        $position = (($offset-1) * $this->limit);

        $result = $db_home->search_profile_list($position,$search);
        $count  = count($result);    

        $choice = $count / $this->limit;
        $pages  = floor($choice)+1;
        
        echo json_encode(array('pages'=>$pages,'list'=>$result));
    }

    // Function for pagination profile   
    public function action_get_profile_all() {
        $db_home    = Model::factory('home');

        $this->template->header     = '';  
        $this->template->content    = ''; 
        $this->template->footer     = ''; 
        $this->template->script     = '';          

        $offset = $this->request->post('offset');
        $position = (($offset-1) * $this->limit);
     
        $result = $db_home->get_all_profile_list($position);
        $count  = count($result);    

        $choice = $count / $this->limit;
        $pages  = floor($choice)+1;

        echo json_encode(array('pages'=>$pages,'list'=>$result));
    }


}