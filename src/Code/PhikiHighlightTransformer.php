<?php

namespace Flux\Code;

use Phiki\Phast\ClassList;
use Phiki\Phast\Element;
use Phiki\Phast\Properties;
use Phiki\Phast\Text;
use Phiki\Token\HighlightedToken;
use Phiki\Transformers\AbstractTransformer;

class PhikiHighlightTransformer extends AbstractTransformer
{
    protected array $offsets = [];

    public function __construct(protected CodeHighlights $highlights) {}

    public function line(Element $span, array $tokens, int $index): Element
    {
        if ($this->highlights->includesLine($index + 1)) {
            $span->properties->get('class')->add('highlight', 'highlight-line');
        }

        if ($diff = $this->highlights->diff($index + 1)) {
            $span->properties->get('class')->add('diff', 'diff-'.$diff);
        }

        return $span;
    }

    public function token(Element $span, HighlightedToken $token, int $index, int $line): Element
    {
        $offset = $this->offsets[$line] ?? 0;
        $this->offsets[$line] = $offset + mb_strlen($token->token->text);
        $segments = $this->highlights->segments($token->token->text, $line + 1, $offset);
        $marker = $offset === 0 ? $this->highlights->diffMarker($line + 1) : null;

        if ($marker && str_starts_with($segments[0][0], $marker)) {
            $segments[0][0] = mb_substr($segments[0][0], 1);

            $span->children = [
                new Element('span', new Properties(['class' => new ClassList(['diff-marker'])]), [new Text($marker)]),
                ...$this->renderSegments($segments),
            ];

            return $span;
        }

        $hasHighlight = false;

        foreach ($segments as $segment) {
            if ($segment[1]) {
                $hasHighlight = true;
                break;
            }
        }

        if (! $hasHighlight) {
            return $span;
        }

        $span->children = $this->renderSegments($segments);

        return $span;
    }

    protected function renderSegments(array $segments): array
    {
        return array_map(function ($segment) {
            [$text, $highlighted] = $segment;
            $text = new Text(htmlspecialchars($text));

            return $highlighted
                ? new Element('span', new Properties(['class' => new ClassList(['highlight', 'highlight-characters'])]), [$text])
                : $text;
        }, $segments);
    }
}
