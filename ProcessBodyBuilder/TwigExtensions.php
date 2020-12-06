<?php


namespace ProcessWire;

include_once __DIR__."/twig/vendor/autoload.php";
class TwigExtensions
{
    private $twig;
    private $page;
    public function __construct(\Twig\Environment $twig, Page $page)
    {
        $this->page = $page;



        $twig->addFilter('image', new Pageimage());
    }


    public function TwigImage($image){
        var_dump($image);
    }

}