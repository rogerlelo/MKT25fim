<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignListPageAction
{
    private $template;
    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template , Mailgun $emailGun)
    {
        $this->template = $template;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaigns = $this->repository->findAll();
        $flash = $request->getAttribute('flash');
        return new HtmlResponse($this->template->render("app::campaign/list",[
            'campaigns'=> $campaigns,
            'message'=> $flash->getMessage(FlashMessageInterface::MESSAGE_SUCCESS)
        ]));

    }
}
