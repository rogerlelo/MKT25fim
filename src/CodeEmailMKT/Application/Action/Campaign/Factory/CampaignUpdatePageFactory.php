<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Form\CampaignForm;
//use CodeEmailMKT\Application\Form\HttpMethodElement;
use Zend\Expressive\Router\RouterInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Application\Action\Campaign\CampaignUpdatePageAction;

class CampaignUpdatePageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignUpdatePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        //$form->add(new HttpMethodElement('PUT'));
        return new CampaignUpdatePageAction($repository,$template,$router,$form);
    }
}
