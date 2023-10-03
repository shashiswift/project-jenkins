<?php

class User_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function checkLogin($post)
    {

        $post['password'] = md5($post['password']);
        $post['users.status'] = '1';
        $post['roles.status'] = '1';

        $query = $this->db->select('users.*,roles.role_id,roles.name')
            ->from('users')
            ->join('roles', 'users.role_id = roles.role_id')
            ->where($post)
            ->get();
        
        if ($query->num_rows() == 1) {
            $userInfo = $query->row();
            $this->updateLoginTime($userInfo->id);
            $this->permission($userInfo->role_id);
        } else {
            error_log('Unsuccessful login attempt(' . $post['email'] . ')');
            return false;
        }

        unset($userInfo->password);
        return $userInfo;
    }

    public function updateLoginTime($id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        return;
    }

    public function permission($role_id)
    {
        $this->db->select('(CONCAT(functions.controller_name,"/",functions.function_name)) as function1');
        $this->db->join('functions','FIND_IN_SET(functions.function_id,set_permission.function_id) <> 0', 'left', false);
        $this->db->where('set_permission.role_id',$role_id);
        $result = $this->db->get('set_permission');
       // echo $this->db->last_query(); exit;
        if ($result->num_rows() > 0) {            
            $result = $result->result();
            $dummy = array();
            foreach ($result as $key => $value) {
                $dummy[]=$value->function1;
            }
            $this->session->set_userdata('permission',$dummy);
        }
        
    }

    public  function get_user_list($per_page, $page, $search, $where, $count =NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('users.id','DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(users.email)',$search);
            $this->db->or_like('LOWER(concat(users.first_name," ",users.last_name))',$search);
            $this->db->group_end();
        }
        $this->db->select('users.*,mst_country.country_name,roles.name');
        $this->db->join('roles', 'roles.role_id=users.role_id', 'left');
        $this->db->join('mst_country', 'mst_country.country_id=users.default_country', 'left');
        $result = $this->db->get('users');
        if ($count == '1') {
            return $result->num_rows();
        } else {
            if ($result->num_rows() > 0) {
                return $result->result();
            } else {
                return false;
            }
        }
    }

}
