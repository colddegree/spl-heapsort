<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use ColdDegree\HeapSortedAscendingList;
use ColdDegree\IntList;
use ColdDegree\IsInt;
use ColdDegree\MyList;
use PHPUnit\Framework\Assert;

final class FeatureContext implements Context
{
    private bool $exceptionWasReceived = false;
    private MyList $list;
    private MyList $sortedList;

    /**
     * @Given /^list$/
     */
    public function list(TableNode $table): void
    {
        try {
            $this->list = IntList::fromStrings(...$this->tableToList($table));
        } catch (\DomainException $ignored) {
            $this->exceptionWasReceived = true;
        }
    }

    /**
     * @When /^I sort it$/
     */
    public function iSortIt(): void
    {
        if ($this->exceptionWasReceived) {
            throw new \RuntimeException('Can\'t sort list, exception was received');
        }
        $this->sortedList = new HeapSortedAscendingList($this->list);
    }

    /**
     * @Then /^I should have list$/
     */
    public function iShouldHaveList(TableNode $table): void
    {
        Assert::assertSame(
            $this->tableToInts($table),
            $this->sortedList->toArray(),
        );
    }

    /**
     * @When /^I instantiate it from strings$/
     */
    public function iInstantiateItFromStrings(): void
    {
        /**
         * Already done in {@see \FeatureContext::list}
         */
    }

    /**
     * @Then /^I should receive an exception$/
     */
    public function iShouldReceiveAnException(): void
    {
        Assert::assertTrue($this->exceptionWasReceived);
    }

    private function tableToList(TableNode $table): array
    {
        $rows = $table->getRows();
        if (count($rows) !== 1) {
            throw new \RuntimeException('Bad rows: ' . var_export($rows, true));
        }
        $list = reset($rows);
        $isEmptyList = static fn (array $row) => count($list) === 1 && reset($list) === '';
        return $isEmptyList($list) ? [] : $list;
    }

    /**
     * @return int[]
     */
    private function tableToInts(TableNode $table): array
    {
        $ints = [];
        foreach ($this->tableToList($table) as $el) {
            if (!(new IsInt($el))->toBool()) {
                throw new \RuntimeException("Bad element \"$el\"");
            }
            $ints[] = (int)$el;
        }
        return $ints;
    }
}
