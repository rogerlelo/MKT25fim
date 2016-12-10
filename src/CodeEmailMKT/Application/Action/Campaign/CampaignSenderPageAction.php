<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Application\Form\HttpMethodElement;


class CampaignSenderPageAction
{
    private $template;
    private $router;
    private $form;
    private $repository;
    private $emailSender;


    public function __construct(
        TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form,
        CampaignRepositoryInterface $repository,
        CampaignEmailSenderInterface $emailSender
    ){
        $this->template = $template;
        $this->router = $router;
        $this->form = $form;
        $this->repository = $repository;
        $this->emailSender = $emailSender;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);
        //$this->form->add(new HttpMethodElement('PUT'));
        $this->form->bind($entity);
        if($request->getMethod() == 'POST'){
            $this->emailSender->setCampaign($entity);
            $this->emailSender->send();
            $flash = $request->getAttribute('flash');
            $flash->setMessage(FlashMessageInterface::MESSAGE_SUCCESS,'Campanha enviada com sucesso');
            $uri = $this->router->generateUri('campaign.list');
            return new RedirectResponse($uri);

        }
        return new HtmlResponse($this->template->render("app::campaign/sender",[
            'form' => $this->form
        ]));

    }
}
