<?php

namespace App\Service;

class PaginationService
{
    private int $totalAmountItem;
    private int $maxItemOnPage;
    private int $numberSkipItem;

    public function __construct(int $totalAmountItem, $quantityOfItem, int $pageNumber)
    {
        $this->totalAmountItem = $totalAmountItem;
        $this->maxItemOnPage = $quantityOfItem === 'all' ? $totalAmountItem : (int)$quantityOfItem;
        $this->numberSkipItem = $pageNumber > 1 ? $pageNumber * $this->maxItemOnPage - $this->maxItemOnPage : 0;
    }

    public function getMaxItemOnPage(): int
    {
        return $this->maxItemOnPage;
    }

    public function getNumberSkipItem(): int
    {
        return $this->numberSkipItem;
    }

    public function getCountPages(): int
    {
        return ceil($this->totalAmountItem / $this->maxItemOnPage);
    }
}
