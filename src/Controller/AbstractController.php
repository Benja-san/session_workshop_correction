<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

use App\Model\UserManager;

abstract class AbstractController
{
    protected Environment $twig;
    protected array|false $user = false;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        if(isset($_SESSION["user_id"])){
            $userManager = new UserManager();
            $this->user = $userManager->selectOneById($_SESSION["user_id"]);
            $this->twig->addGlobal('user', $this->user);
        }
    }
}
