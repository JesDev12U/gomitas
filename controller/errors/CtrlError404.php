<?php
class CtrlError404
{
  private $vista = __DIR__ . "/../../view/errors/error404.php";
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];
  public $title = "404 Not Found";

  public function renderContent()
  {
    include $this->vista;
  }

  public function renderCSS()
  {
    echo "";
  }

  public function renderJS()
  {
    echo "";
  }
}
