<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Application\Action\Campaign\CampaignListPageAction;


class CampaignListPageFactory
{
    public function __invoke(ContainerInterface $container) :CampaignListPageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $emailGun = $container->get(Mailgun::class);
        return new CampaignListPageAction($repository,$template,$emailGun);
    }
}
