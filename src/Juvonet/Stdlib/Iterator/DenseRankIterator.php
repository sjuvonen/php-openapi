<?php

namespace Juvonet\Stdlib\Iterator;

use Closure;
use Framework\Stdlib\Util\MultiKeyMap;

class DenseRankIterator extends TransformIterator
{
    private $ranks;
    private $valueFn;
    private $valueFields;

    public function __construct(iterable $items, array|Closure $rankFields)
    {
        parent::__construct($items, Closure::fromCallable([$this, 'denseRank']));

        if ($rankFields instanceof Closure) {
            $this->valueFn = $rankFields;
        } else {
            $this->valueFields = array_flip($rankFields);
        }
    }

    public function rewind(): void
    {
        parent::rewind();

        $this->ranks = [];
    }

    private function denseRank(mixed $item): array
    {
        if ($this->valueFn) {
            $values = ($this->valueFn)($item);
        } elseif (is_array($item)) {
            $values = array_intersect_key($item, $this->valueFields);
        } else {
            throw new \UnexpectedValueException('DenseRankIterator can only handle array items when not using a callback.');
        }

        $v = array_values($values);

        switch (count($values)) {
            case 1:
                $rank = $this->ranks[$v[0]] = $this->ranks[$v[0]] ?? count($this->ranks) + 1;
                break;

            case 2:
                $fallback = count($this->ranks[$v[0]] ?? []) + 1;
                $rank = $this->ranks[$v[0]][$v[1]] = $this->ranks[$v[0]][$v[1]] ?? $fallback;
                break;

            case 3:
                $fallback = count($this->ranks[$v[0]][$v[1]] ?? []) + 1;
                $rank = $this->ranks[$v[0]][$v[1]][$v[2]] = $this->ranks[$v[0]][$v[1]][$v[2]] ?? $fallback;
                break;

            case 4:
                $fallback = count($this->ranks[$v[0]][$v[1]][$v[2]] ?? []) + 1;
                $rank = $this->ranks[$v[0]][$v[1]][$v[2]][$v[3]] = $this->ranks[$v[0]][$v[1]][$v[2]][$v[3]] ?? $fallback;
                break;

            case 5:
                $fallback = count($this->ranks[$v[0]][$v[1]][$v[2]][$v[3]] ?? []) + 1;
                $rank = $this->ranks[$v[0]][$v[1]][$v[2]][$v[3]][$v[4]] = $this->ranks[$v[0]][$v[1]][$v[2]][$v[3]][$v[4]] ?? $fallback;
                break;

            default:
                throw new \OutOfBoundsException('Ranking is only supported using 1-5 values.');
        }

        return [$item, $rank];
    }
}
