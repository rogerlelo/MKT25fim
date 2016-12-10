<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignSenderPageAction;
use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class CampaignSenderPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = $container->get(TemplateRendererInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $emailSender = $container->get(CampaignEmailSenderInterface::class);
        return new CampaignSenderPageAction($template,$router,$form,$repository,$emailSender);
    }
}
