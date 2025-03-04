<?php

namespace App\Libraries;

use Illuminate\Mail\Mailables\Address;

class Email {

    public function get_recipients(object $data)
    {
        $ret = [];

        foreach($data as $info)
        {
            $ret[] = new Address($info->email, $info->name);
        }

        return $ret;
    }
}