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
use UniversityOfCopenhagen\KuPhonebook\Service\PhonebookService;

//class PhonebookController
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
  /**
   * @var PhonebookService
   */
  protected $phonebookService;

  /**
     * @param PhonebookService $PhonebookService
     */
  public function injectPhonebookervice(PhonebookService $PhonebookService)
  {
    $this->PhonebookService = $PhonebookService;
  }

  public function phonebookSearchAction(): ResponseInterface
  {
    // Webservive endpoint is set in TYPO3 > Admin Tools > Settings > Extension Configuration
    $url = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ku_phonebook', 'uri');
    $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');

    $additionalOptions = [
        'format' => 'json',
        'startrecord' => '0',
        'recordsperpage' => '100',
        'searchstring' => 'nanna'//$query
    ];

    // Return response object
    //$response = $this->requestFactory->request($url, 'POST', $additionalOptions);
    $response = $this->requestFactory->request($url . '?format=json&startrecord=0&recordsperpage=100&searchstring=nanna', 'POST');

    // Get the content as a string on a successful request
    if ($response->getStatusCode() === 200) {
      $content = $response->getBody()->getContents();
      debug($content);
      $this->view->assign('items', $content);

      return $this->htmlResponse();
    }
  }
}
