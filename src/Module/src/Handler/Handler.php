<?php

declare(strict_types=1);

namespace Module\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class Handler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $modelObj;
    // private $config;

    public function __construct(
        TemplateRendererInterface $renderer,
        FirstModel $model
        // $config 
        )
    {
        $this->renderer = $renderer;
        $this->modelObj = $model;
        // $this->config = $config;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $result = $this->modelObj->getDbObj(false);
        echo "<pre>";
        print_r($result);die;

        $path = $request->getUri()->getPath();
        //  echo '<pre>';
        // print_r($this->config);die;
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
       
        // Do some work...
        // Render and return a response:
        // return new HtmlResponse($this->renderer->render(
        //     'module::about',
        //     [] // parameters to pass to template
        // ));
    }
}
