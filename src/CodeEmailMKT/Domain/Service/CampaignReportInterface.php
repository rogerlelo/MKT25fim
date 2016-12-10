<?php

namespace CodeEmailMKT\Domain\Service;

use CodeEmailMKT\Domain\Entity\Campaign;

interface CampaignReportInterface
{
    public function setCampaign(Campaign $campaign);
    public function render();
}