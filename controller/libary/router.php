<?php
class controller_libary_router
{
    const PARAM_NAME = "r";
    const HOME_PAGE = "view/home";
    const INDEX_PAGE = "index";
    public static $sourcePath;
    public function __construct($sourcePath = "")
    {
        # code...
        if ($sourcePath) {
            self::$sourcePath = $sourcePath;
        }
    }
    public function getGet($name = NULL)
    {
        # code...
        if ($name !== NULL) {
            return isset($_GET[$name]) ? $_GET[$name] : NULL;
        } else {
            return $_GET;
        }
    }
    public function getPOST($name)
    {
        # code...
        if ($name !== NULL) {
            return isset($_POST[$name]) ? $_POST[$name] : NULL;
        } else {
            return $_POST;
        }
    }
    public function router()
    {
        # code...
        $url = $this->getGet(self::PARAM_NAME);
        // var_dump($url) ;
        // die();
        if (!is_string($url) || !$url || $url == self::INDEX_PAGE) {
            $url = self::HOME_PAGE;
        }
        $path = self::$sourcePath . "/" . $url . ".php";
        // var_dump($path);
        // die();
        if (file_exists($path)) {
            return require_once $path;
        } else {
            // var_dump($url);
            // var_dump($path);
            return $this->pageNotFound();
        }
    }
    public function pageNotFound()
    {
        # code...
        echo "<h1>404-Page Not Found hehe</h1>";
        die();
    }
    public function createUrl($url, $params = [])
    {
        # code...
        if ($url) {
            $params[self::PARAM_NAME] = $url;
        }
        return $_SERVER['PHP_SELF'].'?'.http_build_query($params);
    }
    public function redirect($url)
    {
        # code...
        $u = $this->createUrl($url);
        header("Location:$u");
    }
    public function homePage()
    {
        # code...
        $this->redirect(self::HOME_PAGE);
    }
    public function loginPage()
    {
        # code...
        $this->redirect("view/auth/login");
    }
    public function createUser()
    {
        # code...
        $this->redirect("view/auth/createUser");
    }
}
