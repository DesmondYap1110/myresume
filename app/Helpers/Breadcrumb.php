<?php

namespace App\Helpers;

class Breadcrumb
{
    protected $data = [];

    public function __construct()
    {
        $this->data = [
            "CurrentPage" => "",
            "isDashboard" => true,
            "CurrentUrl"  => "",
            "homeUrl"     => route("dashboard.view")
        ];
    }

    // Set default page
    public function setPage($name, $url)
    {
        $this->data["CurrentPage"] = $name;
        $this->data["CurrentUrl"] = $url;

        return $this;
    }

    // Add breadcrumb items
    public function add($text, $url = null)
    {
        $this->data["list"][] = [
            "text" => $text,
            "url"  => $url
        ];

        return $this;
    }

    public function get()
    {
        return $this->data;
    }
}
