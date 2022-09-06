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

  public function phonebookSearchAction(): ResponseInterface
  {
    // Webservive endpoint url is set in TYPO3 > Admin Tools > Settings > Extension Configuration
    $url = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ku_phonebook', 'uri');

    // Get query from POST
    $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');

    $additionalOptions = [
      //'debug' => true,
      'form_params' => [
        'format' => 'json',
        'startrecord' => '0',
        'recordsperpage' => '100',
        'searchstring' => 'nanna'//$query
      ]
    ];

    // Return response object:
    // https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Http/Index.html
    // https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/11.0/Deprecation-92784-ExtbaseControllerActionsMustReturnResponseInterface.html
    
    $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

    //Get the content on a successful request
    if ($response->getStatusCode() === 200) {
      if (false !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
        $string = $response->getBody()->getContents();
        // getContents() returns a string
        // Convert string to json
        $string = iconv('ISO-8859-1', 'UTF-8', $string);
        $data = json_decode((string) $string, true);

        //debug($data);

        //$this->phonebookService->processResponse($data);

        $this->view->assign('employee', $data['root']['employees']);

        return $this->htmlResponse();
      }
    }
  }
}
