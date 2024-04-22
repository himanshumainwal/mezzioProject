<?php

declare(strict_types=1);

namespace Module\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Module\Handler\FirstModel;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;



class Handler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $modelObj;
    private $helper;
    // private $config;

    public function __construct(
        TemplateRendererInterface $renderer,
        FirstModel $model,
        UrlHelper $helper
        // $config 
    ) {
        $this->renderer = $renderer;
        $this->modelObj = $model;
        $this->helper = $helper;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $routeParams = [
            'data' => '/here'
        ];
        $path = $request->getUri()->getPath();

        // Handle form submission only if it's a POST request
        if ($request->getMethod() == 'POST') {
            // print_r($request->getMethod());die;
            $formData = $request->getParsedBody();
            // Check if the request is for registration
            if ($path == '/register') {
                // Check if any required field is empty
                if (empty($formData['fName']) || empty($formData['email']) || empty($formData['pass']) || empty($formData['confirmPass']) || empty($formData['mobileNumber'])) {
                    return new HtmlResponse($this->modelObj->redirectPage('Please fill in all required fields','register'));
                }
                $name = $formData['fName'];
                $email = $formData['email'];
                $pass = $formData['pass'];
                $confPass = $formData['confirmPass'];
                $mobileNo = $formData['mobileNumber'];

                if ($pass !== $confPass) {
                    return new HtmlResponse($this->modelObj->redirectPage('Password does not match','register'));
                }
                $result = $this->modelObj->addUser($name, $email, $pass, $mobileNo);
                if ($result) {
                    return new RedirectResponse(
                        $this->helper->generate('login', $routeParams)
                    );
                } else {
                    return new HtmlResponse($this->modelObj->redirectPage('Somthing wrong, Please Recheck','register'));
                }
            }

            // Handle form submission only if it's a POST request
            if ($path == '/login') {
                if (empty($formData['email']) || empty($formData['pass'])) {
                    return new HtmlResponse($this->modelObj->redirectPage('Please fill in all required fields','login'));
                }

                $email = $formData['email'];
                $password = $formData['pass'];
                // Query the database to fetch the user record based on the provided email
                $user = $this->modelObj->verifiedUser($email, $password);

                // Check if a user with the provided email exists and if the password matches
                if ($user !== null && $password == $user['password']) {
                    // Password matches, redirect the user to the home page
                    return new HtmlResponse($this->renderer->render('app::home-page', ['user' => $user]));
                    // return new HtmlResponse($this->renderer->render('app::home-page'));
                } else {
                    // Email or password does not match, display an error message
                    return new HtmlResponse($this->modelObj->redirectPage('Email or password does not match','login'));
                }
            }
        }

        switch ($path) {
            case '/about':
                return new HtmlResponse($this->renderer->render('module::about'));
            case '/login':
                return new HtmlResponse($this->renderer->render('module::login'));
            case '/register':
                return new HtmlResponse($this->renderer->render('module::register'));
            default:
                // Handle other routes (e.g., return a 404 response)
                return new HtmlResponse('Page not found', 404);
        }
    }
}
