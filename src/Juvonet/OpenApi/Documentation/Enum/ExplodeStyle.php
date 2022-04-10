<?php

namespace Juvonet\OpenApi\Documentation\Enum;

/**
 * Parameter explode style.
 */
enum ExplodeStyle: string
{
    case DEEP_OBJECT = 'deepObject';
    case FORM = 'form';
    case LABEL = 'label';
    case MATRIX = 'matrix';
    case PIPE_DELIMITED = 'pipeDelimited';
    case SIMPLE = 'simple';
    case SPACE_DELIMITED = 'spaceDelimited';
}
