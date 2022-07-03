<?php

namespace SignNow\Serializer\Exclusion;

use SignNow\Serializer\Context;
use SignNow\Serializer\Expression\ExpressionEvaluatorInterface;
use SignNow\Serializer\Metadata\PropertyMetadata;
use SignNow\Serializer\SerializationContext;

/**
 * Exposes an exclusion strategy based on the Symfony's expression language.
 * This is not a standard exclusion strategy and can not be used in user applications.
 *
 * @internal
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class ExpressionLanguageExclusionStrategy
{
    /**
     * @var ExpressionEvaluatorInterface
     */
    private $expressionEvaluator;

    public function __construct(ExpressionEvaluatorInterface $expressionEvaluator)
    {
        $this->expressionEvaluator = $expressionEvaluator;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $navigatorContext)
    {
        if (null === $property->excludeIf) {
            return false;
        }

        $variables = [
            'context' => $navigatorContext,
            'property_metadata' => $property,
        ];
        if ($navigatorContext instanceof SerializationContext) {
            $variables['object'] = $navigatorContext->getObject();
        } else {
            $variables['object'] = null;
        }

        return $this->expressionEvaluator->evaluate($property->excludeIf, $variables);
    }
}
