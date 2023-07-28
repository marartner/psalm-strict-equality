<?php declare(strict_types=1);

namespace Marartner\PsalmStrictEquality\Hooks;

use Marartner\PsalmStrictEquality\Issue\NoStrictEquality;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Node\VirtualNode;
use Psalm\Plugin\EventHandler\AfterExpressionAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterExpressionAnalysisEvent;

final class StrictEqualityHook implements AfterExpressionAnalysisInterface
{
    public static function afterExpressionAnalysis(AfterExpressionAnalysisEvent $event): ?bool
    {
        $expr = $event->getExpr();
        $statements_source = $event->getStatementsSource();

        if ($expr instanceof VirtualNode) {
            return true;
        }

        if ($expr instanceof Equal) {
            IssueBuffer::accepts(
                new NoStrictEquality(
                    'Do not use the == operator to compare values, use === instead.',
                    new CodeLocation($statements_source->getSource(), $expr)
                ),
                $statements_source->getSuppressedIssues()
            );
            return null;
        }

        if ($expr instanceof NotEqual) {
            IssueBuffer::accepts(
                new NoStrictEquality(
                    'Do not use the != operator to compare values, use !== instead.',
                    new CodeLocation($statements_source->getSource(), $expr)
                ),
                $statements_source->getSuppressedIssues()
            );
        }
        return null;
    }
}
