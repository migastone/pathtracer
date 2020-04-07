<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $tableName = '';

    function __construct() {
        parent::__construct();
    }

    public function get_rows($table, $filters = array()) {
        $this->db->from($table);
        if (isset($filters['select']))
            $this->db->select($filters['select']);
        if (isset($filters['where']))
            $this->db->where($filters['where']);
        if (isset($filters['or_where']))
            $this->db->or_where($filters['or_where']);
        if (isset($filters['where_not_in']))
            $this->db->where_not_in($filters['where_not_in']['field'], $filters['where_not_in']['data']);
        if (isset($filters['where_in']))
            $this->db->where_in($filters['where_in']['field'], $filters['where_in']['data']);
        if (isset($filters['like']))
            $this->db->like($filters['like']);
        if (isset($filters['like_after']))
            $this->db->like($filters['like_after']['field'], $filters['like_after']['match'], 'after');
        if (isset($filters['groupby']))
            $this->db->group_by($filters['groupby']);
        if (isset($filters['orderby']))
            $this->db->order_by($filters['orderby']['field'], $filters['orderby']['order']);

        if (isset($filters['muilti_orderby']))
            $this->db->order_by($filters['muilti_orderby']);
        if (isset($filters['join'])) {
            foreach ($filters['join'] as $key => $join) {
                $this->db->join($join['table'], $join['condition'], isset($join['type']) ? $join['type'] : NULL);
            }
        }
        if (isset($filters['limit']))
            $this->db->limit($filters['limit']['limit'], $filters['limit']['from']);
        if (isset($filters['row'])) {
            if ($filters['row'] == 2)
                return $this->db->get()->row_array();
            else
                return $this->db->get()->row();
        }
        else {
            if (isset($filters['result']))
                return $this->db->get()->result_array();
            else
                return $this->db->get()->result();
        }
    }

    public function update_table($data, $where = '', $table = '') {
        if (!empty($where))
            $this->db->where($where);
        if (!empty($table))
            $this->db->update($table, $data);
        else
            $this->db->update($this->tableName, $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    public function insert($data, $table = '') {
        if (!empty($table))
            $this->db->insert($table, $data);
        else
            $this->db->insert($this->tableName, $data);
        return $this->db->insert_id();
    }

    public function delete_record($where = '', $table = '') {
        if (!empty($where)) {
            $this->db->where($where);
            if (!empty($table))
                $this->db->delete($table);
            else
                $this->db->delete($this->tableName);
            if ($this->db->affected_rows() > 0)
                return true;
            else
                return false;
        }
    }

    public function data_count($query, $table = '') {
        if (isset($query['select']))
            $this->db->select($query['select']);
        if (isset($query['where']))
            $this->db->where($query['where']);
        if (isset($query['where_in']))
            $this->db->where_in($query['where_in']['field'], $query['where_in']['data']);
        if (isset($query['join'])) {
            foreach ($query['join'] as $key => $join) {
                $this->db->join($join['table'], $join['condition'], isset($join['type']) ? $join['type'] : NULL);
            }
        }
        if (isset($query['where_not_in']))
            $this->db->where_not_in($query['where_not_in']['field'], $query['where_not_in']['data']);
        if (!empty($table))
            $this->db->from($table);
        else
            $this->db->from($this->tableName);

        if (isset($query['groupby']))
            $this->db->group_by($query['groupby']);


        return $this->db->get()->num_rows();
    }

    public function get_roles() {
        $query = $this->db->query('select id, role from users_roles');
        return $query->result();
    }

}

/* Location: ./application/core/MY_Model.php */
