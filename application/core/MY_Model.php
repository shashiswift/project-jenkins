<?php

class MY_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db->trans_start();
    }
    public function __destruct()
    {
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }
    public function update_row($table, $post, $where)
    {
        $update = $this->db->update($table, $post, $where);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    public function insert_multi_data($table, $data)
    {
        $insert = $this->db->insert_batch($table, $data);
        if ($insert) {
            return TRUE;
        } else {
            return false;
        }
    }
    public function delete_data($table, $where)
    {
        $reusult = $this->db->delete($table, $where);
        if ($reusult) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function get($field = '*', $table, $where = NULL)
    {
        $this->db->select($field);
        if ($where != NULL) {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        if ($get) {
            return $get->row();
        } else {
            return FALSE;
        }
    }
    public function get_result($field = '*', $table, $where = NULL)
    {
        $this->db->select($field);
        if ($where != NULL) {
            $this->db->where($where);
        }
        $get = $this->db->get($table);
        if ($get) {
            return $get->result();
        } else {
            return FALSE;
        }
    }
    public function getResultGroup($field = '*', $table, $where = NULL,$group=NULL)
    {
        $this->db->select($field);
        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($group != NULL) {
            $this->db->group_by($group);
        }
        $get = $this->db->get($table);
        if ($get) {
            return $get->result();
        } else {
            return FALSE;
        }
    }
    public function insert_data($table, $data = array())
    {
        $insert = $this->db->insert($table, $data);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    public function fetch_country()
    {
        $this->db->select('country_id, country_name');
        $this->db->order_by("country_name", "ASC");
        $query = $this->db->get('mst_country');
        if ($query->result())
            return $query->result();
        else
            return false;
    }
    public function like_result($table, $select, $like, $where = NULL)
    {
        $this->db->select($select);
        if ($like && count($like)>0) {
            $sn = 0;
            foreach ($like as $key => $value) {
                if ($sn < 1) {
                    $this->db->like($key,$value);
                }else{
                    $this->db->or_like($key,$value);
                }
                $sn++;
            }    
        }
        if ($where && count($where)>0) {
            $this->db->where($where);
        }
        $result = $this->db->get($table);
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function gmark_registration_log($id,$text)
    {
        $data =array(
            'gmark_registration_id'=>$id,
            'text'=>$text,
            'created_by'=>$this->session->userdata('user_data')->id
        );
        $this->db->insert('gmark_request_log', $data);
        $this->total_log($text);
    }

    public function total_log($text)
    {
        $data =array(
            'desc'=>$text,
            'created_by'=>$this->session->userdata('user_data')->id
        );
        $this->db->insert('gmark_log_all_users', $data);
    }
    public function status_update($reg_id, $reg_status)
    {
        $request = $this->db->select('reg_status')->where(['registration_id' => $reg_id])->get('gmark_registration')->row();
        if ($request && ($request->reg_status <= $reg_status)) {
            $update  = $this->db->update('gmark_registration', ['reg_status' => $reg_status], ['registration_id' => $reg_id]);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
