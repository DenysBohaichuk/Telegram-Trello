<?php

namespace App\Services\Trello;

class TrelloCardService
{

    public function isCardMovedBetweenLists(array $data): bool
    {
        return isset($data['action']['type']) && $data['action']['type'] === 'updateCard' &&
            isset($data['action']['data']['listBefore'], $data['action']['data']['listAfter']);
    }

    public function isMovementBetweenInProgressAndDone(string $oldList, string $newList): bool
    {
        return ($oldList === 'InProgress' && $newList === 'Done') ||
            ($oldList === 'Done' && $newList === 'InProgress');
    }

    public function formatMovementMessage(string $cardName, string $oldList, string $newList): string
    {
        return "Картка \"{$cardName}\" була переміщена з колонки \"{$oldList}\" до колонки \"{$newList}\".";
    }

    public function checkCardMovement(array $data): ?string
    {
        if ($this->isCardMovedBetweenLists($data)) {
            $cardName = $data['action']['data']['card']['name'];
            $oldList = $data['action']['data']['listBefore']['name'];
            $newList = $data['action']['data']['listAfter']['name'];

            if ($this->isMovementBetweenInProgressAndDone($oldList, $newList)) {
                return $this->formatMovementMessage($cardName, $oldList, $newList);
            }
        }

        return null;
    }

}
