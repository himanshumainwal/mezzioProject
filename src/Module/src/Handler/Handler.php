<?php

declare(strict_types=1);

namespace Module\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Db\Sql\Sql;
use Mezzio\Helper\UrlHelper;
use Laminas\Db\Adapter\AdapterInterface;


class Handler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $helper;
    private $dbAdapter;

    public function __construct(
        TemplateRendererInterface $renderer,
        UrlHelper $helper,
        AdapterInterface $dbAdapter,
    ) {
        $this->renderer = $renderer;
        $this->helper = $helper;
        $this->dbAdapter = $dbAdapter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        $routeParams = [
            'data' => '/here'
        ];
        $sql = new Sql($this->dbAdapter);

        if ($request->getMethod() == 'POST') {
            $formData = $request->getParsedBody();
            // Check if the request is for registration
            if ($path == '/register') {
                if (empty($formData['fName']) || empty($formData['email']) || empty($formData['pass']) || empty($formData['confirmPass']) || empty($formData['mobileNumber'])) {

                    return new HtmlResponse('<script>
                                                alert("Please fill in all required fields");
                                                window.location.href = "/register"; // Redirect to the register page
                                            </script>');
                }
                $name = $formData['fName'];
                $email = $formData['email'];
                $pass = $formData['pass'];
                $confPass = $formData['confirmPass'];
                $mobileNo = $formData['mobileNumber'];

                if ($pass !== $confPass) {
                    $content = '
                                <script>
                                    alert("Password does not match");
                                    window.location.href = "/register"; // Redirect to the register page
                                </script>
                            ';
                    return new HtmlResponse($content);
                }
                $insert = $sql->insert('mezzio_pro');
                $insert->values([
                    'full_name' => $name,
                    'email' => $email,
                    'password' => $pass,
                    'mobile_number' => $mobileNo,
                ]);

                $statement = $sql->prepareStatementForSqlObject($insert);
                $statement->execute();
                return new RedirectResponse(
                    $this->helper->generate('login', $routeParams)
                );
            } 
            // ////////////////////////////////////////Login/////////////////////////////////////////////////////
            // print_r($path);
            // die();
            if ($path == '/login') {
                if (empty($formData['email']) || empty($formData['pass'])) {
                    $content = '
                                <script>
                                    alert("Please fill in all required fields");
                                    window.location.href = "/login"; // Redirect to the register page
                                </script>
                            ';
                    return new HtmlResponse($content);
                }

                $email = $formData['email'];
                $password = $formData['pass'];

                $sql = new Sql($this->dbAdapter);
                $select = $sql->select('mezzio_pro');
                // Add a WHERE condition to filter by email
                $select->where(['email' => $email, 'password' => $password]);

                // Prepare the SQL statement and execute it
                $statement = $sql->prepareStatementForSqlObject($select);
                $result = $statement->execute();

                // Fetch the user record
                $user = $result->current();

                // Check if a user with the provided email exists and if the password matches
                if ($user !== null && ($email == $user['email'] && $password == $user['password'])) {
                    // Password matches, redirect the user to the home page
                    return new HtmlResponse($this->renderer->render('app::home-page', ['user' => $user]));
                    // return new HtmlResponse($this->renderer->render('app::home-page'));
                } else {
                    // Email or password does not match, display an error message
                    $content = '
                                <script>
                                    alert("Email or password does not match");
                                    window.location.href = "/login"; // Redirect to the register page
                                </script>
                            ';
                    return new HtmlResponse($content);
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
