<?php
require 'config.php';
require_once 'vendor/autoload.php';
require_once 'class-templaterenderer.php';

class Hay {
    const DEFAULT_TITLE = "Hay's tools";
    private $toolname, $tools, $tooldata, $title;
    private $description, $titletag, $path, $opts;

    public function __construct($toolname = false, $opts = []) {
        $this->path = realpath(dirname(__FILE__));
        $toolpath = $this->path . "/tools.json";
        $this->tools = json_decode(file_get_contents($toolpath));
        $this->renderer = new TemplateRenderer();
        $this->opts = $opts;

        if ($toolname) {
            $this->toolname = $toolname;
            $this->tooldata = $this->tools->$toolname;
            $this->title = $this->tooldata->title;
            $this->description = $this->tooldata->description;
            $this->titletag = $this->title . " - " . self::DEFAULT_TITLE;
        } else {
            $this->titletag = self::DEFAULT_TITLE;
        }
    }

    public function getTools() {
        // Remove all 'hidden' tools
        $tools = array();

        foreach ($this->tools as $tool => $data) {
            if (empty($data->hidden)) {
                $tools[$tool] = $data;
            }
        }

        return $tools;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function title() {
        echo $this->title;
    }

    public function description() {
        echo $this->description;
    }

    public function getUrl() {
        return ROOT . "/" . $this->toolname;
    }

    public function header() {
        echo $this->renderer->render("header", [
            'toolname' => $this->toolname,
            'title' => $this->title,
            'root' => ROOT,
            "opts" => $this->opts
        ]);
    }

    public function footer() {
        echo $this->renderer->render("footer", [
            "root" => ROOT,
            "opts" => $this->opts,
            "toolname" => $this->toolname
        ]);
    }
}