<?php

class Billing_model extends CI_Model
{
    public function getResources() {
        $query = 'select re.*, cl.name as clname, cl.code as clcode, rg.name as rgname, rg.code as rgcode, ty.type as tyname
    from `resources` re
    inner join `clouds` cl
    on re.id_cloud = cl.id
    inner join `regions` rg
    on re.id_region = rg.id
    inner join `resource_type` ty
    on re.id_type = ty.id
    where id_user = ' . $this->session->userdata('id');
        
        return $this->db->query($query)->result();
    }
}

