<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public  function get_role_list($per_page, $page = 0, $search, $where, $count = NULL)
    {
        if ($per_page != NULL || $page != NULL) {
            $this->db->limit($per_page, $page);
        }
        $this->db->order_by('roles.role_id', 'DESC');
        if (!empty($where)) {
            $this->db->group_start();
            $this->db->where($where);
            $this->db->group_end();
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(roles.name)', $search);
            $this->db->group_end();
        }
        $this->db->select('*');
        $this->db->from('roles');
        $result = $this->db->get();
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
    public function fetch_controller()
    {
        $query = $this->db->distinct()->select('controller_name')->get('functions');
        if ($query->result())
            return $query->result();
        else
            return false;
    }

    public function fetch_functions($post)
    {
        $query = $this->db->distinct('function_name')->get_where('functions',$post);
        if ($query->result())
            return $query->result();
        else
            return false;
    }
    public function fetch_permission($post)
    {
        $data = array();
        $query = $this->db->select('function_id')->where($post)->get('set_permission');
        if ($query->row_array()) {
            $result = $query->row_array();
            $data = explode(',', $result['function_id']);
            return $data;
        } else
            return false;
    }
    public function save_permission($roleID, $functionID)
    {
        $data = array('role_id' => $roleID, 'function_id' => $functionID);
        $prev_perm_id = $this->db->select('permission_id')->where('role_id', $roleID)->get('set_permission')->row_array();
        if ($prev_perm_id) {
           $update = $this->db->update('set_permission', $data, ['permission_id'=>$prev_perm_id['permission_id']]);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            $query = $this->db->insert('set_permission', $data);
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }
}
