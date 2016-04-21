<?php

class Quarterly_cron extends Application {

    function __construct()
    {
        parent::__construct();

        $this->load->model(array("childrenclass", "historyclass", "parentsclass"));
    }

    public function quarterlyReminder( $p )
    {
        $children = $this->childrenclass->getChildInfoByParent( $p['parent_id'] );
        $aid = 0;

        $this->db->select('advisor_id');
        $this->db->where('parent_id', $p['parent_id']);
        $result = $this->db->get('parentsclass');
        $r = $result->row();
        if (!empty($r->advisor_id))
        {
            $aid = $r->advisor_id;
        }


        foreach( $children as $k => $c )
        {
            if( strtolower($c['gender']) == "male" )
            {
                $sex1 = "his";
            }
            else
            {
                $sex1 = "her";
            }

            $cname = reset(explode(" ", $c['user_full_name']));

            $info = array(
                "name" 	=> reset(explode(" ", $p['user_full_name'])),
                "cname" => $cname,
                "spa"	=> number_format($c['spend_amount'], 2),
                "saa"	=> number_format($c['save_amount'], 2),
                "gia"	=> number_format($c['give_amount'], 2),
                "sex1"  => $sex1,
            );

            sendNotification($cname."'s Dragon Bank Quarterly Reminder!", quarterlyMsg($info, $aid), $p['user_email'] );
        }
    }

    function index()
    {
        $p = $this->parentsclass->getParentsReminder();

        foreach($p as $k => $v)
        {
            $pid = (int)$v['parent_id'];	// Parent id.

            $this->quarterlyReminder( $v );
        }
    }
}