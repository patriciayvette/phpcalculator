<?php

namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

interface CommandHistoryManagerInterface
{
    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function findAll(): array;

    /**
     * Log command data to storage.
     *
     * @param mixed $command The command to log.
     *
     * @return bool Returns true when command is logged successfully, false otherwise.
     */
    public function log($command): bool;

    /**
     * Clear all data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function clearAll():bool;

     /**
     * Returns array of command history with filtered commands.
     *
     * @param array $command Array of command to filter.
     * 
     * @return array
     */
    public function findHistoryWithFilter($command): array;
}
