<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_prototype.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 * Sep 2022 Nanna Ellegaard, University of Copenhagen.
 */

namespace UniversityOfCopenhagen\KuPhonebook\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class PhoneNumberViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('phonenumber', 'string', 'The actual phone number', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        return self::getPhoneNumber($arguments['phonenumber']);
    }

    /**
     * Returns the phone number in an easy-to-read format
     *
     * @param string $phoneNumber
     * @return string
     */
    protected static function getPhoneNumber(string $phoneNumber): string
    {
        $data = $phoneNumber;

        if (preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $data, $matches)) {
            $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
            return 'test';
        }
    }
}
