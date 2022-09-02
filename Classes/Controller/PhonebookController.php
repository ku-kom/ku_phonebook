<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPhonebook\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class PhonebookController extends ActionController
{
  /**
   * Initiate the RequestFactory, which allows to run multiple requests
   * (prefer dependency injection)
   */
  public function __construct(
    private readonly RequestFactory $requestFactory,
  ) {
  }

  public function phonebookSearchAction(): void//ResponseInterface
  {
    // Webservive endpoint url is set in TYPO3 > Admin Tools > Settings > Extension Configuration
    $url = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ku_phonebook', 'uri');

    // Get query from POST
    $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');

    $additionalOptions = [
      'debug' => true,
      'form_params' => [
        'format' => 'json',
        'startrecord' => '0',
        'recordsperpage' => '100',
        'searchstring' => 'nanna'//$query
      ]
    ];

    // Return response object
    $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

    // Get the content on a successful request
    if ($response->getStatusCode() === 200) {
      if (false !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
        $content = $response->getBody()->getContents();
        $json_response = json_decode($content);
        $body = json_decode($response->getBody()->getContents(), true);

        debug($content);
        debug($response->getBody());
        debug($json_response);
        debug($body);

        //$this->view->assign('employee', $content);

        //return $this->htmlResponse();
      }
    }
  }

  protected function processResponse($json): array
  {
    //debug($json);
    // foreach ($json->root->employees as $employee) {
    //   debug($employee['PERSON_FORNAVN']);
    // }
    //return [];
  }
}
