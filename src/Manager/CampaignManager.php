<?php

namespace Mailjet\MailjetBundle\Manager;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\MailjetBundle\Client\MailjetClient;
use Mailjet\MailjetBundle\Exception\MailjetException;
use Mailjet\MailjetBundle\Model\Campaign;

/**
 * https://dev.mailjet.com/email-api/v3/campaign/
 * list/view/update
 */
class CampaignManager {

    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    public function __construct(MailjetClient $mailjet) {
        $this->mailjet = $mailjet;
    }

    /**
     * List campaigns resources available for this apikey
     * @return array
     */
    public function getAllCampaigns(array $filters = null) {
        $response = $this->mailjet->get(Resources::$Campaign, ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("CampaignDraftManager:getAllCampaigns() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Access a given campaign resource
     * @param string $id
     * @return array
     */
    public function findByCampaignId($id) {
        $response = $this->mailjet->get(Resources::$Campaign, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("CampaignManager:findByCampaignId() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific campaign resource with a PUT request, providing the campaign's ID value
     * @param string $id
     * @return array
     */
    public function updateCampaign($id, Campaign $campaign) {
        $response = $this->mailjet->get(Resources::$Campaign, ['id' => $id, 'body' => $campaign->format()]);
        if (!$response->success()) {
            $this->throwError("CampaignManager:updateCampaign() failed", $response);
        }

        return $response->getData();
    }

    private function throwError($title, Response $response) {
        throw new MailjetException(0, $title, $response);
    }

}
