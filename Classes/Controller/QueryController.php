<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPhonebook;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;

class QueryController
{
    // Initiate the RequestFactory, which allows to run multiple requests
    // (prefer dependency injection)
    public function __construct(
        private readonly RequestFactory $requestFactory,
    ) {
    }

    public function handle(): void
    {
        $url = 'https://www2.adm.ku.dk/selv/pls/!app_tlfbog_v2.soeg';
        $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');

        // See: https://docs.guzzlephp.org/en/stable/request-options.html
        $additionalOptions = [
            'form_params' => [
                'format' => 'json',
                'startrecord' => '0',
                'recordsperpage' => '100',
                'searchstring' => $query
            ]
        ];

        // Return a PSR-7 compliant response object
        $response = $this->requestFactory->request($url, 'POST', $additionalOptions);

        if ($response->getStatusCode() === 200) {
            $content = $response->getBody()->getContents();
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($content);
        }
    }
}
