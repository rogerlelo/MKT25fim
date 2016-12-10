<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSender implements CampaignEmailSenderInterface
{
    private $campaign;
    private $templateRenderer;
    private $mailGunConfig;
    private $mailgun;
    private $repository;

    public function __construct(TemplateRendererInterface $templateRenderer,
                                Mailgun $mailgun, array $mailGunConfig, CustomerRepositoryInterface $repository)
    {

        $this->templateRenderer = $templateRenderer;
        $this->mailGunConfig = $mailGunConfig;
        $this->mailgun = $mailgun;
        $this->repository = $repository;
    }


    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function send()
    {
        $this->createCampaign();////////////////////////////////////
        $batchMessage = $this->getBatchMessage();

        $tags = $this->campaign->getTags()->toArray();
        foreach ($tags as $tag) {
            $batchMessage->addTag($tag->getName());
        }

        $customers = $this->repository->findByTags($tags);
        foreach ($customers as $customer){
                $name = (!$customer->getName() or $customer->getName() == '')? $customer->getEmail(): $customer->getName();//$name = (!$customer->getName() or $customer->getName == '')? $customer->getEmail: $customer->getName();
                $batchMessage->addToRecipient($customer->getEmail(), ['full_name' => $name]);
        }

        $batchMessage->finalize();
    }

    protected  function getBatchMessage()
    {
        $batchMessage = $this->mailgun->BatchMessage($this->mailGunConfig['domain']);
        $batchMessage->addCampaignId("campaign_{$this->campaign->getId()}");//permite no max 3 campanhas
        $batchMessage->setFromAddress('rogeriodesouzaantonio@gmail.com', ['full_name' => 'Rsa']);
        $batchMessage->setSubject($this->campaign->getSubject());
        $batchMessage->setHtmlBody($this->getHtmlBody());
        //$batchMessage->setTextBody('string'); //só para textos
        return $batchMessage;
    }

    protected function getHtmlBody()
    {
        $template = $this->campaign->getTemplate();
        return $this->templateRenderer->render('app::campaign/_campaign_template',[
            'content' => $template
        ]);
    }

    protected function createCampaign()
    {
        $domain = $this->mailGunConfig['domain'];
        try {
            //echo '<pre>'; print_r($this->mailgun->get("$domain/campaigns"));die();///////////////mostra se tem campanhas
            //echo '<pre>'; print_r($this->mailgun->delete("$domain/campaigns/{id da campanha registrada no Mailgun}"));die();/////exclui a campanha
            //$this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");//para não criar outra campanha
        }catch (MissingEndpoint $ex){
            $this->mailgun->post("$domain/campaigns",[
                'id' => "campaign_{$this->campaign->getId()}",
                'name' => $this->campaign->getName()
            ]);
        }
    }
}