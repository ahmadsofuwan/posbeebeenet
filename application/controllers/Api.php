<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends MY_Controller
{



    public function index()
    {
        //close item
        $item = $this->getDataRow('item', 'pkey,stock');
        foreach ($item as $itemKey => $itemValue) {
            $closeItem = array(
                'itemkey' => $itemValue['pkey'],
                'time' => strtotime('now'),
                'laststock' => $itemValue['stock'],
            );
            $this->insert('close', $closeItem);
        }
        $this->update('itemin', array('status' => 1), array('status' => 0));
        $this->update('itemout', array('status' => 1), array('status' => 0));
    }
}
