<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Mailgun\Mailgun;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;

class CampaignReport implements CampaignReportInterface
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


    public function render()
    {
        return new HtmlResponse($this->templateRenderer->render('app::campaign/report',[
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCustomers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    protected function getCampaignData()
    {//modificado aula final
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        return $response->http_response_body;
    }

    protected function getCountOpenedDistinct()
    {
        $domain = $this->mailGunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}/opens",[
            'groupby' => 'recipient',
            'count' => true
        ]);
        return $response->http_response_body->count;
    }

    protected function getCountCustomers()
    {
        $tags = $this->campaign->getTags()->toArray();
        $customers = $this->repository->findByTags($tags);
        return count($customers);
    }

}