<?php

declare(strict_types=1);

/*
 * This file is part of the package vhs.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPhonebook\ViewHelpers;

use UniversityOfCopenhagen\KuPhonebook\Traits\TemplateVariableViewHelperTrait;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class PregReplaceViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    use TemplateVariableViewHelperTrait;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'string', 'String to match with the regex pattern or patterns');
        $this->registerArgument('pattern', 'string', 'Regex pattern to match against', true);
        $this->registerArgument('replacement', 'string', 'String to replace matches with', true);
        $this->registerAsArgument();
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $subject = isset($arguments['as']) ? $arguments['subject'] : ($arguments['subject'] ?? $renderChildrenClosure());
        $value = preg_replace($arguments['pattern'], $arguments['replacement'], $subject);
        return static::renderChildrenWithVariableOrReturnInputStatic(
            $value,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}