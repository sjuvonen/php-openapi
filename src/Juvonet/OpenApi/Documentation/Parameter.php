<?php

namespace Juvonet\OpenApi\Documentation;

use Juvonet\OpenApi\Documentation\Container\XData;
use Juvonet\OpenApi\Documentation\Enum\ExplodeStyle;
use Juvonet\OpenApi\Documentation\Extra\Ref;

final class Parameter
{
    public ExplodeStyle|null $style = null;

    public function __construct(
        public bool|null $allowEmptyValue = null,
        public bool|null $deprecated = null,
        public bool|null $explode = null,
        public bool|null $required = null,
        public mixed $example = null,
        public string|null $description = null,
        public string|null $in = null,
        public string|null $name = null,
        public string|null $parameter = null,
        #[\Juvonet\OpenApi\Serializer\Meta\PropertyName('$ref')]
        public string|null $ref = null,
        public AbstractSchema|null $schema = null,

        /**
         * When defined, the parameter will be replaced with a set of parameters
         * imported from the referenced schema.
         *
         * Options suchs as `in` will be used as template values and passed on
         * to the imported parameters.
         */
        public Ref|string|null $from = null,
        ExplodeStyle|string|null $style = null,
        array $x = [],
    ) {
        $this->x = new XData($x);

        if (is_string($style)) {
            $this->style = ExplodeStyle::from($style);
        } elseif ($style instanceof ExplodeStyle) {
            $this->style = $style;
        }
    }
}
